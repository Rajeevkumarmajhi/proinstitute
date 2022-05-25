<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Attendance::count();
        $grades = Grade::all();
        return view('admin.attendance.index',compact('dataCount','grades'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'date',
            2 => 'user_id',
            3 => 'user_type',
            4 => 'grade_id',
            5 => 'section_id',
            6 => 'attendance',
            7 => 'created_at',
            8 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Attendance::get()->count();
        $attendances  = Attendance::select('attendances.*','users.name as user_name','grades.name as grade_name','sections.name as section_name')
                                    ->leftJoin('grades','attendances.grade_id','grades.id')
                                    ->leftJoin('sections','attendances.section_id','sections.id')
                                    ->leftJoin('users','attendances.user_id','users.id');
        
        if($request->grade_id && $request->grade_id!="null"){
            $attendances = $attendances->where('attendances.grade_id',$request->grade_id);
        }

        if($request->section_id && $request->section_id!="null"){
            $attendances = $attendances->where('attendances.section_id',$request->section_id);
        }

        if($request->attendance_type && $request->attendance_type!="null"){
            $attendances = $attendances->where('attendances.attendance',$request->attendance_type);
        }

        if($request->teacher_student && $request->teacher_student!="null"){
            $attendances = $attendances->where('attendances.user_type',$request->teacher_student);
        }
        
        if($request->start_date && $request->end_date){
            $end_date = Carbon::parse($request->end_date)->addDays(1)->format('Y-m-d');
            $attendances = $attendances->where('attendances.date','>=',$request->start_date)->where('attendances.date','<',$end_date);
        }

        if($request->input('search.value')){
            $attendances = $attendances->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('attendances.id','LIKE',"%{$search}%")
                            ->orWhere('attendances.date', 'LIKE',"%{$search}%")
                            ->orWhere('attendances.date', 'LIKE',"%{$search}%")
                            ->orWhere('attendances.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $attendances->get()->count();
        if($order!="action"){
            $attendances   = $attendances->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $attendances   = $attendances->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($attendances))
        {   
            $i = $start;
            foreach ($attendances as $attendance)
            {
                $nestedData['id']               = ++$i;
                $nestedData['date']             = Carbon::parse($attendance->date)->format('jS M Y');
                $nestedData['user_id']          = $attendance->user_name;
                $nestedData['user_type']        = $attendance->user_type;
                $nestedData['grade_id']         = $attendance->grade_name;
                $nestedData['section_id']       = $attendance->section_name;
                $nestedData['attendance']       = $attendance->attendance;
                $nestedData['created_at']       = Carbon::parse($attendance->created_at)->format('jS M Y');

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('attendance.show',$attendance->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$attendance->id.'"><i class="fa fa-eye"></i></a>';
                
                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('attendance.edit',$attendance->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$attendance->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('attendance.destroy',$attendance->id).'" data-id="'.$attendance->id.'"><i class="fa fa-trash"></i></button>';

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
        $grades = Grade::all();
        return view('admin.attendance.create',compact('grades'));
    }

    public function createAttendanceTeacher()
    {
        $users = User::where('role','Teacher')->where('status','Active')->get();
        return view('admin.teacher_attendance.create',compact('users'));
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
            if($request->user_type=="Student"){
                
                foreach($request->student as $key => $student){
                    $attendance = new Attendance;
                    $attendance->date = $request->date;
                    $attendance->user_type = "Student";
                    $attendance->grade_id = $request->grade_id;
                    $attendance->section_id = $request->section_id;
                    $attendance->user_id = $key;
                    if(isset($request->attendance[$key]))
                        $attendance->attendance = "Present";
                    else
                        $attendance->attendance = "Absent";
                    $attendance->save();
                }

            }elseif($request->user_type=="Teacher"){
                foreach($request->teacher as $key => $teacher){
                    $attendance = new Attendance;
                    $attendance->date = $request->date;
                    $attendance->user_type = "Teacher";
                    $attendance->user_id = $key;
                    if(isset($request->attendance[$key]))
                        $attendance->attendance = "Present";
                    else
                        $attendance->attendance = "Absent";
                    $attendance->save();
                }
            }else{
                dd('Invalid User Type');
            }
            return redirect()->route('attendance.index')->with(['status'=>true,'message'=>'Attendance Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        return view('admin.attendance.show',compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        return view('admin.attendance.edit',compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        try{
            $data = $request->all();
            $attendance->Update($data);
            return redirect()->route('attendance.index')->with(['status'=>true,'message'=>'Attendance Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        try{
            $attendance->delete();
            return response(['status'=>true,'message'=>'Attendance deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}
