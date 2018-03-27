<?php

Route::get('/', 'PagesController@index');
Route::get('/pegawai', 'PagesController@pegawai');

Auth::routes();