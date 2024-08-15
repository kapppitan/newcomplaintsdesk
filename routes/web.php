<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\ComplaintController@index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/qao', function () {
    return view('qao');
})->middleware('auth');

Route::post('/complain', 'App\Http\Controllers\ComplaintController@create')->name('complain');
Route::post('/login', 'App\Http\Controllers\OfficeController@login');
Route::post('/logout', 'App\Http\Controllers\OfficeController@logout');