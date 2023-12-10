<?php

use Illuminate\Support\Facades\Route;
// use Modules\User\Src\HTTP\Controllers\UserController;

// Route::get('/user', [UserController::class, 'index']);

// Route::middleware('demo')->get('/user', function () {
//     return '<h1>hello</h1>';
// });


// Module Users
Route::group(['namespace' => 'Modules\User\Src\HTTP\Controllers'], function () {
    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index');
        Route::get('/detail/{id}', 'UserController@detail');
    });
});
