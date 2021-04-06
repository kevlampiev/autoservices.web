<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');
Route::post('/autologin', 'API\AuthController@autoLogin')
    ->middleware('auth:api');

Route::group([
    'prefix' => 'services'
], function () {
    Route::get('/', 'API\ServicesController@index')->name('services');
    Route::get('/cities', 'API\ServicesController@cityList')->name('services.city');
    Route::get('/types', 'API\ServicesController@typeList')->name('services.type');
    Route::get('/{service}', 'API\ServicesController@show')->name('serviceData');
    Route::post('/{service}', 'API\ServicesController@setSchedule')->name('storeOrder');
});

Route::post('/order', 'API\OrderController@setOrder')->name('setOrder')->middleware('auth:api');

Route::group([
    'prefix' => 'owner',
    'namespace' => 'API',
    'middleware' => ['auth:api','is.owner']
], function() {

    Route::get('/services', 'OwnerServiceController@index');
    Route::post('/services/add','OwnerServiceController@store');
    Route::put('/services/{id}/edit','OwnerServiceController@update');
});

Route::middleware('auth:api')
    ->group(function () {
        Route::post('/logout', 'API\AuthController@logout');
    }
    );

Route::group([
    'namespace' => 'API',
    'middleware' => ['auth:api','is.owner']
], function () {
    Route::resource('/timeslots', 'TimeSlotController');
});
