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
Route::post('/login', 'Api\PassportController@login');
Route::post('/register', 'Api\PassportController@register');
//checkout orders
Route::post('/checkout','Api\ShoppingCartController@checkout');

Route::group(['middleware' => 'auth:api'], function(){
	//group by v1
	Route::prefix('v1')->group(function () {

		Route::prefix('permissions')->group(function () {
			//All permissions
			Route::get('/', 'Api\PermissionController@index');
			//Create new permission
			Route::post('/', 'Api\PermissionController@store');
			//Update permission
			Route::post('/{id}', 'Api\PermissionController@update');
			//Delete permission
			Route::delete('/{id}', 'Api\PermissionController@destroy');
		});
		
		Route::prefix('roles')->group(function () {
			//All roles
			Route::get('/', 'Api\RoleController@index');
			//Create new role
			Route::post('/', 'Api\RoleController@store');
			//Update role
			Route::post('/{id}', 'Api\RoleController@update');
			//Delete role
			Route::delete('/{id}', 'Api\RoleController@destroy');
		});
 	 	
		//Users
		Route::prefix('users')->group(function () {
			//user list
		  	Route::get('/','Api\UserController@index');
			//Get user details
			Route::get('/{id}','Api\UserController@show');
			//create user
			Route::post('/', 'Api\UserController@store');
			//Update user details
			Route::post('/{id}','Api\UserController@update');
		});

	});
});
