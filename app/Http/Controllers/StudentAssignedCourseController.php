<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Libs\Structures\ResponseObj;
use App\Student;
use App\StudentAssignedCourse;
use App\Test;
use Illuminate\Http\Request;

class StudentAssignedCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course)
    {
        if($request->filled("student_id")){
            $studentAssignedCourse = new StudentAssignedCourse();
            $studentAssignedCourse->student_id = $request->student_id;
            $studentAssignedCourse->course_id = $course->id;
            $studentAssignedCourse->save();
            $response = new ResponseObj(200, true, "Student zapisany do przedmiotu");
            return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
        }
        return abort(400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentAssignedCourse  $studentAssignedCourse
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAssignedCourse $studentAssignedCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentAssignedCourse  $studentAssignedCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAssignedCourse $studentAssignedCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentAssignedCourse  $studentAssignedCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentAssignedCourse $studentAssignedCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, Student $student)
    {
        StudentAssignedCourse::where("course_id",$course->id)->where("student_id",$student->id)->delete();
        Attendance::where("course_id",$course->id)->where("student_id",$student->id)->delete();
        Test::where("course_id",$course->id)->where("student_id",$student->id)->delete();
        $response = new ResponseObj(200, true, "Student usunięty z przedmiotu");
        return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
    }
}
