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
    return view('login');
});
Route::get('/home', function () {
    return view('index');
});
Route::get('/logout', function () {
    Auth::logout();
    return view('login');
});

Route::resource('users', 'MarkVilludo\Permission\Controllers\UserController');

Route::resource('roles', 'MarkVilludo\Permission\Controllers\RoleController');

Route::resource('permissions', 'MarkVilludo\Permission\Controllers\PermissionController');

Route::resource('posts', 'MarkVilludo\Permission\Controllers\PostController');
