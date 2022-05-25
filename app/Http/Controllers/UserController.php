<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = User::where('role','Student')->count();
        return view('admin.user.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'gender',
            3 => 'dob',
            4 => 'status',
            5 => 'created_at',
            6 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = User::where('role','Student')->count();
        $users  = User::select('users.*')->where('users.role','Student');

        if($request->input('search.value')){
            $users = $users->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('users.id','LIKE',"%{$search}%")
                            ->orWhere('users.first_name', 'LIKE',"%{$search}%")
                            ->orWhere('users.middle_name', 'LIKE',"%{$search}%")
                            ->orWhere('users.last_name', 'LIKE',"%{$search}%")
                            ->orWhere('users.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $users->count();
        if($order!="action"){
            $users   = $users->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $users   = $users->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($users))
        {   
            $i = $start;
            foreach ($users as $user)
            {
                $nestedData['id']              = ++$i;
                $nestedData['name']            = $user->first_name.' '.$user->middle_name.' '.$user->last_name;
                $nestedData['email']           = $user->email;
                $nestedData['gender']          = $user->gender;
                $nestedData['dob']             = $user->dob;

                $shiftIds = json_decode($user->courses);
                if($shiftIds!=null){
                    $shifts = Course::whereIn('id',$shiftIds)->pluck('name');
                    $section_names = "";
                    $lastCount = count($shifts);
                    $j=1;
                    foreach($shifts as $section){
                        if($j==$lastCount)
                            $section_names = $section_names.$section;
                        else
                            $section_names = $section_names.$section.',';
                        $j++;
                    }
                }else{
                    $section_names = "";
                }

                $nestedData['courses']         = $section_names;
                $nestedData['status']          = $user->status;
                $nestedData['created_at']      = $user->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                $nestedData['action'] = $nestedData['action'].'<a href="'.route('user.show',$user->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$user->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('user.edit',$user->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$user->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('user.destroy',$user->id).'" data-id="'.$user->id.'"><i class="fa fa-trash"></i></button>';

                $nestedData['action'] = $nestedData['action'] .'</div>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
        );

        echo json_encode($json_data);
    }

    public function getStudent(Request $request)
    {
        $users = User::where('role','Student')->where('class_id',$request->grade_id)->where('section_id',$request->section_id)->orderBy('roll_no','ASC')->get();
        if($request->caller_module=="Attendance"){
            $view = view('admin.attendance.student_view',compact('users'))->render();
            return response(['status'=>true,'view'=>$view]);
        }else{
            return response(['status'=>true,'students'=>$users]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.user.create',compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->except('shift_id','course_id','due_date','start_date','complication_date','fees','paid_amount');
            $data['password'] = Hash::make('secret');
            $data['role'] = "Student";
            $data['courses'] = json_encode($request->courses);
            $user = User::create($data);

            $studentCourse = new UserCourse;
            $studentCourse->user_id = $user->id;
            $studentCourse->course_id = $request->course_id;
            $studentCourse->shift_id = $request->shift_id;
            $studentCourse->fees = $request->fees;
            $studentCourse->start_date = $request->start_date;
            $studentCourse->complication_date = $request->complication_date;
            $studentCourse->save();

            $paymentTransaction = new PaymentTransaction;
            $paymentTransaction->user_id = $user->id;
            $paymentTransaction->course_id = $request->course_id;
            $paymentTransaction->paid_amount = $request->paid_amount;
            $dueAmount = $studentCourse->fees - $request->paid_amount;
            $paymentTransaction->due_amount = $dueAmount;
            $paymentTransaction->due_date = $request->due_date;
            $paymentTransaction->save();

            DB::commit();
            return redirect()->route('user.index')->with(['status'=>true,'message'=>'User Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userCourses = UserCourse::where('user_id',$user->id)->get();
        return view('admin.user.show',compact('user','userCourses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $courses = Course::all();
        return view('admin.user.edit',compact('user','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        try{
            $data = $request->all();
            if($request->password)
                $data['password'] = Hash::make($request->password);
            $data['role'] = "Student";
            $data['courses'] = json_encode($request->courses);
            $user->Update($data);
            return redirect()->route('user.index')->with(['status'=>true,'message'=>'User Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return response(['status'=>true,'message'=>'Student deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}
