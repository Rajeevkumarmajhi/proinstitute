<?php

namespace App\Http\Controllers;

use App\Models\SchoolAsset;
use Illuminate\Http\Request;

class SchoolAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCount = SchoolAsset::count();
        return view('admin.school_asset.index',compact('dataCount'));
    }

    public function ajaxTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'quantity',
            3 => 'created_at',
            4 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];;
        $dir   = $request->input('order.0.dir');
        
        if($request->input('search.value'))
            $search = $request->input('search.value');

        $totalData = SchoolAsset::get()->count();
        $school_assets  = SchoolAsset::select('school_assets.*');

        if($request->input('search.value')){
            $school_assets = $school_assets->where(function($qSearch)use($search){
                $qSearch = $qSearch->where('school_assets.id','LIKE',"%{$search}%")
                            ->orWhere('school_assets.name', 'LIKE',"%{$search}%")
                            ->orWhere('school_assets.quantity', 'LIKE',"%{$search}%")
                            ->orWhere('school_assets.created_at', 'LIKE',"%{$search}%");
            });
        }

        $totalFiltered = $school_assets->get()->count();
        if($order!="action"){
            $school_assets   = $school_assets->orderBy($order,$dir)->offset($start)
                           ->limit($limit)
                           ->get();            
        }else{
            $school_assets   = $school_assets->offset($start)
                           ->limit($limit)
                           ->get();        
        }

        $data = array();
        if(!empty($school_assets))
        {   
            $i = $start;
            foreach ($school_assets as $school_asset)
            {
                $nestedData['id']              = ++$i;
                $nestedData['name']            = $school_asset->name;
                $nestedData['quantity']        = $school_asset->quantity;
                $nestedData['created_at']      = $school_asset->created_at;

                $nestedData['action'] = '<div class="btn-group" role="group" aria-label="actions">';

                $nestedData['action'] = $nestedData['action'].'<a href="'.route('school-asset.show',$school_asset->id).'" class="btn btn-sm btn-success text-white rowView" data-id="'.$school_asset->id.'"><i class="fa fa-eye"></i></a>';
                
                $nestedData['action'] = $nestedData['action'].'<a href="'.route('school-asset.edit',$school_asset->id).'" class="btn btn-sm btn-primary text-white rowEdit" data-id="'.$school_asset->id.'"><i class="fa fa-edit"></i></a>';
                
                $nestedData['action'] = $nestedData['action'] .'<button class="btn btn-sm btn-danger text-white rowDelete" data-link="'.route('school-asset.destroy',$school_asset->id).'" data-id="'.$school_asset->id.'"><i class="fa fa-trash"></i></button>';

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
        return view('admin.school_asset.create');
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
            SchoolAsset::create($data);
            return redirect()->route('school-asset.index')->with(['status'=>true,'message'=>'School Asset Added Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolAsset  $schoolAsset
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolAsset $schoolAsset)
    {
        return view('admin.school_asset.show',compact('schoolAsset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolAsset  $schoolAsset
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolAsset $schoolAsset)
    {
        return view('admin.school_asset.edit',compact('schoolAsset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolAsset  $schoolAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolAsset $schoolAsset)
    {
        try{
            $data = $request->all();
            $schoolAsset->Update($data);
            return redirect()->route('school-asset.index')->with(['status'=>true,'message'=>'School Asset Updated Successfully']);
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolAsset  $schoolAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolAsset $schoolAsset)
    {
        try{
            $schoolAsset->delete();
            return response(['status'=>true,'message'=>'School Asset deleted successfully']);
        }catch(\Exception $e){
            return response(['status'=>false,'message'=>'Error : '. $e->getMessage]);
        }
    }
}
