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
	Route::post('/rider/add', 'Dashboard\EmployeeController@store')->name('post-new-rider');
});
