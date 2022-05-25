<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Services\NepaliConverter;

class SubjectController extends Controller
{
    public function __construct(NepaliConverter $neDate){
        $this->neDate = $neDate;
    }

    public function index()
    {
        $dataCount = Subject::count();
        return view('admin.subject.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'code',
            3 => 'optional',
            4 => 'theory_practical',
            5 => 'created_at',
            5 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Subject::get()->count();
        $subjects  = Subject::select('subjects.*');

        if($request->input('search.value')){
            $subjects = $subjects->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('subjects.id','LIKE',"%{$search}%")
                            ->orWhere('subjects.name', 'LIKE',"%{$search}%")
                            ->orWhere('subjects.code', 'LIKE',"%{$search}%")
                            ->orWhere('subjects.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $subjects->get()->count();
        if($order!="action"){
            $subjects   = $subjects->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $subjects   = $subjects->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($subjects))
        {   
            $i = $start;
            foreach ($subjects as $subject)
            {
                $nestedData['id']               = ++$i;
                $nestedData['name']             = $subject->name;
                $nestedData['code']             = $subject->code;
                $nestedData['optional']         = $subject->optional;
                $nestedData['theory_practical']         = $subject->theory_practical;

                $engDate = Carbon::parse($subject->created_at)->format('Y-m-d');

                $exploded_date = explode('-',$engDate);

                $created_date = $this->neDate->eng_to_nep($exploded_date[0],$exploded_date[1],$exploded_date[2]);

                if(config('site.date_system')=="BS")
                    $nestedData['created_at']       = $created_date;
                else
                    $nestedData['created_at']       = Carbon::parse($subject->created_at)->format('jS M Y');

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                // $nestedData['action'] = $nestedData['action'].'<a href="'.route('subject.show',$subject->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$subject->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('subject.edit',$subject->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$subject->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('subject.destroy',$subject->id).'" data-id="'.$subject->id.'"><i class="fa fa-trash"></i></button>';

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

    public function theoryPractical(Request $request){
        if($request->theory_practical=="Yes")
            $theoryPracticalView = view('admin.subject.theory_practical')->render();
        else
            $theoryPracticalView = view('admin.subject.normal_marks_system')->render();
        return response(['status'=>true,'view'=>$theoryPracticalView]);
    }

    public function getThprSubjects(Request $request)
    {
        if($request->theory_practical=="Yes")
            $subjects = Subject::where('theory_practical','Yes')->get();
        else
            $subjects = Subject::where('theory_practical','No')->get();
            $theoryPracticalView = view('admin.subject.thpr',compact('subjects'))->render();
        return response(['status'=>true,'view'=>$theoryPracticalView]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subject.create');
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
            Subject::create($data);
            return redirect()->route('subject.index')->with(['status'=>true,'message'=>'Subject Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return view('admin.subject.show',compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return view('admin.subject.edit',compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        try{
            $data = $request->all();
            $subject->Update($data);
            return redirect()->route('subject.index')->with(['status'=>true,'message'=>'Subject Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        try{
            $subject->delete();
            return response(['status'=>true,'message'=>'Grade deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}
