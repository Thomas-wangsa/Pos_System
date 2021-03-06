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
Route::post('ajax/get_customer_by_sales_id','CustomerController@get_customer_by_sales_id')->name('customer.get_customer_by_sales_id');
Route::post('ajax/restore_customer_by_uuid','CustomerController@restore_customer_by_uuid')->name('customer.restore_customer_by_uuid');



Route::resource('/po', 'POController');
Route::get('po/edit_sub_po','POController@edit_sub_po')->name('po.edit_sub_po');
Route::post('po/edit_status_po','POController@edit_status_po')->name('po.edit_status_po');
Route::post('ajax/get_po_by_customer_uuid','POController@get_po_by_customer_uuid')->name('po.get_po_by_customer_uuid');
Route::post('ajax/get_po_by_uuid','POController@get_po_by_uuid')->name('po.get_po_by_uuid');
Route::post('ajax/submit_po_by_customer_uuid','POController@submit_po_by_customer_uuid')->name('po.submit_po_by_customer_uuid');
Route::post('ajax/update_po_by_po_uuid','POController@update_po_by_po_uuid')->name('po.update_po_by_po_uuid');
Route::post('ajax/submit_sub_po_by_po_uuid','POController@submit_sub_po_by_po_uuid')->name('po.submit_sub_po_by_po_uuid');
Route::post('ajax/update_sub_po_by_sub_po_uuid','POController@update_sub_po_by_sub_po_uuid')->name('po.update_sub_po_by_sub_po_uuid');
Route::post('ajax/restore_sub_po_by_sub_po_uuid','POController@restore_sub_po_by_sub_po_uuid')->name('po.restore_sub_po_by_sub_po_uuid');
Route::post('ajax/get_sales_subpo_by_po_uuid','POController@get_sales_subpo_by_po_uuid')->name('po.get_sales_subpo_by_po_uuid');



Route::resource('/do', 'DOController');
Route::post('do/edit_status_do','DOController@edit_status_do')->name('do.edit_status_do');
Route::post('ajax/get_delivery_order_by_uuid','DOController@get_do_by_uuid')->name('do.get_do_by_uuid');
Route::post('ajax/do/added_sub_do_by_uuid','DOController@added_sub_do_by_uuid')->name('do.added_sub_do_by_uuid');
Route::post('ajax/do/update_sub_do_by_uuid','DOController@update_sub_do_by_uuid')->name('do.update_sub_do_by_uuid');
Route::post('ajax/do/restore_sub_do_by_uuid','DOController@restore_sub_do_by_uuid')->name('do.restore_sub_do_by_uuid');




Route::resource('/invoice', 'InvoiceController');
Route::post('ajax/get_invoice_by_uuid','InvoiceController@get_invoice_by_uuid')->name('invoice.get_invoice_by_uuid');
Route::post('ajax/set_success_status_invoice','InvoiceController@set_success_status_invoice')->name('invoice.set_success_status_invoice');

Route::resource('/config', 'ConfigController');
Route::get('/adhoc/edit_config', 'ConfigController@edit_config')->name('config.edit_config');
Route::post('/adhoc/update_config', 'ConfigController@update_config')->name('config.update_config');
Route::get('/adhoc/edit_driver', 'ConfigController@edit_driver')->name('config.edit_driver');
Route::post('/adhoc/update_driver', 'ConfigController@update_driver')->name('config.update_driver');
Route::get('/adhoc/delete_config', 'ConfigController@delete_config')->name('config.delete_config');
Route::get('/adhoc/restore_config', 'ConfigController@restore_config')->name('config.restore_config');



Route::resource('/profile', 'ProfileController');

Route::resource('/report', 'ReportController');
Route::resource('/report_po', 'ReportPOController');



Route::get('/view-report/get_report', 'ReportController@get_report')->name('report.get_report');
Route::get('/view-po-report/get_po_report', 'ReportPOController@get_po_report')->name('report_po.get_po_report');



Route::resource('/doc', 'DocumentationController');
