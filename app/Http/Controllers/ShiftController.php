<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseShift;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Shift::count();
        return view('admin.shift.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'start_time',
            3 => 'end_time',
            4 => 'created_at',
            5 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Shift::get()->count();
        $shifts  = Shift::select('shifts.*');

        if($request->input('search.value')){
            $shifts = $shifts->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('shifts.id','LIKE',"%{$search}%")
                            ->orWhere('shifts.name', 'LIKE',"%{$search}%")
                            ->orWhere('shifts.symbol', 'LIKE',"%{$search}%")
                            ->orWhere('shifts.sections', 'LIKE',"%{$search}%")
                            ->orWhere('shifts.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $shifts->get()->count();
        if($order!="action"){
            $shifts   = $shifts->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $shifts   = $shifts->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($shifts))
        {   
            $i = $start;
            foreach ($shifts as $shift)
            {
                $nestedData['id']               = ++$i;
                $nestedData['name']             = $shift->name;
                $nestedData['start_time']       = $shift->start_time;
                $nestedData['end_time']         = $shift->end_time;
                $nestedData['created_at']       = $shift->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('grade.show',$grade->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$grade->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('shift.edit',[$shift->id]).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$shift->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('shift.destroy',[$shift->id]).'" data-id="'.$shift->id.'"><i class="fa fa-trash"></i></button>';

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
        return view('admin.shift.create');
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
            'start_time'=>'required',
            'end_time'=>'required',
        ]);
        $shift = new Shift;
        $shift->name = $request->name;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->save();
        return redirect()->route('shift.index')->with('success','Shift Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        return view('admin.shift.edit',compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ]);
        $shift->name = $request->name;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->save();
        return redirect()->route('shift.index')->with('success','Shift Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        $shift->delete();
        return redirect()->route('shift.index')->with('success','Shift Deleted Successfully');
    }

    public function courseShift(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        $courseShiftIDs = CourseShift::where('course_id',$request->course_id)->pluck('shift_id');
        $shifts = Shift::whereIn('id',$courseShiftIDs)->get();
        $view = view('admin.shift.course_shifts',compact('shifts'))->render();
        return response(['status'=>true,'data'=>$view,'course'=>$course]);

    }
}
