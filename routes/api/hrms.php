<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'hrms'], function () {
    
    Route::get('/users/initials', 'UserController@initials')->name('users.initials');
    Route::post('/users/passwordReset', 'UserController@passwordReset')->name('users.passwordReset');
    Route::get('/profile', 'UserController@profile')->name('profile.initials');
    Route::post('/password', 'UserController@password')->name('profile.password');
    
    Route::apiResources([
        '/bios' => 'BioController',
        '/nok' => 'NOKController',
        '/users' => 'UserController',
        //'/profile' => 'ProfileController',
    ]);
});