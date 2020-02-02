<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Course;
use App\Libs\Structures\Meta;
use App\Libs\Structures\ResponseObj;
use App\Student;
use App\StudentAssignedCourse;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
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
        $whereArray = [];
        $dbRaw = 'true';
        if($request->search !== null){
//            $searchWhere[] = ["CONCAT(`firstname`, ' ', `lastname`)","LIKE", "%".$request->search."%'"];
            $dbRaw = DB::raw("CONCAT(firstname, ' ', lastname) like '%".$request->search."%'");
        }

        $studentList = Student::orderByDesc("id")->whereRaw($dbRaw)->limit($perPage)->offset($perPage*($page-1))->get();

        if($request->course_id !== null){
            $course = Course::find($request->course_id);
            $studentListByCourse = $course->students;
            $studentList = $studentList->diff($studentListByCourse);
        }

        $totalItems = Student::count();
        $totalPages = ceil($totalItems/$perPage);


        $meta = new Meta($page, $perPage, $totalPages, $totalItems);
        $response = new ResponseObj(200, $studentList, "Lista studentów", $meta);

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
        if($request->filled(["firstname","lastname","index","email"])){
            $student = new Student();
            $student->firstname = $request->firstname;
            $student->lastname = $request->lastname;
            $student->email = $request->email;
            $student->index = $request->index;
            try{
                $student->save();
                $response = new ResponseObj(200, $student, "Successful created student id ".$student->id);
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }catch (\Exception $exception){
                $response = new ResponseObj(400, null, "Failed created of student");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }
        }
        $response = new ResponseObj(400, null, "Failured created of student");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $response = new ResponseObj(200, $student, "Display student id ".$student->id);
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if($request->filled("firstname")){
            $student->firstname = $request->firstname;
        }
        if($request->filled("lastname")){
            $student->lastname = $request->lastname;
        }
        if($request->filled("email")){
            $student->email = $request->email;
        }
        if($request->filled("index")){
            $student->index = $request->index;
        }
        try{
            $student->save();
            $response = new ResponseObj(200, $student, "Successful update of student id ".$student->id);
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }catch (\Exception $exception){
            $response = new ResponseObj(400, null, "Failed update of student id ".$student->id);
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        StudentAssignedCourse::where("student_id",$student->id)->delete();
        Attendance::where("student_id",$student->id)->delete();
        Test::where("student_id",$student->id)->delete();
        $student->delete();
        $response = new ResponseObj(200, null, "Student został usunięty");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }
}
