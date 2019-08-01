<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'students'], function () {
    Route::get('/', 'StudentController@index');                               /* show all */
    Route::get('/create', 'StudentController@create');                        /* create page */
    Route::post('/', 'StudentController@store');                              /* store new data    */
    Route::get('/{student}', 'StudentController@show');         /* get data by id or ... */
    Route::get('/{student}/edit', 'StudentController@edit');    /* get data by id and show on edit page ... */
    Route::patch('/{student}', 'StudentController@update');     /* update by id ... */
    Route::delete('/{student}', 'StudentController@delete');    /* delete by id ... */
});
            