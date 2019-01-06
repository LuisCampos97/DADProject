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

//Items
Route::get('items', 'ItemController@index');
Route::get('items/{id}', 'ItemController@show');
Route::post('items/register', 'ItemController@register');
Route::put('items/{id}', 'ItemController@update');
Route::delete('items/{id}', 'ItemController@destroy');

//Users
Route::get('users', 'UserControllerAPI@index');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::post('users', 'UserControllerAPI@store');
Route::post('users/{id}', 'UserControllerAPI@postPhoto');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::put('users/{id}/shift', 'UserControllerAPI@invertShift');
Route::delete('users/{id}', 'UserControllerAPI@destroy');
Route::get('profiles', 'UserControllerAPI@index')->name('profile');
Route::get('profile/{id}', 'UserControllerAPI@getProfile')->name('profile');

//Meals
Route::post('meals/register', 'MealController@create');
Route::get('meals', 'MealController@index');
Route::put('meals/terminate/{id}', 'MealController@terminate');
Route::get('meals/{id}', 'MealController@show');
Route::put('meals/{id}/{total}', 'MealController@updateTotal');

//Orders
Route::post('orders/register', 'OrderController@create');
Route::get('orders', 'OrderController@index');
Route::get('orders/{id}', 'OrderController@show');
Route::get('ordersCook/{responsible_cook_id}', 'OrderController@ordersByCook');
Route::middleware('auth:api')->put('orders/{id}', 'OrderController@updateState');
Route::put('orders/terminate/{id}', 'OrderController@terminate');
Route::delete('orders/{id}', 'OrderController@destroy');

//Invoices
Route::post('invoices/register', 'InvoiceController@create');
Route::get('invoices', 'InvoiceController@index');
Route::get('invoices/all', 'InvoiceController@indexAll');
Route::get('invoices/{id}', 'InvoiceController@show');
Route::get('mealForInvoice', 'InvoiceController@mealForInvoice');
Route::get('invoiceDetails/{id}', 'InvoiceController@invoiceDetails');
Route::put('invoices/notPaid/{id}', 'InvoiceController@notPaid');
Route::get('invoiceItems/{id}', 'InvoiceController@invoiceItems');
Route::put('invoices/{id}', 'InvoiceController@payInvoice');

//RestaurantTable
Route::get('restaurantTables', 'RestaurantTableController@index');
Route::post('restaurantTables/register', 'RestaurantTableController@register');
//Invoice Items
Route::post('invoiceItems/register', 'InvoiceItemController@create');

//Authentication
Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::post('register', 'Auth\RegisterController@create');
Route::get('register/activate/{token}', 'Auth\RegisterController@accountValidate');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');