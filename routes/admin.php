<?php //Admin向けのURL

Route::redirect('/', '/admin/payment');

Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');

    Route::get('user', 'Admin\UserManagementController@lists')->name('user');
    Route::get('user/list', 'Admin\UserManagementController@getUserDataTables');
    Route::get('user/create', 'Admin\UserManagementController@userCreate');
    Route::get('user/{user}/edit', 'Admin\UserManagementController@userDetail');
    Route::get('user/reset/{user}', 'Admin\UserManagementController@userReset');
    Route::get('user/{user}/delete', 'Admin\UserManagementController@userDelete');
    Route::get('user/download', 'Admin\UserManagementController@userDownload');
    Route::post('user/register', 'Admin\UserManagementController@userRegister');
    Route::post('user/{user}/update', 'Admin\UserManagementController@userUpdate');
    Route::get('user/{user}/identification', 'Admin\UserManagementController@showIdentification');
    Route::post('user/{user}/identification', 'Admin\UserManagementController@judgIdentification');
    Route::get('user/{user_id}/identification/{slag}.{ext}', 'Admin\UserManagementController@getImage');

    Route::get('fish', 'Admin\FishManagementController@lists');
    Route::get('fish/list', 'Admin\FishManagementController@getFishData');
    Route::get('fish/{fish}/edit', 'Admin\FishManagementController@fishDetail');
    Route::get('fish/{fish}/delete', 'Admin\FishManagementController@fishDelete');
    Route::post('fish/{fish}/update', 'Admin\FishManagementController@fishUpdate');
    Route::get('fish/{fish}/restart', 'Admin\FishManagementController@fishRestart');
    Route::get('fish/message/{user}', 'Admin\FishManagementController@userMessage');

    Route::get('payment', 'Admin\PaymentManagementController@lists');
    Route::get('payment/list', 'Admin\PaymentManagementController@getPaymentData');

    Route::get('blog', 'Admin\BlogManagementController@lists');
    // Route::get('blog/getData', 'Admin\BlogManagementController@getData');
    Route::get('blog/list', 'Admin\BlogManagementController@getBlogDataTables');
    Route::get('blog/{blog}/delete', 'Admin\BlogManagementController@blogDelete');
});
