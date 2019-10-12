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
Route::get('/', 'TopController@index');
Route::get('buyer', function () {
    return view('teaser/buyer');
});
Route::get('seller', function () {
    return view('teaser/seller');
});
Route::get('contact', 'ContactController@index');
Route::get('contact/complete', 'ContactController@complete');

Route::get('term', 'TermController@index')->name('term');
Route::get('privacy', 'TermController@privacy')->name('privacy');
Route::get('law', 'TermController@law')->name('law');
Route::get('company', 'TermController@company')->name('company');
Route::get('question', function () {
    return view('question');
});
Route::get('howto', function () {
    return view('howto');
});
Route::get('about', function () {
    return view('about');
});

Route::post('contact', 'ContactController@submit');

Route::get('fish/', 'FishController@list');
Route::post('fish/category', 'FishController@category');
Route::get('fish/request', array('as' => 'all', 'uses' => 'FishRequestController@list'));
Route::get('fish/{fish}', 'FishController@detail')->name('fish.detail');

Route::get('/shop', 'ShopController@list');

Route::group(['prefix' => 'user'], function () {
    Route::get('{user}/grade', 'GradeController@lists');
    Route::get('{user}/grade/{rate}', 'GradeController@lists');
    //ブログ一覧
    Route::get('{user}', 'BlogController@indexView');
});

//ブログ詳細
Route::get('blog/{blog}', 'BlogController@detailView');

Route::group(['middleware' => 'guest:user'], function () {
    //Authのルーティング
    // MEMO: ティザー先行公開時、registerのみ許可する
    // Route::post('/register', 'Auth\RegisterController@register');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('register/thanks', function () {
        return view('auth.thanks');
    });

    // Facebook ログイン
    Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
    Route::get('login/{provider}/callback ', 'Auth\SocialAccountController@handleProviderCallback');

    // 未ログインユーザ
    Route::get('/register/profile/{token}', function ($token) {
        return redirect('/register/profile/'. $token .'/step/1');
    });
    Route::get('/register/profile/{token}/step/1', 'Auth\RegisterController@createProfileStep1');
    Route::match(array('GET', 'POST'), '/register/profile/{token}/step/2', 'Auth\RegisterController@createProfileStep2');
    Route::get('/register/profile/{token}/step/{step}', function ($token) {
        return redirect('/register/profile/'.$token. '/step/1')
                ->with(['error' => 'セッション切れか、不正な画面遷移です。再度入力して手続きを進めて下さい。']);
    });
    Route::post('/register/profile/{token}/confirm', 'Auth\RegisterController@registProfileConfirm');
    Route::post('/register/profile/{token}/complete', 'Auth\RegisterController@registProfileComplete');
});

Route::group(['middleware' => 'auth:user'], function () {
    // ログイン済みユーザ
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // 本人確認
    Route::get('/identification', 'Auth\IdentificationController@index');
    Route::post('/identification', 'Auth\IdentificationController@send2Admin');

    // 営業許可証確認
    Route::get('/business-license', 'Auth\BusinessLicenseController@index');
    Route::post('/business-license', 'Auth\BusinessLicenseController@send2Admin');

    Route::group(['prefix' => 'mypage'], function () {
        //新しいメールアドレスの変更
        Route::get('verify/email/{token}', 'Auth\ProfileController@verifyNewEmail');

        // リクエスト魚
        Route::get('fish/request/add', 'FishRequestController@showCreateForm');
        Route::post('fish/request/confirm', 'FishRequestController@showConfirm');
        Route::post('fish/request/add', 'FishRequestController@store');
        Route::get('fish/request/complete', 'FishRequestController@showComplete');
        Route::get('fish/request/{fish}/edit', 'FishRequestController@edit');
        Route::post('fish/request/{fish}/edit', 'FishRequestController@update');
        Route::get('fish/request/{fish_req}/offer', 'OfferController@list');
        Route::post('fish/category', 'FishRequestController@category');
        Route::get('fish/request', 'FishRequestController@list');

        // 売魚
        Route::get('fish/add', 'FishController@showCreateForm');
        Route::post('fish/confirm', 'FishController@showConfirm');
        Route::post('fish/complete', 'FishController@store');
        Route::get('fish/{fish}', 'FishController@mypageDetail');
        Route::post('fish/{fish}/received', 'FishController@recieve');
        Route::get('fish/{fish}/edit', 'FishController@edit');
        Route::post('fish/{fish}/edit', 'FishController@update');
        Route::post('fish/{fish}/delete', 'FishController@delete');
        Route::get('fish/{fish}/wisher', 'Fish\WishController@list');
        Route::post('fish/{fish}/wisher/choose', 'Fish\WishController@choose');
        Route::get('fish', 'FishController@mypageList');
        Route::post('fish/image/upload', 'FishController@uploadImage');
        Route::post('fish/{fish}/rate', 'FishController@rateUser');
        Route::post('fish/{fish}/reject', 'FishController@reject');

        //ブログ
        Route::get('blog', 'BlogController@manageView');
        Route::get('blog/add', 'BlogController@addView');
        Route::post('blog/create', 'BlogController@create');
        Route::get('blog/{blog}/edit', 'BlogController@editView');
        Route::post('blog/{blog}/update', 'BlogController@update');
        Route::post('blog/{blog}/delete', 'BlogController@delete');
        Route::post('blog/image/upload', 'BlogController@uploadImage');


        // Edit Profile
        Route::get('profile/edit', 'Auth\ProfileController@updateProfileForm');
        Route::post('profile/confirm', 'Auth\ProfileController@updateProfileConfirm');
        Route::post('profile/update', 'Auth\ProfileController@updateProfile');
        Route::get('profile/complete', 'Auth\ProfileController@updateProfileComplete');
        Route::post('profile/shop_image/upload', 'Auth\ProfileController@uploadShopImage');

        // Message
        Route::get('message/more', 'MessageController@moreMessage');
        Route::get('message/fetch', 'MessageController@fetchMessage');
        Route::post('message/send', 'MessageController@sendMessage');
        Route::post('message/seen', 'MessageController@makeSeen');
        Route::get('message/mark', 'MessageController@makeMark');

        // Receipt
        Route::get('receipt', 'ReceiptController@lists');
        Route::get('receipt/pdf/{date}', 'ReceiptController@getPDF')->name('receipt.pdf');

        // 売上管理
        Route::resource('sales', 'SaleController', ['except' => ['show']]);
        Route::get('sales/history', 'SaleController@history');
        Route::get('sales/application', 'SaleController@application');
        Route::get('sales/application/bank', 'SaleController@bank');
        Route::get('sales/application/confirm', 'SaleController@confirm');
        Route::get('sales/application/complete', 'SaleController@complete');
        Route::get('sales/application/history', 'SaleController@applicationHistory');
    });

    Route::group(['prefix' => 'fish'], function () {
        Route::get('{fish}/buy', 'Fish\BuyController@buyConfirm');
        Route::post('{fish}/buy', 'Fish\BuyController@buy');
        Route::get('{fish}/buy/complete', 'Fish\BuyController@showComplete');
        Route::post('{fish}/wish', 'Fish\WishController@addWisher');
        Route::post('{fish}/wish/cancel', 'Fish\WishController@removeWisher');
    });

    Route::get('/request/{fish_req}/offer', 'OfferController@offer');
    Route::post('/request/{fish_req}/offer/complete', 'OfferController@complete');
    Route::get('/request/offer/complete', 'OfferController@showComplete');

    //書き込み
    Route::post('fish/{fish}/saveComment', 'FishController@saveComment');
});
