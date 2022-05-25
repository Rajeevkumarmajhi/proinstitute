<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::first();
        return view('admin.settings.index',compact('siteSetting'));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'logo' => 'mimes:jpeg,png,jpg|max:5000', 
        ]);
        $siteSetting = SiteSetting::first();
        if(!$siteSetting){
            $siteSetting = new SiteSetting;
            
        }
        $siteSetting->school_name = $request->school_name;
        $siteSetting->phone = $request->phone;
        $siteSetting->date_system = $request->date_system;
        $siteSetting->address = $request->address;

        if($request->logo){
            $fileName = time().'_'.$request->logo->getClientOriginalName();
            $filePath = $request->file('logo')->storeAs('uploads/logo', $fileName, 'public');
            $modifiedPath =  '/storage/uploads/logo/' . $fileName;
            $siteSetting->logo = $modifiedPath;
        }
        $siteSetting->save();
        return redirect()->back()->with('success','Settings Updated Successfully');
    }
}