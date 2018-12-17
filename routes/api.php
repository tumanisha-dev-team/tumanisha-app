<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('riders')->group(function(){
	Route::get('/', 'API\RiderController@index');
	Route::get('/orders/{date}', 'API\RiderController@getRidersOrderByDate');
	Route::post('orders/add', 'API\RiderController@storeOrders');

	Route::get('orders/total/{month}/month', 'API\RiderController@getMonthOrders');

	Route::get('schedule', 'API\RiderController@getSchedule');
  Route::get('schedule/{month}', 'API\RiderController@getMonthlySchedule');
  Route::post('schedule/add', 'API\RiderController@storeRiderSchedule');
});
