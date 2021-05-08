<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */
Route::get('/login', 'user@login');
Route::post('/login', 'user@loginp');
Route::post('/reset', 'user@reset');
Route::post('/reset2', 'user@reset2');

Route::middleware(['admincek'])->group(function () {

    Route::get('/workday', 'form@workday');

    Route::get('/karyawan', 'form@karyawan');
    Route::get('/absensi', 'form@absensi');
    Route::get('/lembur', 'form@lembur');
    Route::post('/ganti', 'user@ganti');
    Route::get('/set', 'form@set');

    Route::post('/tes', 'form@tes');
    Route::get('/lap', 'form@lap');
    Route::get('/graf', 'form@graf');
    Route::get('/dashboard', 'form@dashboard');
    Route::get('/getall', 'vue@getall');

    Route::get('/create', 'crud@create');
    Route::get('/delete', 'crud@delete');
    Route::get('/update', 'crud@update');
    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::get('logout', function () {
        session()->flush();
        return redirect('/');
    });
});
