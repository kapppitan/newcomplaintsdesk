<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;


// GET


Route::get('/', 'App\Http\Controllers\ComplaintController@index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/logout', 'App\Http\Controllers\OfficeController@logout');

Route::get('evidence/{filename}', function ($filename) {
    $path = storage_path('app/evidence' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}); 

Route::group(['middleware' => 'auth'], function() {
    Route::get('/qmso', 'App\Http\Controllers\OfficeController@qao_index');
    Route::get('/qao', 'App\Http\Controllers\OfficeController@qao_index');
    Route::get('/qao/complaint/return', 'App\Http\Controllers\OfficeController@return');
    Route::get('/qao/complaint/{id}', 'App\Http\Controllers\ComplaintController@view');
    Route::get('/qao/complaint/form/{id}', 'App\Http\Controllers\ComplaintController@form_index');
    Route::get('/qao/complaint/form/print/{id}', 'App\Http\Controllers\ComplaintController@print_ccf');
    Route::get('/qao/complaint/memo/{id}', 'App\Http\Controllers\OfficeController@memo_index');
    Route::get('/qao/complaint/memo/print/{id}', 'App\Http\Controllers\ComplaintController@print_memo');
    Route::get('/office', 'App\Http\Controllers\OfficeController@office_index');
    Route::get('/office/complaint/memo/{id}', 'App\Http\Controllers\OfficeController@view_memo');
    Route::get('/office/complaint/form/{id}', 'App\Http\Controllers\ComplaintController@form_index');
    Route::get('/office/complaint/memo/print/{id}', 'App\Http\Controllers\ComplaintController@print_memo');
    Route::get('/user/{id}', 'App\Http\Controllers\OfficeController@get_user');
});


// POST


Route::post('/complain', 'App\Http\Controllers\ComplaintController@create')->name('complain');
Route::post('/login', 'App\Http\Controllers\OfficeController@login');

Route::post('/create-account', 'App\Http\Controllers\OfficeController@create_account')->name('create-account');
Route::post('/create-office', 'App\Http\Controllers\OfficeController@create_office')->name('create-office');

Route::post('qao/update-status/{id}', 'App\Http\Controllers\ComplaintController@update_status')->name('update-status');
Route::post('qao/submite-ccf/{id}', 'App\Http\Controllers\ComplaintController@submit_ccf')->name('submit-ccf');
Route::post('qao/submite-memo/{id}', 'App\Http\Controllers\ComplaintController@submit_memo')->name('submit-memo');