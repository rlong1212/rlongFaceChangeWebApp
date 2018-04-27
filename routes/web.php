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
Route::get('/about', function() {
	return view('about');
});
Route::get('/testimonials', function() {
	return view('testimonials');
});


Auth::routes();
Route::resource('users', 'UserController');
Route::resource('admins', 'AdminController');

//user routes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/manipulate', 'ManipulateController@index');
Route::get('/savedlooks', 'SavedLooksController@index');

//admin routes
//login
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin', 'AdminController@index')->name('admin.dashboard');
//password resets
Route::post('/admin/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/admin/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/admin/password/reset', 'Auth\AdminResetPasswordController@reset');
Route::get('/admin/password/reset/{token}' , 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
//admin activities
Route::get('/admin/viewEditUsers', 'Auth\AdminViewEditUsersController@index')->name('admin.users');
Route::get('/admin/viewEditAdmins', 'Auth\AdminViewEditAdminsController@index')->name('admin.admins');
