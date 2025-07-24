<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//employee
Route::get('employee','Api\EmployeeController@index');

//job
Route::get('job_manhour','Api\JobController@manhour');

//jobposition
Route::get('jobposition_manhour','Api\JobPositionController@manhour');

//pmorder
Route::get('pmorder_manhour','Api\PMOrderController@manhour');

//project
Route::get('project','Api\ProjectController@project');
Route::get('project_import','Api\ProjectController@import');
