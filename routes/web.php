<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Auth::routes();



Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function (){
    Route::get('/', 'ApartmentController@index')->name('dashboard');

    Route::resource('apartments', 'ApartmentController')->parameters ([
        'apartments' => 'apartment:slug'
    ]);

    //qui mettiamo le altre rotte di admin
});

Route::get("{any?}", function(){
    return view("guest.home");
})->where("any",".*");
