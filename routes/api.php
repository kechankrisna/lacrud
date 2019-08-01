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
Route::group(['prefix' => 'students'], function () {
    Route::get('/', 'API\StudentController@index');                              /* show all */
    Route::post('/', 'API\StudentController@store');                             /* store new data    */
    Route::get('/{student}', 'API\StudentController@show');        /* get data by id or ... */
    Route::patch('/{student}', 'API\StudentController@update');    /* update by id ... */
    Route::delete('/{student}', 'API\StudentController@delete');   /* delete by id ... */
});
            