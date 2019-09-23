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
   // Route::get('/','Auth\LoginController@login');
    Route::get('/admin','Auth\LoginController@login');
    Route::get('abc', 'Auth\LoginController@showAdminLoginForm');
    Route::get('writer-login', 'Auth\LoginController@showWriterLoginForm');
    Route::get('admin-register', 'Auth\RegisterController@showAdminRegisterForm');
    Route::get('writer-register', 'Auth\RegisterController@showWriterRegisterForm');

    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
    Route::post('/login/writer', 'Auth\LoginController@writerLogin');
    Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
    Route::post('/register/writer', 'Auth\RegisterController@createWriter');

    Route::view('/home', 'home')->middleware('auth');
    Route::view('/admin', 'admin');
    Route::view('/writer', 'writer');
    
    //user mgt
Route::get('user_mgt','UserController@userList');
Route::get('add-user','UserController@addUser');
Route::post('add-user','UserController@saveUser');
Route::get('edit-user','UserController@ediUser');
Route::put('update-user/{id}','UserController@updateUser');
Route::get('delete-user/{id}','UserController@deletUser');


//Biness Owner
Route::get('owner-list','BusinessOwnerController@ownerList');
Route::get('add-owner','BusinessOwnerController@addOwner');
Route::post('add-owner','BusinessOwnerController@saveOwner');
Route::get('edit-owner','BusinessOwnerController@editOwner');
Route::put('update-owner/{id}','BusinessOwnerController@updateOwner');
Route::get('delete-owner/{id}','BusinessOwnerController@deletOwner');

//Get masterdata
Route::get('item_data','MasterController@getItemData');
Route::get('cust_data','MasterController@getCustData');
Route::get('category_data','MasterController@getCategoryData');
Route::get('subscription_data','MasterController@getSubscriptionData');
Route::get('add_item','MasterController@getItem');
Route::get('add_cust','MasterController@getCust');
Route::get('add_category','MasterController@getCategory');
Route::get('add_subscription','MasterController@getSubscription');

//Add masterdata
Route::post('add_item','MasterController@addItem');
Route::post('add_cust','MasterController@addCust');
Route::post('add_category','MasterController@addCategory');
Route::post('add_subscription','MasterController@addSubscription');

//edit masterdata
Route::get('edit-item','MasterController@editItem');
Route::get('edit-cust','MasterController@editCust');
Route::post('edit-item','MasterController@updateItem');
Route::post('edit-cust','MasterController@updateCust');
Route::get('edit-category','MasterController@editCategory');
Route::post('edit-category','MasterController@updateCategory');
Route::get('edit-subscription','MasterController@editSubscription');
Route::post('edit-subscription','MasterController@updateSubscription');

//delete masterdata
Route::get('delete-item/{item_id}','MasterController@deleteItem');
Route::get('delete-cust/{cust_id}','MasterController@deleteCust');
Route::get('delete-category/{cat_id}','MasterController@deleteCategory');
Route::get('delete-subscription/{sub_id}','MasterController@deleteSubscription');


Route::prefix('admin')->group(function () {
// Route::get('/', 'Auth\LoginController@showAdminLoginForm');
  Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
  Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('admin.register');
  Route::post('register', 'AdminController@store')->name('admin.register.store');
  Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('admin.auth.login');
  Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
  Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');
});
