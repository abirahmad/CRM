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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::group(['prefix' => 'employers'], function () {

//     // All Employer Lists
//     Route::get('all', 'API\EmployersController@index')->name('api.all_employers');
//     Route::get('all-data', 'API\EmployersController@employers_for_datatable')->name('api.all_employers_data');
// });
