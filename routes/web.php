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
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


// Admin Panel all routs from website backend
Route::group(['prefix' => 'admin'], function () {
    // Role Master Module Starts here...!
    Route::get('/role_list', 'Admin\UserRolesController@list_view');
    
    Route::get('/role_add', 'Admin\UserRolesController@add_view');
    Route::post('/role_insert', 'Admin\UserRolesController@insert_records');

    Route::get('/role_edit/{id?}', 'Admin\UserRolesController@get_edit_records');
    Route::put('/role_update/{id?}', 'Admin\UserRolesController@update_records');

    // Role Master Module Ends here...!
    
});
