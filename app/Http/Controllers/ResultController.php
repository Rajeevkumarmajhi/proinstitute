<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\GradeSubject;
use App\Models\Result;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Terminal;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Result::count();
        return view('admin.result.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'user_id',
            2 => 'class_id',
            3 => 'section_id',
            4 => 'subject_id',
            5 => 'theory_practical',
            6 => 'created_at',
            7 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Result::get()->count();
        $results  = Result::select('results.*','users.name as user_name','subjects.name as subject_name','grades.name as grade_name','sections.name as section_name')
                    ->leftJoin('users','results.user_id','users.id')
                    ->leftJoin('grades','results.class_id','grades.id')
                    ->leftJoin('sections','results.class_id','sections.id')
                    ->leftJoin('subjects','results.subject_id','subjects.id');

        if($request->input('search.value')){
            $results = $results->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('results.id','LIKE',"%{$search}%")
                            ->orWhere('results.user_id', 'LIKE',"%{$search}%")
                            ->orWhere('results.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $results->get()->count();
        if($order!="action"){
            $results   = $results->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $results   = $results->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($results))
        {   
            $i = $start;
            foreach ($results as $result)
            {
                $nestedData['id']               = ++$i;
                $nestedData['user_id']          = $result->user_name;
                $nestedData['class_id']         = $result->grade_name;
                $nestedData['section_id']       = $result->section_name;
                $nestedData['subject_id']       = $result->subject_name;
                $nestedData['theory_practical'] = $result->theory_practical;
                $nestedData['created_at']       = $result->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('result.show',$result->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$result->id.'"><i class="fa fa-eye"></i></a>';
                
                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('result.edit',$result->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$result->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('result.destroy',$result->id).'" data-id="'.$result->id.'"><i class="fa fa-trash"></i></button>';

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
        $terminals = Terminal::all();
        return view('admin.result.create',compact('grades','terminals'));
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
            $class = Grade::findOrFail($request->class_id);
            $subjectIds = GradeSubject::where('class_id',$request->class_id)->pluck('subject_id');
            $subjects = Subject::whereIn('id',$subjectIds)->get();
            if($class->theory_practical=="Yes"){

                foreach($request->theory_obtained_marks as $key => $marks){
                    $result = new Result;
                    $result->user_id = $request->user_id;
                    $result->terminal_id = $request->terminal_id;
                    $result->class_id = $request->class_id;
                    $result->section_id = $request->section_id;
                    $result->subject_id = $key;
                    $result->theory_practical = "Yes";
                    $result->theory_obtained_marks = $marks;
                    $result->practical_obtained_marks = $request->practical_obtained_marks[$key];
                    $result->save();
                }
            }else{
                foreach($request->obtained_marks as $key => $marks){
                    $result = new Result;
                    $result->user_id = $request->user_id;
                    $result->terminal_id = $request->terminal_id;
                    $result->class_id = $request->class_id;
                    $result->section_id = $request->section_id;
                    $result->subject_id = $key;
                    $result->theory_practical = "No";
                    $result->obtained_marks = $marks;
                    $result->save();
                }
            }
            return redirect()->route('result.index')->with(['status'=>true,'message'=>'Result Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        return view('admin.result.show',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        $terminals = Terminal::all();
        $grades = Grade::all();
        return view('admin.result.edit',compact('result','terminals','grades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        try{
            $data = $request->all();
            $result->Update($data);
            return redirect()->route('result.index')->with(['status'=>true,'message'=>'Result Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        try{
            $result->delete();
            return response(['status'=>true,'message'=>'Result deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}