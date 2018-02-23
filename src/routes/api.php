<?php

/*
|--------------------------------------------------------------------------
|  Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', 'MarkVilludo\Permission\Controllers\Api\PassportController@login')->name('login');
Route::post('/register', 'MarkVilludo\Permission\Controllers\Api\PassportController@register')->name('register');
//checkout orders
Route::post('/checkout','MarkVilludo\Permission\Controllers\Api\ShoppingCartController@checkout');

Route::group(['middleware' => 'auth:api'], function(){
	//group by v1
	Route::prefix('v1')->group(function () {

		Route::prefix('permissions')->group(function () {
			//All permissions
			Route::get('/', 'MarkVilludo\Permission\Controllers\Api\PermissionController@index');
			//Create new permission
			Route::post('/', 'MarkVilludo\Permission\Controllers\Api\PermissionController@store');
			//Update permission
			Route::post('/{id}', 'MarkVilludo\Permission\Controllers\Api\PermissionController@update');
			//Delete permission
			Route::delete('/{id}', 'MarkVilludo\Permission\Controllers\Api\PermissionController@destroy');
		});
		
		Route::prefix('roles')->group(function () {
			//All roles
			Route::get('/', 'MarkVilludo\Permission\Controllers\Api\RoleController@index');
			//Create new role
			Route::post('/', 'MarkVilludo\Permission\Controllers\Api\RoleController@store');
			//Update role
			Route::post('/{id}', 'MarkVilludo\Permission\Controllers\Api\RoleController@update');
			//Delete role
			Route::delete('/{id}', 'MarkVilludo\Permission\Controllers\Api\RoleController@destroy');
		});
 	 	
		//Users
		Route::prefix('users')->group(function () {
			//user list
		  	Route::get('/','MarkVilludo\Permission\Controllers\Api\UserController@index');
			//Get user details
			Route::get('/{id}','MarkVilludo\Permission\Controllers\Api\UserController@show');
			//create user
			Route::post('/', 'MarkVilludo\Permission\Controllers\Api\UserController@store');
			//Update user details
			Route::post('/{id}','MarkVilludo\Permission\Controllers\Api\UserController@update');
		});

	});
});
