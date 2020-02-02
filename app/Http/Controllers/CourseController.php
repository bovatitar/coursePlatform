<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Libs\Structures\Meta;
use App\Libs\Structures\ResponseObj;
use App\StudentAssignedCourse;
use App\Test;
use Illuminate\Http\Request;
use JWTAuth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $perPage = 20;
        $courseList = Course::orderByDesc("id")->where("user_id",JWTAuth::toUser()['id'])->limit($perPage)->offset($perPage*($page-1))->get();
        $totalItems = Course::where("user_id",JWTAuth::toUser()['id'])->count();
        $totalPages = ceil($totalItems/$perPage);

        $meta = new Meta($page, $perPage, $totalPages, $totalItems);
        $response = new ResponseObj(200, $courseList, "List of the Courses", $meta);

        return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
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
    public function store(Request $request)
    {
        if($request->filled("name","started_at","ended_at","lessons")){
            $course = new Course();
            $course->name = $request->name;
            $course->started_at = date("Y-m-d",strtotime($request->started_at));
            $course->ended_at = date("Y-m-d",strtotime($request->ended_at));
            $course->lessons = $request->lessons;
            $course->user_id = JWTAuth::toUser()['id'];
            try{
                $course->save();
                $response = new ResponseObj(200, $course, "Przedmiod zostal zapisany!");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }catch (\Exception $exception){
                $response = new ResponseObj(400, null, "Bląd w tworzeniu przedmiotu");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }
        }
        $response = new ResponseObj(400, null, "Bląd w tworzeniu przedmiotu!");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course = Course::with("students")->with("testTypes")->with("attendances")->where("id",$course->id)->where("user_id",JWTAuth::toUser()['id'])->firstOrFail();
        $attendances = [];
        foreach ($course->attendances as $attendance){
            if(!array_key_exists($attendance->student_id,$attendances)){
                $attendances[$attendance->student_id] = [];
            }
            $attendances[$attendance->student_id][$attendance->lesson] = $attendance->id;
        }
        $course->attendancesObj = $attendances;

        foreach ($course->students as $student){
            $student->tests = Test::where("student_id",$student->id)->with("type")->where("course_id",$course->id)->get();
        }



        $response = new ResponseObj(200, $course, "Wyświetlono przedmiot Id ".$course->id);
        return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        if($request->filled("name")){
            $course->name = $request->name;
        }
        if($request->filled("started_at")){
            $course->started_at = date("Y-m-d",strtotime($request->started_at));
        }
        if($request->filled("ended_at")){
            $course->ended_at = date("Y-m-d",strtotime($request->ended_at));
        }
        if($request->filled("lessons")){
            $course->lessons = $request->lessons;
        }

        if($course->user_id === JWTAuth::toUser()['id']){
            try{
                $course->save();
                Attendance::where('course_id',$course->id)->where("lesson",">",$course->lessons)->delete();
                $response = new ResponseObj(200, $course, "Przedmiod zostal zapisany!");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }catch (\Exception $exception){
                $response = new ResponseObj(400, $exception, "Bląd w zapisie przedmiotu 2");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }
        }
        $response = new ResponseObj(400, null, "Bląd w zapisie przedmiotu 1");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if($course->user_id === JWTAuth::toUser()['id']){
            StudentAssignedCourse::where("course_id",$course->id)->delete();
            Attendance::where("course_id",$course->id)->delete();
            Test::where("course_id",$course->id)->delete();
            $course->delete();
            $response = new ResponseObj(200, null, "Przedmiot został usunięty");
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }else{
            $response = new ResponseObj(401, null, "Bląd w usunięcie");
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }
    }
}
