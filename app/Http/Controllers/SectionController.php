<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Subject;
use App\Models\GradeSection;
use App\Models\GradeSubject;
use Illuminate\Http\Request;
use App\Services\NepaliConverter;

class SectionController extends Controller
{
    public function __construct(NepaliConverter $neDate){
        $this->neDate = $neDate;
    }

    public function index()
    {
        $dataCount = Section::count();
        return view('admin.section.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'created_at',
            3 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Section::get()->count();
        $sections  = Section::select('sections.*');

        if($request->input('search.value')){
            $sections = $sections->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('sections.id','LIKE',"%{$search}%")
                            ->orWhere('sections.title', 'LIKE',"%{$search}%")
                            ->orWhere('sections.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $sections->get()->count();
        if($order!="action"){
            $sections   = $sections->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $sections   = $sections->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($sections))
        {   
            $i = $start;
            foreach ($sections as $section)
            {
                $nestedData['id']              = ++$i;
                $nestedData['name']            = $section->name;

                $engDate = Carbon::parse($section->created_at)->format('Y-m-d');

                $exploded_date = explode('-',$engDate);

                $created_date = $this->neDate->eng_to_nep($exploded_date[0],$exploded_date[1],$exploded_date[2]);

                if(config('site.date_system')=="BS")
                    $nestedData['created_at']       = $created_date;
                else
                    $nestedData['created_at']      = Carbon::parse($section->created_at)->format('jS M Y');

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('section.show',$section->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$section->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('section.edit',$section->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$section->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('section.destroy',$section->id).'" data-id="'.$section->id.'"><i class="fa fa-trash"></i></button>';

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

    public function getSection(Request $request)
    {
        $sectionIds = GradeSection::where('grade_id',$request->grade_id)->pluck('section_id');
        $sections = Section::whereIn('id',$sectionIds)->get();
        if($request->user_id){
            $subjectIds = GradeSubject::where('class_id',$request->grade_id)->pluck('subject_id');
            $subjects = Subject::whereIn('id',$subjectIds)->get();
            $user = User::findOrFail($request->user_id);
            $type = Grade::where('id',$user->class_id)->first()->theory_practical;
            $subjectView = view('admin.result.subjects',compact('subjects','type'))->render();
            return response(['status'=>true,'sections'=>$sections,'subjectView'=>$subjectView]);
        }
        return response(['status'=>true,'sections'=>$sections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.section.create');
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
            Section::create($data);
            return redirect()->route('section.index')->with(['status'=>true,'message'=>'Section Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return view('admin.section.show',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return view('admin.section.edit',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        try{
            $data = $request->all();
            $section->Update($data);
            return redirect()->route('menu.index')->with(['status'=>true,'message'=>'Section Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        try{
            $section->delete();
            return response(['status'=>true,'message'=>'Class Section deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}