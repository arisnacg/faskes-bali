<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/employee', 'EmployeeController');
Route::resource('/partner', 'PartnerController');
Route::resource('/contract', 'ContractController');
Route::resource('/facility', 'FacilityController');
Route::resource('/user', 'UserController');