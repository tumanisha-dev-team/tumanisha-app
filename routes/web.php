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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::prefix('assets')->group(function(){
	Route::get('/', 'Dashboard\AssetManagementController@index')->name('assets-home');
	Route::post('add-asset', 'Dashboard\AssetManagementController@store')->name('addAsset');
	Route::get('manage-asset/{id}', 'Dashboard\AssetManagementController@manage')->name('manageAsset');
	Route::put('manage-asset/edit/{id}', 'Dashboard\AssetManagementController@update')->name('editAsset');
	Route::post('/manage-asset/add-tracker-report/{id}', 'Dashboard\AssetManagementController@storeTrackerReport')->name('addTrackerReport');
});

Route::prefix('employees')->group(function(){
	Route::get('/riders', 'Dashboard\EmployeeController@riders')->name('riders-list');
	Route::get('/rider/new', 'Dashboard\EmployeeController@newRider')->name('new-rider');
	Route::get('/rider/{id}/edit', 'Dashboard\EmployeeController@editRider')->name('edit-rider');
	Route::post('/rider/add', 'Dashboard\EmployeeController@store')->name('post-new-rider');
	Route::post('/rider/{id}/edit', 'Dashboard\EmployeeController@updateRider')->name('update-rider');
	Route::get('/rider/{id}/details', 'Dashboard\EmployeeController@details')->name('rider-details');
	Route::get('/riders/schedule/weeklyoffdays', 'Dashboard\EmployeeController@weeklyschedule')->name('rider-off-days');
	Route::get('/rider/profile_photo/{id}', function($id){
		$rider = \App\Rider::find($id);
		if ($rider->photo_url) {
			return response()->download(storage_path("app/" . $rider->photo_url));
		}
	})->name('rider-profile');
	Route:: post('/rider/deactivate', 'Dashboard\EmployeeController@deactivateRider')->name('deactivate-rider');

	Route::get('/rider/numbers', 'Dashboard\RiderNumbersController@index')->name('rider-numbers');
	Route::get('/rider/numbers/summary', 'Dashboard\RiderNumbersController@riderSummary')->name('rider-numbers-summary');

	Route::get('/riders/schedule', 'Dashboard\EmployeeController@generateScheduleReport')->name('schedule-report');
});

Route::prefix('invoices')->group(function(){
	Route::get('/', 'Dashboard\InvoiceController@index')->name('invoices_home');
	Route::post('/add-invoice', 'Dashboard\InvoiceController@store')->name('add-invoice');
	Route::get('/download/{id}', 'Dashboard\InvoiceController@downloadInvoice')->name('download-invoice');
	Route::get('/edit/{id}', 'Dashboard\InvoiceController@editInvoice')->name('edit-invoice');
	Route::post('/edit/{id}', 'Dashboard\InvoiceController@update')->name('invoice-send-update');
});

Route::prefix('users')->group(function(){
	Route::get('/', 'Dashboard\UserController@index')->name('user-management');
});
