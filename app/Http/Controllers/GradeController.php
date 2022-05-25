<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Subject;
use App\Models\GradeSection;
use App\Models\GradeSubject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Grade::count();
        return view('admin.grade.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'symbol',
            3 => 'sections',
            4 => 'created_at',
            5 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Grade::get()->count();
        $grades  = Grade::select('grades.*');

        if($request->input('search.value')){
            $grades = $grades->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('grades.id','LIKE',"%{$search}%")
                            ->orWhere('grades.name', 'LIKE',"%{$search}%")
                            ->orWhere('grades.symbol', 'LIKE',"%{$search}%")
                            ->orWhere('grades.sections', 'LIKE',"%{$search}%")
                            ->orWhere('grades.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $grades->get()->count();
        if($order!="action"){
            $grades   = $grades->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $grades   = $grades->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($grades))
        {   
            $i = $start;
            foreach ($grades as $grade)
            {
                $nestedData['id']               = ++$i;
                $nestedData['name']             = $grade->name;
                $nestedData['symbol']           = $grade->symbol;
                $sectionIds = json_decode($grade->sections);
                $sections = Section::whereIn('id',$sectionIds)->pluck('name');
                $section_names = "";
                $lastCount = count($sections);
                $j=1;
                foreach($sections as $section){
                    if($j==$lastCount)
                        $section_names = $section_names.$section;
                    else
                        $section_names = $section_names.$section.',';
                    $j++;
                }
                $nestedData['sections']         = $section_names;
                $nestedData['created_at']       = $grade->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('grade.show',$grade->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$grade->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('grade.edit',$grade->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$grade->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('grade.destroy',$grade->id).'" data-id="'.$grade->id.'"><i class="fa fa-trash"></i></button>';

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
        $sections = Section::all();
        $subjects = Subject::where('theory_practical','Yes')->get();
        return view('admin.grade.create',compact('subjects','sections'));
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
            $data = $request->all();
            $data['sections'] = json_encode($request->sections);
            $data['subjects'] = json_encode($request->subjects);
            $grade = Grade::create($data);
            if(count($request->sections)>0){
                foreach($request->sections as $section){
                    $gradeSection = new GradeSection;
                    $gradeSection->grade_id = $grade->id;
                    $gradeSection->section_id = $section;
                    $gradeSection->save();
                }
            }
            if(count($request->subjects)>0){
                foreach($request->subjects as $subject){
                    $gradeSubject = new GradeSubject;
                    $gradeSubject->class_id = $grade->id;
                    $gradeSubject->subject_id = $subject;
                    $gradeSubject->save();
                }
            }
            return redirect()->route('grade.index')->with(['status'=>true,'message'=>'Grade Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        return view('admin.grade.show',compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        $sections = Section::all();
        if($grade->theory_practical=="Yes")
            $subjects = Subject::where('theory_practical','Yes')->get();
        else
            $subjects = Subject::where('theory_practical','No')->get();
        return view('admin.grade.edit',compact('grade','sections','subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        try{
            $data = $request->all();
            $data['sections'] = json_encode($request->sections);
            $grade->Update($data);
            return redirect()->route('grade.index')->with(['status'=>true,'message'=>'Grade Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        try{
            $grade->delete();
            return response(['status'=>true,'message'=>'Grade deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}