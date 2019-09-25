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

Route::get('/', function () {
	return redirect('login');
});

Auth::routes();

Route::get('/logout',function(){
	Auth::guard()->logout();
    return redirect('/login');
});

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('/user', 'UserController');
Route::post('ajax/get_user_by_uuid','UserController@get_user_by_uuid')->name('user.get_user_by_uuid');
Route::post('ajax/restore_user_by_uuid','UserController@restore_user_by_uuid')->name('user.restore_user_by_uuid');



Route::resource('/customer', 'CustomerController');
Route::post('ajax/get_customer_by_category_id','CustomerController@get_customer_by_category_id')->name('customer.get_customer_by_category_id');
Route::post('ajax/get_customer_by_uuid','CustomerController@get_customer_by_uuid')->name('customer.get_customer_by_uuid');



Route::resource('/po', 'POController');
Route::resource('/do', 'DOController');
Route::resource('/invoice', 'InvoiceController');


Route::resource('/config', 'ConfigController');



Route::post('ajax/get_po_by_customer_uuid','POController@get_po_by_customer_uuid')->name('po.get_po_by_customer_uuid');
Route::post('ajax/get_po_by_uuid','POController@get_po_by_uuid')->name('po.get_po_by_uuid');
Route::post('ajax/get_delivery_order_by_uuid','DOController@get_do_by_uuid')->name('do.get_do_by_uuid');
Route::post('ajax/get_invoice_by_uuid','InvoiceController@get_invoice_by_uuid')->name('invoice.get_invoice_by_uuid');