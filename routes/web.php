<?php

Route::get('/', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@index'
]);

Route::get('/home', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@index'
]);

Route::get('/pegawai', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pegawai'
]);

Route::get('/pengguna', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pengguna'
]);

Route::get('/rekanan', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@rekanan'
]);

Route::get('/kontrak', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@kontrak'
]);

Route::resource('/employee', 'EmployeeController');
Route::resource('/partner', 'PartnerController');
Route::resource('/contract', 'ContractController');
Route::resource('/facility', 'FacilityController');
Route::resource('/position', 'PositionController');
Route::resource('/user', 'UserController');

Auth::routes();
Auth::routes();

Auth::routes();
