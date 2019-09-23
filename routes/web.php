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

Route::view('/', 'welcome');
Auth::routes();
Route::get('/','Auth\LoginController@showLoginForm');
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleGoogleCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
//User List
Route::post('register','UserController@saveUser');
Route::get('user-list','UserController@userList');
Route::get('edit-user','UserController@userEdit');
Route::put('update-user/{id}','UserController@updateUser');
Route::get('delete-user/{id}','UserController@deletUser');

Route::get('/home', 'HomeController@index');
//Route::post('/login' , 'Auth\AuthController@authenticate');
//Enquiry
Route::get('enquiry-list','EnquiryController@enquiryList');
Route::get('add-enquiry','EnquiryController@addEnquiry');
Route::post('add-enquiry','EnquiryController@saveEnquiry');
Route::get('edit-enquiry','EnquiryController@editEnquiry');
Route::put('update-enquiry/{id}','EnquiryController@updateEnquiry');
Route::get('delete-enquiry/{id}','EnquiryController@deletEnquiry');
Route::get('mobile-validate/{id}','EnquiryController@validateMobile');

Route::get('get_city/{id}','MasterController@getCity');
//Enquiry Status
Route::get('enquiry-status','EnquiryStatusController@statusList');
Route::get('add-enquiry-status','EnquiryStatusController@addEnquirystatus');
Route::post('add-enquiry-status','EnquiryStatusController@saveStatus');
Route::get('edit-enquiry-status','EnquiryStatusController@editStatus');
Route::put('update-enquiry-status/{id}','EnquiryStatusController@updateStatus');
Route::get('delete-enquiry-status/{id}','EnquiryStatusController@deleteStatus');


//Get masterdata
Route::get('item_data','MasterController@getItemData');
Route::get('add_item','MasterController@getItem');
Route::post('add_item','MasterController@addItem');
Route::get('edit-item','MasterController@editItem');
Route::post('edit-item','MasterController@updateItem');
Route::get('delete-item/{item_id}','MasterController@deleteItem');


Route::get('cust_data','MasterController@getCustData');
Route::get('add_cust','MasterController@getCust');
Route::post('add_cust','MasterController@addCust');
Route::get('edit-cust','MasterController@editCust');
Route::post('edit-cust','MasterController@updateCust');
Route::get('delete-cust/{cust_id}','MasterController@deleteCust');

//Enquiry Status
Route::get('active-inactive','ActiveInactiveController@statusList');
Route::get('add-active-inactive','ActiveInactiveController@addEnquirystatus');
Route::post('add-active-inactive','ActiveInactiveController@saveStatus');
Route::get('edit-active-inactive','ActiveInactiveController@editStatus');
Route::put('update-active-inactive/{id}','ActiveInactiveController@updateStatus');
Route::get('delete-active-inactive/{id}','ActiveInactiveController@deleteStatus');

Route::get('email-validate/{id}','UserController@validateEmail');
Route::get('dashboard_enq_list','MasterController@dashboard_enq_list');



