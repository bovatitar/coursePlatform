<?php

namespace App\Http\Controllers;

use App\Libs\Structures\ResponseObj;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
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
        if($request->filled("test_type_id","mark","course_id","student_id")){
            $test = new Test();
            $test->test_type_id = $request->test_type_id;
            $test->mark = $request->mark;
            $test->course_id = $request->course_id;
            $test->student_id = $request->student_id;
            try{
                $test->save();
                $response = new ResponseObj(200, $test, "Ocena została zapisana");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }catch (\Exception $exception){
                $response = new ResponseObj(400, null, "Bląd zapisu oceny");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }
        }
        $response = new ResponseObj(400, null, "Bląd zapisu oceny");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        if($request->filled("test_type_id")){
            $test->test_type_id = $request->test_type_id;
        }
        if($request->filled("mark")){
            $test->mark = $request->mark;
        }
        try{
            $test->save();
            $response = new ResponseObj(200, $test, "Ocena została zapisana");
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }catch (\Exception $exception){
            $response = new ResponseObj(400, null, "Bląd zapisu oceny");
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        $test->delete();
        $response = new ResponseObj(200, null, "Ocena została usunięta");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }
}
