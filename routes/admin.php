<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Room;

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
    Route::post('bookings/end/{id}', 'BookingController@end')->name('bookings.end');
    Route::resource('bookings', 'BookingController')->except('show');
    Route::resource('reviews', 'ReviewController')->except('show');
    Route::resource('rooms/{room_id}/devices', 'DeviceController')->except('show');
    Route::post('device/toggle', 'DeviceController@toggle')->name('admin.devices.toggle');
    Route::resource('device-type', 'DeviceTypeController')->except('show');
    Route::resource('settings', 'SettingController')->except('show');
    Route::resource('transactions', 'TransactionController')->except('show');
    Route::resource('packages', 'PackageController')->except('show');
    Route::resource('companies', 'CompanyController');
    Route::post('block-companies','CompanyController@block');
    Route::post('unblock-companies','CompanyController@unblock');

    Route::get('support-chat', 'SupportChatController@index')->name('support-chat.index');
    Route::get('statistics', 'DashboardController@statistics')->name('statistics.index');
    Route::get('customer-service', 'DashboardController@customerService')->name('members.customer-service');
    Route::get('booking-calender', 'BookingController@bookingCalender')->name('booking.calender');
});
