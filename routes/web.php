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

Route::get('test', function(){
	return view('admin.category.add');
});

Route::group(['prefix' => 'admin'], function(){
	Route::group(['prefix' => 'category'], function(){

		Route::get('add', 'CategoryController@getAdd')->name('admin.category.add');
		Route::post('add', 'CategoryController@postAdd');

	});
});