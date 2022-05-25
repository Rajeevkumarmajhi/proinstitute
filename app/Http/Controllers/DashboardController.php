<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $teachersCount = User::where('role','Teacher')->count();
        $studentsCount = User::where('role','Student')->count();
        $attendancesCount = Attendance::count();
        $marksheetsCount = Result::count();
        return view('admin.dashboard',compact('teachersCount','studentsCount','attendancesCount','marksheetsCount'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('welcome');
    }
}