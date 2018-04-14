<?php

Route::get('/pengaturan', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pengaturan'
]);

Route::post('/pengaturan', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@ubah'
]);

//////////////////////////////////////////////////////////////////////////
//Halaman pengelolaan
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

Route::get('/faskes', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@faskes'
]);

//////////////////////////////////////////////////////////////////////////
//Halaman pencarian
Route::get('/cari/pegawai', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pencarian_pegawai'
]);

Route::get('/cari/rekanan', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pencarian_rekanan'
]);

Route::get('/cari/kontrak', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pencarian_kontrak'
]);

Route::get('/cari/faskes', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pencarian_faskes'
]);

Route::get('/cari/rambu', [
	'middleware' => ['auth'],
	'uses' => 'PagesController@pencarian_rambu'
]);

//////////////////////////////////////////////////////////////////////////
//Filtering
Route::post('/filter/employee', [
	'middleware' => ['auth'],
	'uses' => 'FilterController@employee'
]);

Route::post('/filter/partner', [
	'middleware' => ['auth'],
	'uses' => 'FilterController@partner'
]);

Route::post('/filter/contract', [
	'middleware' => ['auth'],
	'uses' => 'FilterController@contract'
]);

Route::post('/filter/facility', [
	'middleware' => ['auth'],
	'uses' => 'FilterController@facility'
]);

Route::post('/filter/traffic_sign', [
	'middleware' => ['auth'],
	'uses' => 'FilterController@traffic_sign'
]);

//////////////////////////////////////////////////////////////////////////
//Print PDF
Route::post('/pdf/pegawai', [
	'middleware' => ['auth'],
	'uses' => 'PDFController@employee'
]);

Route::post('/pdf/rekanan', [
	'middleware' => ['auth'],
	'uses' => 'PDFController@partner'
]);

Route::post('/pdf/kontrak', [
	'middleware' => ['auth'],
	'uses' => 'PDFController@contract'
]);

Route::post('/pdf/fasilitas', [
	'middleware' => ['auth'],
	'uses' => 'PDFController@facility'
]);

Route::post('/pdf/rambu', [
	'middleware' => ['auth'],
	'uses' => 'PDFController@traffic_sign'
]);

Route::get('/pdf/download/{file}', [
	'middleware' => ['auth'],
	'uses' => 'PDFController@download'
]);



//////////////////////////////////////////////////////////////////////////
//Halaman Qrcode 
Route::get('/qrcode', 'PagesController@qrcode');

Route::post('/qrcode', 'PagesController@generate');

Route::get('/download/{file}', 'PagesController@download');

Route::get('/coba', 'CobaController@index');

Route::resource('/employee', 'EmployeeController');
Route::resource('/partner', 'PartnerController');
Route::resource('/contract', 'ContractController');
Route::resource('/facility', 'FacilityController');
Route::resource('/position', 'PositionController');
Route::resource('/user', 'UserController');

Auth::routes();
Auth::routes();

Auth::routes();
