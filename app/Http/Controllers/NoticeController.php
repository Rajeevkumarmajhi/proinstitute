<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Notice::count();
        return view('admin.notice.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'slug',
            3 => 'detail',
            4 => 'created_at',
            5 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = Notice::get()->count();
        $notices  = Notice::select('notices.*');

        if($request->input('search.value')){
            $notices = $notices->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('notices.id','LIKE',"%{$search}%")
                            ->orWhere('notices.title', 'LIKE',"%{$search}%")
                            ->orWhere('notices.slug', 'LIKE',"%{$search}%")
                            ->orWhere('notices.detail', 'LIKE',"%{$search}%")
                            ->orWhere('notices.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $notices->get()->count();
        if($order!="action"){
            $notices   = $notices->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $notices   = $notices->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($notices))
        {   
            $i = $start;
            foreach ($notices as $notice)
            {
                $nestedData['id']               = ++$i;
                $nestedData['title']            = $notice->title;
                $nestedData['slug']             = $notice->slug;
                $nestedData['detail']             = $notice->detail;
                $nestedData['created_at']       = $notice->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                $nestedData['action'] = $nestedData['action'].'<a href="'.route('notice.show',$notice->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$notice->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('notice.edit',$notice->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$notice->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('notice.destroy',$notice->id).'" data-id="'.$notice->id.'"><i class="fa fa-trash"></i></button>';

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
        return view('admin.notice.create');
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
            $data['slug'] = Str::slug($request->title);
            Notice::create($data);
            return redirect()->route('notice.index')->with(['status'=>true,'message'=>'Notice Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return view('admin.notice.show',compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        return view('admin.notice.edit',compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        try{
            $data = $request->all();
            $data['slug'] = Str::slug($request->title);
            $notice->Update($data);
            return redirect()->route('notice.index')->with(['status'=>true,'message'=>'Notice Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        try{
            $notice->delete();
            return response(['status'=>true,'message'=>'Notice deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}
