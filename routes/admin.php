<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index')->name('home');

Route::resource('faq', 'FaqController')->except('show');
Route::resource('faq-category', 'FaqCategoryController')->except('show');
Route::resource('members', 'MemberController')->except('show');
Route::resource('rooms', 'RoomController')->except('show');
Route::resource('room-facility', 'RoomFacilityController')->except('show');
