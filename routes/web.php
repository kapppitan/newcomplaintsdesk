<?php

use Illuminate\Support\Facades\Route;


// GET


Route::get('/', 'App\Http\Controllers\ComplaintController@index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::group(['middleware' => 'auth'], function() {
    Route::get('qao', 'App\Http\Controllers\OfficeController@index');
    Route::get('qao/complaint/return', 'App\Http\Controllers\OfficeController@return');
    Route::get('qao/complaint/{id}', 'App\Http\Controllers\ComplaintController@view');
    Route::get('/office', function () {return view('office');});
});


// POST


Route::post('/complain', 'App\Http\Controllers\ComplaintController@create')->name('complain');
Route::post('/login', 'App\Http\Controllers\OfficeController@login');
Route::post('/logout', 'App\Http\Controllers\OfficeController@logout');

Route::post('/create-account', 'App\Http\Controllers\OfficeController@create_account')->name('create-account');
Route::post('/create-office', 'App\Http\Controllers\OfficeController@create_office')->name('create-office');