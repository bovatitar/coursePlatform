<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','Auth\LoginController@login');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', 'CourseController@index');
        Route::post('/', 'CourseController@store');
        Route::get('/{course}', 'CourseController@show');
        Route::post('/{course}', 'CourseController@update');
        Route::delete('/{course}', 'CourseController@destroy');
        Route::post('/{course}/students', 'StudentAssignedCourseController@store');
        Route::delete('/{course}/students/{student}', 'StudentAssignedCourseController@destroy');
    });

    Route::prefix('attendances')->group(function () {
        Route::post('/', 'AttendanceController@store');
        Route::delete('/{attendance}', 'AttendanceController@destroy');
    });

    Route::prefix('students')->group(function () {
        Route::get('/', 'StudentController@index');
        Route::post('/', 'StudentController@store');
        Route::get('/{student}', 'StudentController@show');
        Route::post('/{student}', 'StudentController@update');
        Route::delete('/{student}', 'StudentController@destroy');
    });

    Route::prefix('test-types')->group(function () {
        Route::get('/', 'TestTypeController@index');
        Route::post('/', 'TestTypeController@store');
        Route::get('/{testType}', 'TestTypeController@show');
        Route::post('/{testType}', 'TestTypeController@update');
        Route::delete('/{testType}', 'TestTypeController@destroy');
    });

    Route::prefix('tests')->group(function () {
        Route::get('/', 'TestController@index');
        Route::post('/', 'TestController@store');
        Route::get('/{test}', 'TestController@show');
        Route::post('/{test}', 'TestController@update');
        Route::delete('/{test}', 'TestController@destroy');
    });
});
