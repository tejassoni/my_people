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
    // Role Master Module Starts here...!
    Route::get('/role_list', 'Admin\UserRolesController@list_view');

    Route::get('/role_add', 'Admin\UserRolesController@add_view');
    Route::post('/role_insert', 'Admin\UserRolesController@insert_records');

    Route::get('/role_edit/{id?}', 'Admin\UserRolesController@get_edit_records');
    Route::put('/role_update/{id?}', 'Admin\UserRolesController@update_records');

    Route::get('/role_delete/{id?}', 'Admin\UserRolesController@delete_records');
    Route::post('/delete_roles', 'Admin\UserRolesController@delete_all_records');

    Route::post('/role_status', 'Admin\UserRolesController@status_change');
    // Role Master Module Ends here...!

}); // Email Verified enables



// Send Email By Hit URL
Route::get('send-mail', 'Email\MailSend@mailsend');
Route::post('user_email/{id?}', 'Email\MailSend@mailsend');
