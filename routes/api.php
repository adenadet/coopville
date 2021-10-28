<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::namespace('Api\Coop')->middleware('auth:api')->name('api.coop.')->prefix('/coop')->group(base_path('routes/api/coop.php'));
Route::namespace('Api\Hrms')->middleware('auth:api')->name('api.hrms.')->group(base_path('routes/api/hrms.php'));

Route::apiResources([
    'member' => 'Api\MemberController',
]);