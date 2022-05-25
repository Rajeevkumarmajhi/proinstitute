<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = Terminal::count();
        return view('admin.terminal.index',compact('dataCount'));
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

        $totalData = Terminal::get()->count();
        $terminals  = Terminal::select('terminals.*');

        if($request->input('search.value')){
            $terminals = $terminals->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('terminals.id','LIKE',"%{$search}%")
                            ->orWhere('terminals.name', 'LIKE',"%{$search}%")
                            ->orWhere('terminals.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $terminals->get()->count();
        if($order!="action"){
            $terminals   = $terminals->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $terminals   = $terminals->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($terminals))
        {   
            $i = $start;
            foreach ($terminals as $terminal)
            {
                $nestedData['id']              = ++$i;
                $nestedData['name']            = $terminal->name;
                $nestedData['created_at']      = $terminal->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                $nestedData['action'] = $nestedData['action'].'<a href="'.route('terminal.show',$terminal->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$terminal->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('terminal.edit',$terminal->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$terminal->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('terminal.destroy',$terminal->id).'" data-id="'.$terminal->id.'"><i class="fa fa-trash"></i></button>';

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
        return view('admin.terminal.create');
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
            Terminal::create($data);
            return redirect()->route('terminal.index')->with(['status'=>true,'message'=>'Terminal Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function show(Terminal $terminal)
    {
        return view('admin.terminal.show',compact('terminal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function edit(Terminal $terminal)
    {
        return view('admin.terminal.edit',compact('terminal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terminal $terminal)
    {
        try{
            $data = $request->all();
            $terminal->Update($data);
            return redirect()->route('terminal.index')->with(['status'=>true,'message'=>'Terminal Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terminal $terminal)
    {
        try{
            $terminal->delete();
            return response(['status'=>true,'message'=>'Terminal deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}