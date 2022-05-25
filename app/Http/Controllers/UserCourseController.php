<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\PaymentTransaction;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = UserCourse::count();
        return view('admin.user_course.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'user_id',
            2 => 'course_id',
            3 => 'fees',
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

        $totalData = UserCourse::count();
        $user_courses  = UserCourse::with('user','course');

        if($request->input('search.value')){
            $user_courses = $user_courses->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('user_courses.id','LIKE',"%{$search}%")
                            ->orWhere('user_courses.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $user_courses->get()->count();
        if($order!="action"){
            $user_courses   = $user_courses->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $user_courses   = $user_courses->offset($start)
                           ->limit($limit)
                           ->get();
        }

        $data = array();
        if(!empty($user_courses))
        {   
            $i = $start;
            foreach ($user_courses as $user_course)
            {
                $nestedData['id']             = ++$i;
                $nestedData['user_id']        = $user_course->user->first_name.' '.$user_course->user->middle_name.' '.$user_course->user->last_name;
                $nestedData['course_id']      = $user_course->course->name;
                $nestedData['fees']           = $user_course->fees;
                $nestedData['status']         = $user_course->status;

                $nestedData['created_at']     = $user_course->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                $nestedData['action'] = $nestedData['action'].'<a href="'.route('user-course.edit',$user_course->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$user_course->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('user-course.destroy',$user_course->id).'" data-id="'.$user_course->id.'"><i class="fa fa-trash"></i></button>';

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = User::where('role','Student')->get();
        $courses = Course::all();
        return view('admin.user_course.create',compact('students','courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'course_id'=>'required',
            'fees'=>'required',
        ]);
        try{
            DB::beginTransaction();

            $course = Course::findOrFail($request->course_id);

            $userCourse = new UserCourse;
            $userCourse->user_id = $request->user_id;
            $userCourse->course_id = $request->course_id;
            $userCourse->fees = $request->fees;
            if($request->fees<=$request->paid_amount)
                $userCourse->status = "Completed";
            else
                $userCourse->status = "Running";

            $userCourse->save();
            $paymentTransaction = new PaymentTransaction;
            $paymentTransaction->user_id = $request->user_id;
            $paymentTransaction->course_id = $request->course_id;
            $paymentTransaction->paid_amount = $request->paid_amount;
            $dueAmount = $userCourse->fees - $request->paid_amount;
            $paymentTransaction->due_amount = $dueAmount;
            $paymentTransaction->due_date = $request->due_date;
            $paymentTransaction->save();
            $user = User::where('id',$request->user_id)->first();
            $user->due_amount = $user->due_amount + $userCourse->due_amount;
            $user->save();
            DB::commit();
            return redirect()->route('user-course.index')->with('User Course Successfully Added');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('message',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return \Illuminate\Http\Response
     */
    public function show(UserCourse $userCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(UserCourse $userCourse)
    {
        $paymentTransactions = PaymentTransaction::where('user_id',$userCourse->user_id)->where('course_id',$userCourse->course_id)->get();
        return view('admin.user_course.edit',compact('userCourse','paymentTransactions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserCourse  $userCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserCourse $userCourse)
    {
        $request->validate([
            'paid_amount'=>'required',
        ]);
        try{
            DB::beginTransaction();
            $existingPaymentTransaction = PaymentTransaction::where('course_id',$userCourse->course_id)->where('user_id',$userCourse->user_id)->orderBy('created_at','DESC')->first();
            $paymentTransaction = new PaymentTransaction;
            $paymentTransaction->user_id = $userCourse->user_id;
            $paymentTransaction->course_id = $userCourse->course_id;
            $paymentTransaction->paid_amount = $request->paid_amount;
            
            $dueAmount = $existingPaymentTransaction->due_amount - $request->paid_amount;
            if($dueAmount<=0){
                $userCourse->status = "Completed";
                $userCourse->save();
            }else{
                if($request->due_date)
                    $paymentTransaction->due_date = $request->due_date;
            }
            $paymentTransaction->due_amount = $dueAmount;
            $paymentTransaction->save();
            $user = User::where('id',$userCourse->user_id)->first();
            $user->due_amount = $user->due_amount + $userCourse->due_amount;
            $user->save();
            DB::commit();
            return redirect()->route('user-course.index');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('message',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $userCourse = UserCourse::findOrFail($request->id);
        PaymentTransaction::where('course_id',$userCourse->course_id)->delete();
        $userCourse->delete();
        return redirect()->route('user-course.index')->with('success','User Course Deleted Successfully');
    }

    public function generateBill($id){
        $userCourse = UserCourse::findOrFail($id);
        $paymentTransactions = PaymentTransaction::where('user_id',$userCourse->user_id)->where('course_id',$userCourse->course_id)->get();
        return view('admin.user_course.show',compact('userCourse','paymentTransactions'));
    }
}