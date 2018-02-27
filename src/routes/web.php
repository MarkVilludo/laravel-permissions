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

Route::resource('users', 'MarkVilludo\Permission\Controllers\UserController');

Route::get('roles/createRoleApi', 'MarkVilludo\Permission\Controllers\RoleController@createRoleApi');
Route::get('roles/createRoleWeb', 'MarkVilludo\Permission\Controllers\RoleController@createRoleWeb');
Route::resource('roles', 'MarkVilludo\Permission\Controllers\RoleController');

Route::resource('permissions', 'MarkVilludo\Permission\Controllers\PermissionController');

