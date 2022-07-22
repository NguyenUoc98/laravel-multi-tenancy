<?php

use Illuminate\Support\Facades\Route;

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

Route::domain(config('app.domain'))->group(function () {
    Route::get('/', function () {
        dd(\Illuminate\Support\Facades\DB::table('users')->get());
    });
});

Route::get('/', function () {
    dd(\Illuminate\Support\Facades\DB::table('users')->get());
});
