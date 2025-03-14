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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('visits', 'App\Http\Controllers\VisitsController@index');
Route::get('visits/{visit}', 'App\Http\Controllers\VisitsController@show');
Route::post('visits', 'App\Http\Controllers\VisitsController@store');
Route::put('visits/{visit}', 'App\Http\Controllers\VisitsController@update');
Route::delete('visits/{visit}', 'App\Http\Controllers\VisitsController@destroy');
