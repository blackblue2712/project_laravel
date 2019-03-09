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

Route::get('test', 'ProductController@testFunc');
	

Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function(){
	Route::group(['prefix' => 'category'], function(){

		Route::get('add', 'CategoryController@getAdd')->name('admin.category.add');
		Route::post('add', 'CategoryController@postAdd');

		Route::get('list', 'CategoryController@getList')->name('admin.category.list');

		Route::get('delete/{id}', 'CategoryController@getDelete')->name('admin.category.delete');

		Route::get('edit/{id}', 'CategoryController@getEdit')->name('admin.category.edit');
		Route::post('edit/{id}', 'CategoryController@postEdit');

	});

	Route::group(['prefix' => 'product'],function (){

		Route::get('list', 'ProductController@getList');

		Route::get('add', 'ProductController@getAdd');
		Route::post('add', 'ProductController@postAdd');

		Route::get('edit/{id}', 'ProductController@getEdit');
		Route::post('edit/{id}', 'ProductController@postEdit');

		Route::get('delete/{id}', 'ProductController@getDelete');

		Route::get('deleteImage/{id}', 'AjaxController@getDeleteImage');

	});

	Route::group(['prefix' => 'user'], function(){

		Route::get('list', 'UserController@getList');

		Route::get('add', 'UserController@getAdd');
		Route::post('add', 'UserController@postAdd');

		Route::get('edit/{id}', 'UserController@getEdit');
		Route::post('edit/{id}', 'UserController@postEdit');

		Route::get('delete/{id}', 'UserController@getDelete');

		// Login
	});

});

Route::get('login', 'UserController@getLoginAdmin');
Route::post('login', 'UserController@postLoginAdmin');

//Logout
Route::get('logout', 'UserController@getLogout');