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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin',  'middleware' => 'is_admin'], function(){
// halaman admin disini
	Route::get('/home', 'AdminController@index')->name('adminhome');

	Route::get('/kelolaadmin', 'AdminController@view_admin')->name('adminview');

	Route::get('/profil', 'AdminController@editprofil')->name('editprofil');

	Route::get('/profil/{username}', 'AdminController@editprofil');

	Route::post('/profil', 'AdminController@editprofil');

	Route::get('/tambahadmin', 'AdminController@tambahadmin')->name('tambahadmin');

	Route::post('/storeadmin', 'AdminController@storeadmin');

	Route::get('/tambahbobot', 'AdminController@tambahbobot')->name('tambahbobot');

});

