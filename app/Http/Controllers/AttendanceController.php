<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Libs\Structures\ResponseObj;
use Illuminate\Http\Request;

class AttendanceController extends Controller
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
    public function store(Request $request)
    {
        if($request->filled("student_id", "course_id", "lesson")){
            $attendance = Attendance::where("student_id",$request->student_id)->where("course_id",$request->course_id)->where("lesson",$request->lesson)->first();
            if($attendance !== null){
                return $this->destroy($attendance);
            }
            $attendance = new Attendance();
            $attendance->student_id = $request->student_id;
            $attendance->course_id = $request->course_id;
            $attendance->lesson = $request->lesson;
            $attendance->save();
            $response = new ResponseObj(200, true, "Obecność zapisana");
            return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
        }
        return abort(400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        $response = new ResponseObj(200, true, "Obecność usunięta");
        return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
    }
}
