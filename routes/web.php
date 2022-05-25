<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SchoolAssetController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\StudentMarksheetReportController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseController;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontController::class,'login'])->name('welcome');
Route::get('/login',[FrontController::class,'login'])->name('login');
Route::post('/attempt-login',[FrontController::class,'attemptLogin'])->name('attempt.login');
Route::get('/fixstorage',[FrontController::class,'fixStorage'])->name('fixStorage');

Route::group(['middleware'=>'is_admin'],function(){

    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/logout',[DashboardController::class,'logout'])->name('admin.logout');

    // Student and Users
    Route::resource('user',UserController::class);
    Route::post('/user/ajaxTable',[UserController::class,'ajaxTable'])->name('user.ajaxTable');
    Route::post('/get-student',[UserController::class,'getStudent'])->name('get.student');

    Route::resource('teacher',TeacherController::class);
    Route::post('/teacher/ajaxTable',[TeacherController::class,'ajaxTable'])->name('teacher.ajaxTable');
    
    Route::resource('shift',ShiftController::class);
    Route::post('/shift/ajaxTable',[ShiftController::class,'ajaxTable'])->name('shift.ajaxTable');
    Route::post('/shift/delete',[ShiftController::class,'destroy'])->name('shift.delete');
    Route::post('/course/shift',[ShiftController::class,'courseShift'])->name('course.shifts');
    
    Route::resource('course',CourseController::class);
    Route::post('/course/ajaxTable',[CourseController::class,'ajaxTable'])->name('course.ajaxTable');
    
    Route::resource('user-course',UserCourseController::class);
    Route::post('/user-course/ajaxTable',[UserCourseController::class,'ajaxTable'])->name('user-course.ajaxTable');
    Route::post('/user-course/delete',[UserCourseController::class,'destroy'])->name('user-course.delete');

    Route::get('/bill/generate/{id}',[UserCourseController::class,'generateBill'])->name('bill.generate');
    
    Route::resource('notice',NoticeController::class);
    Route::post('/notice/ajaxTable',[NoticeController::class,'ajaxTable'])->name('notice.ajaxTable');
    
    Route::resource('result',ResultController::class);
    Route::post('/result/ajaxTable',[ResultController::class,'ajaxTable'])->name('result.ajaxTable');

    Route::resource('school-asset',SchoolAssetController::class);
    Route::post('/school-asset/ajaxTable',[SchoolAssetController::class,'ajaxTable'])->name('school-asset.ajaxTable');
    
    Route::resource('attendance',AttendanceController::class);
    Route::post('/attendance/ajaxTable',[AttendanceController::class,'ajaxTable'])->name('attendance.ajaxTable');
    Route::get('/attendance/teacher/create',[AttendanceController::class,'createAttendanceTeacher'])->name('create.attendance.teacher');
    
    // Setting Route
    Route::get('settings',[SiteSettingController::class,'index'])->name('settings.index');
    Route::post('settings',[SiteSettingController::class,'updateSetting'])->name('settings.update');
    
    // Reports
    Route::get('/reports/student/marksheet',[StudentMarksheetReportController::class,'studentMarksheet'])->name('student.marksheet');
    Route::post('/reports/student/marksheet-generate',[StudentMarksheetReportController::class,'generateMarksheet'])->name('generate.marksheet');
    Route::post('/reports/student/marksheet-print',[StudentMarksheetReportController::class,'exportPrint'])->name('marksheet.exportPrint'); 
});