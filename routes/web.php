<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageMakerController@index')->name('welcome');
Route::resource('page', 'PageMakerController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth','namespace' => 'Admin'], function(){
    Route::post('contributions-import', 'ContributionsController@import');
    Route::resource('contributions', 'ContributionsController');
});

Route::get('/member_area/{any}', 'HomeController@index')->where('any', '.*');

Route::group(['middleware' => ['role:Super Admin', 'role:Admin', 'role:Branch Admin', 'role:Financial Admin', 'role:Deanery Admin']], function () {
    Route::get('/admin_area/{any}', 'HomeController@index')->where('any', '.*');
});