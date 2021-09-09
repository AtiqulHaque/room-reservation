<?php
Route::group(['middleware' => 'cors'], function () {
    Route::post('/book/room', 'BookingsController@bookingRoom');
    Route::get('/booking/list', 'BookingsController@bookingList');
    Route::get('/booking/{booking_id}', 'BookingsController@bookingDetails');
    Route::post('/check/room-available', 'BookingsController@checkRoomAvailable');
});


