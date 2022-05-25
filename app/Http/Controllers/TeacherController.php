<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = User::where('role','Teacher')->count();
        return view('admin.teacher.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'address',
            3 => 'gender',
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

        $totalData = User::where('role','Teacher')->get()->count();
        $users  = User::select('users.*')->where('users.role','Teacher');

        if($request->input('search.value')){
            $users = $users->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('users.id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->orWhere('users.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $users->get()->count();
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
                $nestedData['name']            = $user->name;
                $nestedData['address']         = $user->address;
                $nestedData['gender']          = $user->gender;
                $nestedData['dob']             = $user->dob;
                $nestedData['status']          = $user->status;
                $nestedData['created_at']      = $user->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                $nestedData['action'] = $nestedData['action'].'<a href="'.route('teacher.show',$user->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$user->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('teacher.edit',$user->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$user->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('teacher.destroy',$user->id).'" data-id="'.$user->id.'"><i class="fa fa-trash"></i></button>';

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
        return view('admin.teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try{
            $data = $request->all();
            $data['password'] = Hash::make('secret');
            $data['role'] = "Teacher";
            User::create($data);
            return redirect()->route('teacher.index')->with(['status'=>true,'message'=>'Teacher Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.teacher.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.teacher.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $user = User::findOrFail($id);
            $data = $request->all();
            if($request->password)
                $data['password'] = 'secret';
            $data['role'] = "Teacher";
            $user->Update($data);
            return redirect()->route('teacher.index')->with(['status'=>true,'message'=>'Teacher Updated Successfully']);
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
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response(['status'=>true,'message'=>'Teacher deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}
