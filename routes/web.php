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

    /* EyeBrow Master Module Starts here...! */
    Route::get('/eyebrow_list', 'Admin\EyeBrowMasterController@list_view');
    Route::get('/eyebrow_add', 'Admin\EyeBrowMasterController@add_view');
    Route::post('/eyebrow_insert', 'Admin\EyeBrowMasterController@insert_records');
    Route::post('/delete_eyebrow', 'Admin\EyeBrowMasterController@delete_all_records');
    Route::get('/eyebrow_delete/{id?}', 'Admin\EyeBrowMasterController@delete_records');
    Route::post('/eyebrow_status', 'Admin\EyeBrowMasterController@status_change');
    Route::get('/eyebrow_edit/{id?}', 'Admin\EyeBrowMasterController@get_edit_records');
    Route::put('/eyebrow_update/{id?}', 'Admin\EyeBrowMasterController@update_records');
    /* EyeBrow Master Module Ends here...! */

    /* Eye Master Module Starts here...! */
    Route::get('/eye_list', 'Admin\EyeMasterController@list_view');
    Route::get('/eye_add', 'Admin\EyeMasterController@add_view');
    Route::post('/eye_insert', 'Admin\EyeMasterController@insert_records');
    Route::post('/delete_eye', 'Admin\EyeMasterController@delete_all_records');
    Route::get('/eye_delete/{id?}', 'Admin\EyeMasterController@delete_records');
    Route::post('/eye_status', 'Admin\EyeMasterController@status_change');
    Route::get('/eye_edit/{id?}', 'Admin\EyeMasterController@get_edit_records');
    Route::put('/eye_update/{id?}', 'Admin\EyeMasterController@update_records');
    /* Eye Master Module Ends here...! */

    /* Hair Master Module Starts here...! */
    Route::get('/hair_list', 'Admin\HairMasterController@list_view');
    Route::get('/hair_add', 'Admin\HairMasterController@add_view');
    Route::post('/hair_insert', 'Admin\HairMasterController@insert_records');
    Route::post('/delete_hair', 'Admin\HairMasterController@delete_all_records');
    Route::get('/hair_delete/{id?}', 'Admin\HairMasterController@delete_records');
    Route::post('/hair_status', 'Admin\HairMasterController@status_change');
    Route::get('/hair_edit/{id?}', 'Admin\HairMasterController@get_edit_records');
    Route::put('/hair_update/{id?}', 'Admin\HairMasterController@update_records');
    /* Hair Master Module Ends here...! */

    /* Jaw Master Module Starts here...! */
    Route::get('/jaw_list', 'Admin\JawMasterController@list_view');
    Route::get('/jaw_add', 'Admin\JawMasterController@add_view');
    Route::post('/jaw_insert', 'Admin\JawMasterController@insert_records');
    Route::post('/delete_jaw', 'Admin\JawMasterController@delete_all_records');
    Route::get('/jaw_delete/{id?}', 'Admin\JawMasterController@delete_records');
    Route::post('/jaw_status', 'Admin\JawMasterController@status_change');
    Route::get('/jaw_edit/{id?}', 'Admin\JawMasterController@get_edit_records');
    Route::put('/jaw_update/{id?}', 'Admin\JawMasterController@update_records');
    /* Jaw Master Module Ends here...! */

    /* Lip Master Module Starts here...! */
    Route::get('/lip_list', 'Admin\LipMasterController@list_view');
    Route::get('/lip_add', 'Admin\LipMasterController@add_view');
    Route::post('/lip_insert', 'Admin\LipMasterController@insert_records');
    Route::post('/delete_lip', 'Admin\LipMasterController@delete_all_records');
    Route::get('/lip_delete/{id?}', 'Admin\LipMasterController@delete_records');
    Route::post('/lip_status', 'Admin\LipMasterController@status_change');
    Route::get('/lip_edit/{id?}', 'Admin\LipMasterController@get_edit_records');
    Route::put('/lip_update/{id?}', 'Admin\LipMasterController@update_records');
    /* Lip Master Module Ends here...! */

    /* Nose Master Module Starts here...! */
    Route::get('/nose_list', 'Admin\NoseMasterController@list_view');
    Route::get('/nose_add', 'Admin\NoseMasterController@add_view');
    Route::post('/nose_insert', 'Admin\NoseMasterController@insert_records');
    Route::post('/delete_nose', 'Admin\NoseMasterController@delete_all_records');
    Route::get('/nose_delete/{id?}', 'Admin\NoseMasterController@delete_records');
    Route::post('/nose_status', 'Admin\NoseMasterController@status_change');
    Route::get('/nose_edit/{id?}', 'Admin\NoseMasterController@get_edit_records');
    Route::put('/nose_update/{id?}', 'Admin\NoseMasterController@update_records');
    /* Lip Master Module Ends here...! */

    /* Skin Master Module Starts here...! */
    Route::get('/skin_list', 'Admin\SkinMasterController@list_view');
    Route::get('/skin_add', 'Admin\SkinMasterController@add_view');
    Route::post('/skin_insert', 'Admin\SkinMasterController@insert_records');
    Route::post('/delete_skin', 'Admin\SkinMasterController@delete_all_records');
    Route::get('/skin_delete/{id?}', 'Admin\SkinMasterController@delete_records');
    Route::post('/skin_status', 'Admin\SkinMasterController@status_change');
    Route::get('/skin_edit/{id?}', 'Admin\SkinMasterController@get_edit_records');
    Route::put('/skin_update/{id?}', 'Admin\SkinMasterController@update_records');
    /* Skin Master Module Ends here...! */
}); // Email Verified enables



// Send Email By Hit URL
Route::get('send-mail', 'Email\MailSend@mailsend');
Route::post('user_email/{id?}', 'Email\MailSend@mailsend');
