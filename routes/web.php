<?php

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

Route::get('/', 'Login@index');

Route::get('/home', 'Login@index');

Route::get('/login', 'Login@getLogin');

Route::post('auth', 'Login@postLogin');

Route::get('Register',['uses'=>'Login@getRegister','as'=>'getRegister']);
Route::post('Register',['uses'=>'Login@postRegister','as'=>'postRegister']);

Route::get('/logout', 'Login@getLogout');

Route::get('/admin', 'HomeController@index');

Route::get('/user', 'UsersController@index');

Route::get('hakakses',function(){
	return abort('503');
});

//User Management
Route::get('/admin/users', 'UserController@index');
Route::post('/admin/users/store', 'UserController@store');
Route::post('/admin/users/update/{id}', 'UserController@update');
Route::get('/admin/users/delete/{id}', 'UserController@delete');
//Profile Admin
Route::get('/admin/profile', 'ProfileController@edit');
Route::post('/admin/profile/update/{id}', 'ProfileController@update');
Route::post('/admin/reset-password/{id}', 'ProfileController@password');
//Data Gedung
Route::get('/admin/gedung', 'GedungController@index');
Route::post('/admin/gedung/upload/{id_gedung}', 'GedungController@upload');
Route::get('/admin/tambah-gedung', 'GedungController@add');
Route::post('/admin/gedung/store', 'GedungController@store');
Route::get('/admin/update-gedung/{id_gedung}', 'GedungController@edit');
Route::post('/admin/gedung/update/{id_gedung}', 'GedungController@update');
Route::post('/admin/gedung/delete/{id_gedung}', 'GedungController@delete');
//Trash Gedung
Route::get('/admin/gedung/trash', 'GedungController@trash');
Route::get('/admin/gedung/kembalikan/{id_gedung}', 'GedungController@kembalikan');
Route::post('/admin/gedung/hapus_permanen/{id_gedung}', 'GedungController@hapus_permanen');
//Get Alamat
Route::get('/json-regencies','GedungController@regencies');
Route::get('/json-districts', 'GedungController@districts');
Route::get('/json-village', 'GedungController@villages');
Route::get('/prov-name','GedungController@provName');
Route::get('/city-name','GedungController@cityName');
Route::get('/kec-name','GedungController@kecName');
Route::get('/kel-name','GedungController@kelName');
//Data Lantai
Route::get('/admin/lantai', 'LantaiController@index');
Route::post('/admin/lantai/store', 'LantaiController@store');
Route::post('/admin/lantai/delete/{id_lantai}', 'LantaiController@delete');
Route::post('/admin/lantai/update/{id_lantai}', 'LantaiController@update');
//Trash Lantai
Route::get('/admin/lantai/trash', 'LantaiController@trash');
Route::get('/admin/lantai/kembalikan/{id_lantai}/{id_gedung}', 'LantaiController@kembalikan');
Route::post('/admin/lantai/hapus_permanen/{id_lantai}', 'LantaiController@hapus_permanen');
//Data Rak
Route::get('/admin/rak', 'RakController@index');
Route::post('/admin/rak/store', 'RakController@store');
Route::post('/admin/rak/update/{id_rak}', 'RakController@update');
Route::post('/admin/rak/delete/{id_rak}', 'RakController@delete');
Route::get('/json-lantai', 'RakController@lantai');
//Trash Rak
Route::get('/admin/rak/trash', 'RakController@trash');
Route::get('/admin/rak/kembalikan/{id_rak}/{id_lantai}', 'RakController@kembalikan');
Route::post('/admin/rak/hapus_permanen/{id_rak}', 'RakController@hapus_permanen');
//Data Perangkat
Route::get('/admin/perangkat', 'PerangkatController@index');
Route::post('/admin/perangkat/store', 'PerangkatController@store');
Route::post('/admin/perangkat/update/{id_perangkat}', 'PerangkatController@update');
Route::post('/admin/perangkat/delete/{id_perangkat}', 'PerangkatController@delete');
Route::get('/json-lantai-rak', 'PerangkatController@lantai');
Route::get('/json-rak-rak', 'PerangkatController@rak');
//Trash Perangkat
Route::get('/admin/perangkat/trash', 'PerangkatController@trash');
Route::get('/admin/perangkat/kembalikan/{id_perangkat}/{id_rak}', 'PerangkatController@kembalikan');
Route::post('/admin/perangkat/hapus_permanen/{id_perangkat}', 'PerangkatController@hapus_permanen');
//Data port
Route::get('/admin/port', 'PortController@index');
Route::post('/admin/port/store', 'PortController@store');
Route::post('/admin/port/update/{id_port}', 'PortController@update');
Route::post('/admin/port/delete/{id_port}', 'PortController@delete');
Route::get('/json-lantai-port', 'PortController@lantai');
Route::get('/json-rak-port', 'PortController@rak');
Route::get('/json-perangkat-port', 'PortController@perangkat');
//Trash Port
Route::get('/admin/port/trash', 'PortController@trash');
Route::get('/admin/port/kembalikan/{id_port}/{id_perangkat}', 'PortController@kembalikan');
Route::post('/admin/port/hapus_permanen/{id_port}', 'PortController@hapus_permanen');
//Data Jenis Perangkat
Route::get('/admin/jenis', 'JenisPerangkatController@index');
Route::post('/admin/jenis/store', 'JenisPerangkatController@store');
Route::post('/admin/jenis/update/{id}', 'JenisPerangkatController@update');
Route::get('/admin/jenis/hapus/{id}', 'JenisPerangkatController@hapus');
//Trash Jenis Perangkat
Route::get('/admin/jenis/kembalikan/{id}', 'JenisPerangkatController@kembalikan');
Route::get('/admin/jenis/kembalikan_semua', 'JenisPerangkatController@kembalikan_semua');
Route::get('/admin/jenis/hapus_permanen/{id}', 'JenisPerangkatController@hapus_permanen');
Route::get('/admin/jenis/hapus_permanen_semua', 'JenisPerangkatController@hapus_permanen_semua');
Route::get('/admin/jenis/trash', 'JenisPerangkatController@trash');
//Cari Data
Route::post('/admin/search','CariDataController@search');
Route::get('/admin/print/{id_gedung}/{id_lantai}/{id_rak}/{id_perangkat}', 'CariDataController@print');
Route::get('/json-lantai-cari', 'CariDataController@lantai');
Route::get('/json-rak-cari', 'CariDataController@rak');
Route::get('/json-perangkat-cari', 'CariDataController@perangkat');

//USER
Route::get('/user/data-gedung', 'GedungController@user_index');
Route::post('/user/search','CariDataController@user_search');
Route::get('/user/print/{id_gedung}/{id_lantai}/{id_rak}/{id_perangkat}', 'CariDataController@user_print');
Route::get('/json-lantai-cari', 'CariDataController@lantai');
Route::get('/json-rak-cari', 'CariDataController@rak');
Route::get('/json-perangkat-cari', 'CariDataController@perangkat');
//Profile User
Route::get('/user/profile', 'ProfileController@editUser');
Route::post('/user/profile/update/{id}', 'ProfileController@update');
Route::post('/user/reset-password/{id}', 'ProfileController@password');
