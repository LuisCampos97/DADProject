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
Route::get('items', 'ItemController@index');
Route::get('items/{id}', 'ItemController@show');
Route::get('users', 'UserControllerAPI@index');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::post('users', 'UserControllerAPI@store');
Route::post('users/{id}', 'UserControllerAPI@postPhoto');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::put('users/{id}/shift', 'UserControllerAPI@invertShift');
Route::delete('users/{id}', 'UserControllerAPI@destroy');

Route::post('meals/register', 'MealController@create');
Route::get('meals', 'MealController@index');
Route::get('meals/{id}', 'MealController@show');

Route::get('orders', 'OrderController@index');
Route::get('orders/{id}', 'OrderController@show');

/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id
Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
 */
Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::post('register', 'Auth\RegisterController@create');
 
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
Route::get('profiles', 'UserControllerAPI@index')->name('profile');
Route::get('profile/{id}', 'UserControllerAPI@getProfile')->name('profile');