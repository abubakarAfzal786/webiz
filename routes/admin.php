<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index')->name('home');

Route::group(['as' => 'admin.'], function () {
    Route::resource('faq', 'FaqController')->except('show');
    Route::resource('faq-category', 'FaqCategoryController')->except('show');
    Route::resource('members', 'MemberController')->except('show');
    Route::get('members/{id}/profile', 'MemberController@profile')->name('members.profile');
    Route::post('members/{id}/reset-link', 'MemberController@sendResetLink')->name('members.reset-link');
    Route::post('members/{id}/add-credits', 'MemberController@addCredits')->name('members.add-credits');
    Route::post('members/{id}/change-status', 'MemberController@changeStatus')->name('members.change-status');
    Route::resource('rooms', 'RoomController');
    Route::resource('room-facility', 'RoomFacilityController')->except('show');
    Route::resource('room-type', 'RoomTypeController')->except('show');
    Route::resource('room-attribute', 'RoomAttributeController')->except('show');
    Route::resource('bookings', 'BookingController')->except('show');
    Route::resource('reviews', 'ReviewController')->except('show');
    Route::resource('rooms/{room_id}/devices', 'DeviceController')->except('show');
    Route::resource('device-type', 'DeviceTypeController')->except('show');
    Route::resource('settings', 'SettingController')->except('show');
    Route::resource('transactions', 'TransactionController')->except('show');
    Route::get('support-chat', 'SupportChatController@index')->name('support-chat.index');
});
