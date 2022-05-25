<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Result;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Terminal;
use App\Models\GradeSubject;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class StudentMarksheetReportController extends Controller
{
    public function studentMarksheet()
    {
        $grades = Grade::all();
        $terminals = Terminal::all();
        return view('admin.result.marksheet',compact('grades','terminals'));
    }

    public function generateMarksheet(Request $request)
    {
        $grade = Grade::where('id',$request->grade_id)->firstOrFail();
        $section = Section::where('id',$request->section_id)->firstOrFail();
        $user = User::where('id',$request->student_id)->firstOrFail();
        $subjectsIds = GradeSubject::where('class_id',$grade->id)->pluck('subject_id');
        $subjects = Subject::whereIn('id',$subjectsIds)->get();
        $type = $grade->theory_practical;

        if($grade->theory_practical=="Yes"){
            foreach($subjects as $subject){
                $subject->theory_obtained_marks = Result::where('user_id',$user->id)->where('terminal_id',$request->terminal_id)->where('class_id',$grade->id)->where('section_id',$section->id)->where('subject_id',$subject->id)->firstOrFail()->theory_obtained_marks;    
                $subject->practical_obtained_marks = Result::where('user_id',$user->id)->where('terminal_id',$request->terminal_id)->where('class_id',$grade->id)->where('section_id',$section->id)->where('subject_id',$subject->id)->firstOrFail()->practical_obtained_marks;    
            }
        }else{
            foreach($subjects as $subject){
                $subject->obtained_marks = Result::where('user_id',$user->id)->where('terminal_id',$request->terminal_id)->where('class_id',$grade->id)->where('section_id',$section->id)->where('subject_id',$subject->id)->firstOrFail()->obtained_marks;    
            }
        }
        $view = view('admin.result.ajaxmarksheetview',compact('type','subjects'))->render();
        return response(['status'=>true,'view'=>$view]);
    }

    public function exportPrint(Request $request)
    {
        $siteSetting = SiteSetting::firstOrFail();
        $grade = Grade::where('id',$request->grade_id)->firstOrFail();
        $section = Section::where('id',$request->section_id)->firstOrFail();
        $user = User::where('id',$request->student_id)->firstOrFail();
        $subjectsIds = GradeSubject::where('class_id',$grade->id)->pluck('subject_id');
        $subjects = Subject::whereIn('id',$subjectsIds)->get();
        $type = $grade->theory_practical;

        if($grade->theory_practical=="Yes"){
            foreach($subjects as $subject){
                $subject->theory_obtained_marks = Result::where('user_id',$user->id)->where('terminal_id',$request->terminal_id)->where('class_id',$grade->id)->where('section_id',$section->id)->where('subject_id',$subject->id)->firstOrFail()->theory_obtained_marks;    
                $subject->practical_obtained_marks = Result::where('user_id',$user->id)->where('terminal_id',$request->terminal_id)->where('class_id',$grade->id)->where('section_id',$section->id)->where('subject_id',$subject->id)->firstOrFail()->practical_obtained_marks;    
            }
        }else{
            foreach($subjects as $subject){
                $subject->obtained_marks = Result::where('user_id',$user->id)->where('terminal_id',$request->terminal_id)->where('class_id',$grade->id)->where('section_id',$section->id)->where('subject_id',$subject->id)->firstOrFail()->obtained_marks;    
            }
        }
        $student = $user;
        $student->class = Grade::where('id',$user->class_id)->first()->name;
        $student->section = Section::where('id',$user->section_id)->first()->name;
        return view('admin.result.printmarksheetview',compact('type','subjects','siteSetting','student'));
    }
}