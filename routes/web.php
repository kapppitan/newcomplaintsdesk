<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('complaint');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/qao', function () {
    return view('qao');
});

Route::post('/complain', 'App\Http\Controllers\ComplaintController@create')->name('complain');