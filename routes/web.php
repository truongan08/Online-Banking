<?php




Route::get('/', 'FrontendController@home')->name('homePage');

Route::get('/latest-news/{id}/{slug}', 'FrontendController@singleBlog')->name('single.blog');
Route::get('/latest-news/', 'FrontendController@blog')->name('blog');
Route::get('/contact', 'FrontendController@contact')->name('contact');

Route::get('/contact', 'FrontendController@Contact')->name('contact');
Route::post('/contact', 'FrontendController@ContactSubmit')->name('ContactSubmit');

Route::post('/subscribe', 'FrontendController@subscribePost')->name('subscribePost');

Route::get('/change-lang/{lang}', 'FrontendController@changeLang')->name('lang');


///ADMIN///

Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin', 'as' => 'admin.'], function () {
    Route::get('/', 'AdminDashboardController@loginForm')->name('login');
    Route::post('/', 'AdminDashboardController@login')->name('login.post');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', 'AdminDashboardController@dashboard')->name('dashboard');
    Route::get('profile', 'AdminDashboardController@profile')->name('profile');
    Route::post('profile', 'AdminDashboardController@profilePost')->name('profile.post');
    Route::get('change/password', 'AdminDashboardController@ChangePass')->name('change.password');
    Route::post('change/password', 'AdminDashboardController@ChangePassPost')->name('change.password.post');

    Route::post('logout', 'AdminDashboardController@logout')->name('logout');;


    // allUser//
    Route::get('allUser', 'AdminDashboardController@allUser')->name('allUser');
    route::get('bannedUsers', 'AdminDashboardController@bannedUser')->name('banned.user');
    route::get('userDetails/{id}', 'AdminDashboardController@UserDetails')->name('userDetails');
    route::post('userDetailsUpdate', 'AdminDashboardController@UserDetailsUpdate')->name('userDetails.update');
    Route::get('/user/transaction/report/{id}', 'AdminDashboardController@transactionReport')->name('transaction.report');



    /////blog////
    Route::get('latest-news', 'GeneralController@blog')->name('blog');
    Route::get('add-news', 'GeneralController@blogAdd')->name('blog.add');
    Route::post('add-news', 'GeneralController@blogStore')->name('blog.store');
    Route::get('news/edit/{id}', 'GeneralController@blogEdit')->name('blog.edit');
    Route::post('news/update/{id}', 'GeneralController@blogUpdate')->name('blog.update');
    Route::post('news/delete', 'GeneralController@blogDelete')->name('blog.delete');

    /////branch////

    Route::get('branch', 'GeneralController@branch')->name('branch');
    Route::get('add-branch', 'GeneralController@branchAdd')->name('branch.add');
    Route::post('add-branch', 'GeneralController@branchStore')->name('branch.store');
    Route::get('branch/edit/{id}', 'GeneralController@branchEdit')->name('branch.edit');
    Route::post('branch/update/{id}', 'GeneralController@branchUpdate')->name('branch.update');
    Route::post('branch/delete', 'GeneralController@branchDelete')->name('branch.delete');

    //    subscribe  ////
    Route::get('subscribe', 'GeneralController@subscribe')->name('subscribe');
    Route::post('subscribeUpdate', 'GeneralController@subscribeUpdate')->name('subscribeUpdate');
    Route::post('subscribe/delete/{id}', 'GeneralController@subscribeDelete')->name('subscribe.delete');
    Route::get('subscribe/send/mail-to-all', 'GeneralController@subscribeMailSendForm')->name('subscribe.mail.send.form');
    Route::post('subscribe/send/mail-to-all', 'GeneralController@subscribeMailSendAll')->name('subscribe.mail.sendToAll');

    Route::get('breadcrumb', 'GeneralController@BreadcrumbIndex')->name('breadcrumbIndex');
    Route::post('breadcrumb', 'GeneralController@Breadcrumb')->name('breadcrumb');

    Route::get('/charges', 'AdminController@charges')->name('tf.charges');
    Route::post('/charges', 'AdminController@chargesUpdate')->name('tf.charges.update');


    Route::get('/Other-bank/transaction/request', 'AdminController@transactionRequest')->name('transaction.request');
    Route::get('/Other-bank/transaction/approved', 'AdminController@transactionApproved')->name('transaction.approved');
    Route::post('/Other-bank/transaction/approved', 'AdminController@transactionOtBankConfirm')->name('transaction.ot.bank.confirm');
    Route::post('/Other-bank/transaction/reject', 'AdminController@transactionOtBankReject')->name('transaction.ot.bank.reject');
    Route::get('/Other-bank/transaction/rejected', 'AdminController@transactionRejected')->name('transaction.rejected');



    Route::get('/other/bank', 'GeneralController@otherBank')->name('other.banks');
    Route::post('/other/bank/create', 'GeneralController@otherBankCreate')->name('other.banks.create');
    Route::post('/other-update/{id}', 'GeneralController@otherBankUpdate')->name('other.banks.update');

    //single user
    Route::get('/user/{user}', 'AdminController@singleUser')->name('user-single');
});


//admin auth end//

///user///
Auth::routes();



Route::get('/login', 'FrontendController@login')->name('login');
Route::get('/user', 'UserController@loginPage')->name('get-login-page');

Route::group(['prefix' => 'user', 'middleware' => 'guest', 'as' => 'user.'], function () {
    Route::get('/login', 'FrontendController@userlogin')->name('login');
});


Route::group(['prefix' => 'user', 'middleware' => 'auth', 'as' => 'user.'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/change/password', 'UserController@changePass')->name('changePass');

    //check ban or active
    Route::group(['middleware' => 'active_status'], function () {

        //user
        Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
        Route::get('/profile', 'UserController@profileIndex')->name('profile');
        Route::post('/profile', 'UserController@profileUpdate')->name('profile.update');
        Route::post('/profile/password', 'UserController@passwordChange')->name('password.change');
        Route::post('/profile/image/upload', 'UserController@profileImage')->name('profile.image.upload');
        Route::get('/account/statement', 'UserController@accStatement')->name('account.statement');

    //tranfer//
        //tranfer own bank//

        Route::get('/transfer/balance', 'UserController@transferToOwnBank')->name('transfer.to.ownbank');
        Route::post('/transfer/balance', 'UserController@transferOwnBank')->name('transfer.ownbank');
        Route::get('/transfer/preview', 'UserController@transferPreview')->name('transfer.preview');
        Route::post('/own/bank/transfer/confirm', 'UserController@transferOwnBankConfirm')->name('transfer.ownbank.confirm');


        //tranfer other bank

        Route::get('/transfer/balance/other-bank', 'UserController@transferToOtherBank')->name('transfer.to.otherBank');
        Route::post('/transfer/balance/other-bank', 'UserController@transferOtherBank')->name('transfer.otherBank');
        Route::get('/other/bank/transfer/preview', 'UserController@transferOtBankPreview')->name('ot.transfer.preview');
        Route::post('/other/bank/transfer/confirm', 'UserController@transferOtherBankConfirm')->name('ot.transfer.confirm');


        //tranfer other bank script

        Route::get('/transfer/balance/bank-data/', 'UserController@bankData')->name('bank.data');

        //branch
        Route::get('/our-branch', 'UserController@branch')->name('branch');
    });
});
