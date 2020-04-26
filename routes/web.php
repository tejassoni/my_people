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

// Email Verified enables
Auth::routes(['verify' => true]);

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware(['verified', 'auth']); // Bind auth and Email verified


// Admin Panel all routs from website backend
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'web']], function () {
    /* Role Master Module Starts here...! */
    Route::get('/role_list', 'Admin\UserRolesController@list_view');
    Route::get('/role_add', 'Admin\UserRolesController@add_view');
    Route::post('/role_insert', 'Admin\UserRolesController@insert_records');
    Route::get('/role_edit/{id?}', 'Admin\UserRolesController@get_edit_records');
    Route::put('/role_update/{id?}', 'Admin\UserRolesController@update_records');
    Route::get('/role_delete/{id?}', 'Admin\UserRolesController@delete_records');
    Route::post('/delete_roles', 'Admin\UserRolesController@delete_all_records');
    Route::post('/role_status', 'Admin\UserRolesController@status_change');
    /* Role Master Module Ends here...! */

    /* Ear Master Module Starts here...! */
    Route::get('/ear_list', 'Admin\EarMasterController@list_view');
    Route::get('/ear_add', 'Admin\EarMasterController@add_view');
    Route::post('/ear_insert', 'Admin\EarMasterController@insert_records');
    Route::post('/delete_ears', 'Admin\EarMasterController@delete_all_records');
    Route::get('/ear_delete/{id?}', 'Admin\EarMasterController@delete_records');
    Route::post('/ear_status', 'Admin\EarMasterController@status_change');
    Route::get('/ear_edit/{id?}', 'Admin\EarMasterController@get_edit_records');
    Route::put('/ear_update/{id?}', 'Admin\EarMasterController@update_records');
    /* Ear Master Module Ends here...! */

    /* Ear Master Module Starts here...! */
    Route::get('/eyebrow_list', 'Admin\EyeBrowMasterController@list_view');
    Route::get('/eyebrow_add', 'Admin\EyeBrowMasterController@add_view');
    Route::post('/eyebrow_insert', 'Admin\EyeBrowMasterController@insert_records');
    Route::post('/delete_eyebrow', 'Admin\EyeBrowMasterController@delete_all_records');
    Route::get('/eyebrow_delete/{id?}', 'Admin\EyeBrowMasterController@delete_records');
    Route::post('/eyebrow_status', 'Admin\EyeBrowMasterController@status_change');
    Route::get('/eyebrow_edit/{id?}', 'Admin\EyeBrowMasterController@get_edit_records');
    Route::put('/eyebrow_update/{id?}', 'Admin\EyeBrowMasterController@update_records');
    /* Ear Master Module Ends here...! */
}); // Email Verified enables



// Send Email By Hit URL
Route::get('send-mail', 'Email\MailSend@mailsend');
Route::post('user_email/{id?}', 'Email\MailSend@mailsend');
