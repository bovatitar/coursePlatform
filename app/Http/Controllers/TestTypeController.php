<?php

namespace App\Http\Controllers;

use App\Libs\Structures\ResponseObj;
use App\Test;
use App\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $response = new ResponseObj(200, TestType::all(), "Lista typów testów");
//        return response()->json($response, 200,[], JSON_UNESCAPED_UNICODE);
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
        if($request->filled("weight","course_id","name")){
            $testType = new TestType();
            $testType->name = $request->name;
            $testType->course_id = $request->course_id;
            $testType->weight = $request->weight;
            $testType->is_student_option = (bool)$request->is_student_option;
            try{
                $testType->save();
                $response = new ResponseObj(200, $testType, "Forma sprawdzania wiedzy została zapisana");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }catch (\Exception $exception){
                $response = new ResponseObj(400, $exception, "Bląd zapisu formy sprawdzania wiedzy");
                return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
            }
        }
        $response = new ResponseObj(400, null, "Bląd zapisu formy sprawdzania wiedzy");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function show(TestType $testType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function edit(TestType $testType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestType $testType)
    {
        if($request->filled("name")){
            $testType->name = $request->name;
        }
        if($request->filled("course_id")){
            $testType->course_id = $request->course_id;
        }
        if($request->filled("weight")){
            $testType->weight = $request->weight;
        }
        $testType->is_student_option = (bool)$request->is_student_option;
        try{
            $testType->save();
            $response = new ResponseObj(200, $testType, "Forma sprawdzania wiedzy została zapisana");
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }catch (\Exception $exception){
            $response = new ResponseObj(400, null, "Bląd zapisu formy sprawdzania wiedzy");
            return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TestType  $testType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestType $testType)
    {
        Test::where("test_type_id",$testType->id)->delete();
        $testType->delete();
        $response = new ResponseObj(200, $testType, "Forma sprawdzania wiedzy została usunięta");
        return response()->json($response, $response->code,[], JSON_UNESCAPED_UNICODE);
    }
}
