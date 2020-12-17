<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'support'], function () {
    Route::get('tickets', 'SupportController@tickets')->name('support.tickets.index');
    Route::get('messages/{id}', 'SupportController@messages')->name('support.messages.index');
    Route::get('messages-count', 'SupportController@messagesCount')->name('support.messages.count');
});

Route::group(['middleware' => 'auth:api'], function () {
    // APP_URL/api-admin/bookings/{id}/complete
    Route::post('bookings/{id}/complete', 'BookingController@complete')->name('booking.complete');
});
