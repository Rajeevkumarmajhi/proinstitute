<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Course;
use App\Models\CourseShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Course::count();
        return view('admin.course.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'duration',
            3 => 'fees',
            4 => 'shifts',
            5 => 'created_at',
            6 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Course::count();
        $courses  = Course::select('courses.*');

        if($request->input('search.value')){
            $courses = $courses->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('courses.id','LIKE',"%{$search}%")
                            ->orWhere('courses.name', 'LIKE',"%{$search}%")
                            ->orWhere('courses.duration', 'LIKE',"%{$search}%")
                            ->orWhere('courses.fees', 'LIKE',"%{$search}%")
                            ->orWhere('courses.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $courses->get()->count();
        if($order!="action"){
            $courses   = $courses->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $courses   = $courses->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($courses))
        {   
            $i = $start;
            foreach ($courses as $course)
            {
                $nestedData['id']               = ++$i;
                $nestedData['name']             = $course->name;
                $nestedData['duration']           = $course->duration;
                $shiftIds = json_decode($course->shifts);
                $shifts = Shift::whereIn('id',$shiftIds)->pluck('name');
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
                $nestedData['fees']         = $course->fees;
                $nestedData['shifts']         = $section_names;
                $nestedData['created_at']       = $course->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('grade.show',$grade->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$grade->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('course.edit',[$course->id]).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$course->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('course.destroy',[$course->id]).'" data-id="'.$course->id.'"><i class="fa fa-trash"></i></button>';

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
        $shifts = Shift::all();
        return view('admin.course.create',compact('shifts'));
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
            'name'=>'required',
            'duration'=>'required',
            'fees'=>'required',
        ]);
        try{
            DB::beginTransaction();

            $course = new Course;
            $course->name = $request->name;
            $course->duration = $request->duration;
            $course->fees = $request->fees;
            if(count($request->shifts)<1){
                return redirect()->back()->with('message','Shift is required');
            }
            $course->shifts = json_encode($request->shifts);
            $course->save();
            if(count($request->shifts)>0){
                foreach($request->shifts as $shift){
                    $courseShift = new CourseShift;
                    $courseShift->shift_id = $shift;
                    $courseShift->course_id = $course->id;
                    $courseShift->save();                
                }
            }
            DB::commit();
            return redirect()->route('course.index')->with('message','Course Added Successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('message',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('admin.course.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $shifts = Shift::all();
        return view('admin.course.edit',compact('course','shifts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'=>'required',
            'duration'=>'required',
            'fees'=>'required',
            'shifts'=>'required',
        ]);
        try{
            DB::beginTransaction();
            $course->name = $request->name;
            $course->duration = $request->duration;
            $course->fees = $request->fees;
            $course->shifts = json_encode($request->shifts);
            $course->save();
            if(count($request->shifts)>0){
                $courseShifts = CourseShift::whereIn('shift_id',$request->shifts)->where('course_id',$course->id)->get();
                foreach($courseShifts as $cShift){
                    $cShift->delete();
                }
                foreach($request->shifts as $shift){
                    $courseShift = new CourseShift;
                    $courseShift->shift_id = $shift;
                    $courseShift->course_id = $course->id;
                    $courseShift->save();                
                }
            }
            DB::commit();
            return redirect()->route('course.index')->with('message','Course Added Successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('message',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course.index')->with('success','Course Deleted Successfully');
    }
}
