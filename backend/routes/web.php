<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

Route::get('/', function () {
    return view('layout/master');
});
Route::get('/product', function () {
    return view('pages/product/list');
});
Route::get('/product/create', function () {
    return view('pages/product/create');
});
Route::get('/vouchermg', [
    'uses' => 'VoucherController@index',
]);

Route::get('/vouchermg/create', function () {
    return view('pages/vouchermg/create');
});
Route::get('/vouchermg/insert', [
    'uses' => 'VoucherController@insert',
]);
Route::get('/vouchermg/edit/{id}', 'VoucherController@edit');
Route::get('/vouchermg/update', [
    'uses' => 'VoucherController@update',
]);

Route::get('/vouchermg/delete/{id}', 'VoucherController@destroy');

Route::get('/id/{id}', function ($id) {
    return "Hello World!!! this is my id : " . $id;
});
Route::get('/role', [
    'middleware' => 'Role:editor',
    'uses' => 'TestController@index',
]);
Route::get('terminate', [
    'middleware' => 'terminate',
    'uses' => 'ABCController@index',
]);
Route::get('/usercontroller/path', [
    'middleware' => 'First',
    'uses' => 'UserController@showPath',
]);
Route::group(['middleware' => 'cors'], function () {
    Route::get('home/products', 'Api\ApiHomeController@getHome');
    Route::get('home/category/{id}/{page}', 'Api\ApiHomeController@getCategoryProducts');
    Route::get('/api/search', 'Api\ApiSearchController@search');
    Route::get('/api/get_categories', 'Api\ApiSearchController@getCategories');
});

Route::group(['middleware' => 'cors', 'prefix' => 'api'], function () {
    //authentication 
    Route::post('auth/token', 'Api\ApiLoginController@authenticate');
    Route::post('auth/register', 'Api\ApiRegisterController@register');
    Route::post('auth/reset', 'Api\ApiResetPasswordController@resetPwd');
    Route::post('auth/refresh', 'Api\ApiLoginController@refreshToken');

    Route::get('product/details/{id}', 'Api\ApiProductController@details');

    /* Review */
    // Route::get('reviews', 'ReviewController@index');
    Route::get('reviews/{id}', 'ReviewController@find');
    
    /* Balance */
    Route::get('balances', 'Api\ApiBalanceController@index');
    // Route::get('reviews/{id}', 'ReviewController@find');
});
Route::get('test/api', 'Api\ApiTestController@index');

Route::group(['middleware' => ['cors', 'auth:api'], 'prefix' => 'api'], function () {
    Route::get('getuserdetails', 'UserController@getUserDetails');
    Route::post('change-profile', 'UserController@changeProfile');

    Route::resource('product', 'Api\ApiProductController');
    Route::post('product/generatedownloadurl', 'Api\ApiProductDownloadController@generateDownloadUrl');

    Route::resource('category', 'Api\ApiCategoryController');
    Route::resource('subcategory', 'Api\ApiSubCategoryController');
    Route::get('subcategory/getbycatid/{id}', 'Api\ApiSubCategoryController@getByCatId');

    Route::resource('paymentmethod', 'Api\ApiPaymentMethodController');
    Route::resource('payment', 'PaymentPaypalController');
    Route::post('payment/create', 'Api\Payment\ApiPaymentController@create');
    Route::post('sumarypayment', 'Api\Payment\ApiPaymentController@createSumaryAction');

    /* Review */
    Route::post('review/add', 'ReviewController@store');    
    Route::post('review/edit', 'ReviewController@edit');

    /* Balance */  
    Route::post('balance/edit', 'Api\ApiBalanceController@edit');

    /* Payment */  
    Route::post('payment/add', 'Api\Payment\PaymentController@create');
});
Route::get('donebalance', 'Api\Payment\ApiPaymentController@doneBalanceAction');
Route::get('product/download', 'Api\ApiProductDownloadController@downloadAction');
Route::get('paymentpaypal/callback', 'PaymentPaypalController@paymentResponse');

Auth::routes();

Route::get('/home', 'HomeController@index');
