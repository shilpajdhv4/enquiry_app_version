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

//Route::get('/home', 'HomeController@index');


Route::get('client-register','Auth\ClientController@showRegform');
Route::post('client-register','Auth\ClientController@create');

Route::get('/', 'Auth\AdminController@showLoginForm');
Route::post('admin-login', ['as'=>'admin-login','uses'=>'Auth\AdminController@login']);
Route::post('/admin-logout', 'Auth\AdminController@logout');//->name('admin.logout');


Route::get('login','Auth\LoginController@showLoginForm')->name('login');

Route::get('home-admin','HomeController@indexAdmin')->name('admin');
//Employee login
Route::get('employee-login','Auth\EmployeeController@showLoginForm');
Route::post('employee-login','Auth\EmployeeController@login');
Route::get('employee-home','HomeController@empIndex');
Route::post('/employee-logout', 'Auth\EmployeeController@logout');

//User List
Route::get('register','UserController@addEmployee');
Route::post('register','UserController@saveUser');
Route::get('user-list','UserController@userList');
Route::get('edit-user','UserController@userEdit');
Route::put('update-user/{id}','UserController@updateUser');
Route::get('delete-user/{id}','UserController@deletUser');

Route::get('/home', 'ClientController@indexHome');
Route::get('dashboard_enq_list','HomeController@dashboard_enq_list');
//Route::post('/login' , 'Auth\AuthController@authenticate');
//

//Enquiry
Route::get('enq_field','EnquiryFieldController@getField');
Route::post('enq_field','EnquiryFieldController@postField');

//Category
Route::get('enq_category','EnquiryFieldController@getCategoryList');
Route::get('add_enq_category','EnquiryFieldController@getDropdown');
Route::post('add_enq_category','EnquiryFieldController@saveCategory');
Route::get('edit_enq_category','EnquiryFieldController@editCategory');
Route::post('update_enq_category','EnquiryFieldController@updateEnqCategory');
Route::get('delete_enq_category/{id}','EnquiryFieldController@deleteEnqCategory');

//Enquiry template
Route::get('enq_templates','EnquiryFieldController@getTemplateList');
Route::get('add_enq_template','EnquiryFieldController@getTemplate');
Route::post('add_enq_template','EnquiryFieldController@saveTemplate');
Route::post('update_category','EnquiryFieldController@updateCategory');
Route::post('update_field','EnquiryFieldController@updateField');
Route::get('enq_edit','EnquiryFieldController@editEnquiry');
Route::post('enq_edit','EnquiryFieldController@updateEnquiry');
Route::get('enq_template_del/{id}','EnquiryFieldController@deleteEnqTep');
//Route::get('prev_category/{id}','EnquiryFieldController@prevCategory');

//Enquiry Product
Route::post('product','EnquiryFieldController@saveProduct');

//Enquiry
Route::get('enq_temp_value/{id}','EnquiryController@getEnqfield');
Route::get('enq_sub_cat/{id}','EnquiryController@getSubcat');
Route::get('enquiry-list','EnquiryController@enquiryList');
Route::get('add-enquiry','EnquiryController@addEnquiry');
Route::post('add-enquiry','EnquiryController@saveEnquiry');
Route::get('edit-enquiry','EnquiryController@editEnquiry');
Route::put('update-enquiry/{id}','EnquiryController@updateEnquiry');
Route::get('delete-enquiry/{id}','EnquiryController@deletEnquiry');
//Route::get('mobile-validate/{id}','EnquiryController@validateMobile');
//Employee Enquiry
Route::get('enq_temp_value1/{id}','EnquiryController@getEnqfield1');
Route::get('enq_sub_cat1/{id}','EnquiryController@getSubcat1');

Route::get('product_val/{id}','EnquiryController@getProduct');
Route::get('get_city/{id}','MasterController@getCity');
Route::get('email-validate/{id}','AdminValidationController@validateEmail');
Route::get('mobile-validate/{id}','AdminValidationController@validateMobile');
Route::get('employee-mobile/{id}','UserController@validateEmployeeMobile');

//Add Location
Route::get('enq_location_list','EnquiryLocationController@listLocation');
Route::get('enq_location_add','EnquiryLocationController@addLocation');
Route::post('enq_location_save','EnquiryLocationController@saveLocation');
Route::get('enq-location-edit','EnquiryLocationController@editLocation');
Route::post('enq_location_update','EnquiryLocationController@updateLocation');
Route::get('enq-location-delete/{id}','EnquiryLocationController@deleteLocation');

Route::get('enq-setting','EnquiryFieldController@getSetting');
Route::post('enq-setting','EnquiryFieldController@saveSetting');

//client data
Route::get('client_data','ClientController@getClientData');
Route::get('active_link/{id}/{val}','ClientController@getActivate');
