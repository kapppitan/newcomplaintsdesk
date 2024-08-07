<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('complaint');
});

Route::post('/complain', 'App\Http\Controllers\ComplaintController@create')->name('complain');