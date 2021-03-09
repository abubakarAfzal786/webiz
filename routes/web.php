<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);

Route::redirect('/', '/dashboard');

Route::get('/frontscreen/{id}', 'PublicController@frontscreen')->name('frontscreen');
Route::get('/book/{id}', 'PublicController@book');
Route::get('/qr', 'PublicController@qrRedirect');
