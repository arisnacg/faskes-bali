<?php

Route::get('/', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@index'
]);
Route::get('/pegawai', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pegawai'
]);

Auth::routes();
Auth::routes();

Auth::routes();
