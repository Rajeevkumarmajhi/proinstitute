<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FrontController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function login()
    {
        return view('login');
    }

    public function attemptLogin(Request $request)
    {

        $credentials = [
            "email"=>$request->email,
            "password"=>$request->password,
        ];

        if(auth()->attempt($credentials)){

            if(auth()->user()->role == "Admin"){
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('welcome');
        }

        return redirect()->route('login')->with('message','Invalid username and password');

    }

    public function fixStorage()
    {
        Artisan::call('storage:link');
    }
}
