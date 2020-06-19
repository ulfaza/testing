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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'UserController@index')->name('home');

Route::get('/profil/{id}', 'UserController@edit');

Route::post('/update','UserController@update');

Route::get('/kuisioner', 'KuisionerController@kuis')->name('kuisioner');

Route::group(['prefix' => 'admin',  'middleware' => 'is_admin'], function(){
// halaman admin disini
	Route::get('/home', 'AdminController@index')->name('adminhome');

	Route::get('/kelolaadmin', 'AdminController@view_admin')->name('adminview');

	Route::get('/profil', 'AdminController@editprofil')->name('editprofil');

	Route::post('/profil', 'AdminController@editprofil');

	Route::get('/profil/{id}', 'AdminController@edit');

	Route::post('/update','AdminController@update');

	Route::get('/tambahadmin', 'AdminController@tambahadmin')->name('tambahadmin');

	Route::post('/storeadmin', 'AdminController@storeadmin');

	Route::get('/tambahbobot', 'AdminController@tambahbobot')->name('tambahbobot');

	Route::get('/delete/user{id}','AdminController@delete')->name('delete.user');

	//Route Aplikasi
	Route::get('/aplikasi', 'AplikasiController@index')->name('index.aplikasi');
	Route::get('/insert/aplikasi', 'AplikasiController@insert')->name('insert.aplikasi');
	Route::post('/store/aplikasi', 'AplikasiController@store')->name('store.aplikasi');
	Route::get('/delete/aplikasi{id}', 'AplikasiController@delete')->name('delete.aplikasi');

	// karakteristik -------
	Route::get('/karakteristik', 'KarakteristikController@index')->name('index.karakteristik');
	Route::get('/tambah_karakteristik', 'KarakteristikController@insert')->name('insert.karakteristik');
	Route::post('/store/karakteristik', 'KarakteristikController@store')->name('store.karakteristik');
	Route::get('/delete/karakteristik{id}','KarakteristikController@delete')->name('delete.karakteristik');
	
	// sub-Karakteristik
	Route::get('/edit_sub/subkarakteristik{id}', 'SubkarakteristikController@edit')->name('edit.sub');
	Route::post('/update/subkarakteristik{id}','SubkarakteristikController@update')->name('update.sub');



});

