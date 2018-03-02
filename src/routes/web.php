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
Route::get('users', 'MarkVilludo\Permission\Controllers\RoleController@index')->name('users.index');

Route::resource('users', 'MarkVilludo\Permission\Controllers\UserController');

Route::get('roles/createRoleApi', 'MarkVilludo\Permission\Controllers\RoleController@createRoleApi');
Route::get('roles/createRoleWeb', 'MarkVilludo\Permission\Controllers\RoleController@createRoleWeb');


Route::get('roles/webIndex', 'MarkVilludo\Permission\Controllers\RoleController@webIndex')->name('roles.webIndex');
Route::get('roles/apiIndex', 'MarkVilludo\Permission\Controllers\RoleController@apiIndex')->name('roles.apiIndex');

Route::resource('roles', 'MarkVilludo\Permission\Controllers\RoleController');

Route::get('permissions/webIndex', 'MarkVilludo\Permission\Controllers\PermissionController@webIndex')->name('permissions.webIndex');
Route::get('permissions/apiIndex', 'MarkVilludo\Permission\Controllers\PermissionController@apiIndex')->name('permissions.apiIndex');

Route::resource('permissions', 'MarkVilludo\Permission\Controllers\PermissionController');

