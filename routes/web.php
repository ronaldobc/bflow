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

use Illuminate\Support\Facades\Auth;


Route::get('login', 'Auth\LoginController@index')->name('login_form');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('forgot_passwd', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot_passwd');
Route::post('forgot_passwd', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgot_passwd');
Route::get('passwd_reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('passwd_reset', 'Auth\ResetPasswordController@reset');


// empresa
Route::resource('empresa', 'EmpresaController');
Route::post('empresa/restore/{id}', 'EmpresaController@restore')->name('empresa.restore');

// usuario
Route::resource('usuario', 'UsuarioController');
Route::post('usuario/restore/{id}', 'UsuarioController@restore')->name('usuario.restore');

// departamento
Route::resource('departamento', 'DepartamentoController');
Route::post('departamento/restore/{id}', 'DepartamentoController@restore')->name('departamento.restore');
Route::get('departamento/empresa/{id}', 'DepartamentoController@index');
Route::get('departamento_tree/{id_empresa}', 'DepartamentoController@tree');
Route::put('departamento/{id}/edit_tree', 'DepartamentoController@update_tree')->name('departamento.update_tree');


Route::get('/', 'HomeController@index')->name('home');
