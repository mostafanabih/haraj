<?php

Route::group(['middleware' => 'visitors'], function(){
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
    Route::get('/logout', function(){
        return abort(404);
    });


    Route::get('mail', function(){


        //$sms = \mody\smsprovider\Facades\SMSProvider::sendSMS('test','0565231525');
        // dd($sms);
        /*
        $data = array(
                    'active_code' => 1252452,
                    'name' => 'محمود',
                    'img' => App\Sel3hInfo::findOrFail(1)->logo
                );

                \Mail::send('mail.mail', $data, function ($message) {
                    // $message->to('m_r9801@yahoo.com', 'محمود')
                    $message->to('mahmoudarafat33@gmail.com', 'محمود')
                        ->subject('Sel3h Email Confirm');
                });
        */
    });


    /* index, main_sections, adv, advertiser pages */
    Route::resource('/', 'AdvsController');
    Route::get('/menu/{name}', 'AdvsController@show');
    Route::get('/adv/{adv_id}', 'AdvsController@adv_details');
    Route::get('/advertiser/{advertiser_id}', 'AdvsController@advertiser_details');
    Route::post('bottom_filter1_123_', 'AdvsController@bottom_filter1_123_');

    /* msg to advertiser */
    Route::post('contact_me', 'AdvsController@contact_me')->name('contact_me');
    /* msg to sel3h */
    Route::get('/ContactUs', 'AdvsController@ContactUsShow');
    Route::post('ContactUsSend', 'AdvsController@ContactUsSend')->name('ContactUsSend');

    /* ajax filter search */
    Route::post('car_filter', 'AdvsController@get_car_types');
    Route::post('bottom_filter1', 'AdvsController@bottom_filter1');
    Route::post('bottom_filter2', 'AdvsController@bottom_filter2');
    Route::post('bottom_filter3', 'AdvsController@bottom_filter3');
    Route::post('car_filter2', 'AdvsController@get_car_types2');

    /* login, register , confirm & forget_password */
    Route::post('do-login', 'HomeController@doLogin')->name('do-login');
    Route::post('do-register', 'HomeController@doRegister')->name('do-register');
    Route::get('/mail_confirm', 'HomeController@show_confirm');
    Route::post('confirm', 'HomeController@confirm')->name('confirm');
    Route::get('/forget_password', 'HomeController@forget_password_view');
    Route::post('/get_forget_password', 'HomeController@forget_password');
    Route::get('/reset_password', 'HomeController@reset_password_view');
    Route::put('/get_reset_password', 'HomeController@reset_password');
    
    Route::get('/resend_active_code/{id}', 'HomeController@resend_active_code');
    Route::post('/resend_code', 'HomeController@resend_code');
    
    Route::get('/activate', 'HomeController@active_view');

    /* find black list */
    Route::get('/find_black_list', 'BlackListController@find_black_list');
    /* fixed page show */
    Route::get('/page/{id}', 'FixedPagesController@show_page');
    /* site map for section show */
    Route::get('/sections-map', 'AdvsController@get_sections_map');

    /* sitemap*/
    Route::get('/sitemap-index.xml', 'SitemapController@index');
    Route::get('/sitemap-pages.xml', 'SitemapController@pages')->name('pages.xml');
    Route::get('/sitemap-categories.xml', 'SitemapController@categories')->name('categories.xml');
    Route::get('/sitemap-posts{page}.xml', 'SitemapController@posts')->name('posts.xml');
    Route::get('/sitemap-advertisers.xml', 'SitemapController@advertisers')->name('advertisers.xml');
// =========================when user auth=======================
    Auth::routes();

    Route::group(['middleware' =>['web', 'auth']], function(){

        /* rating, follow operations */
        Route::post('rating', 'AdvsController@rating')->name('rating');
        Route::post('follow_me', 'AdvsController@follow_me')->name('follow_me');
        Route::post('advertiser_rating', 'AdvsController@advertiser_rating')->name('advertiser_rating');

        /* my account */
        Route::resource('/home', 'HomeController');
        Route::get('/messages', 'HomeController@messages');
        Route::delete('messages', 'HomeController@messagesDelete')->name('messages');
        /* reply for message */
        Route::get('/reply/{id}', 'HomeController@get_reply');
        Route::post('/send_reply', 'HomeController@send_reply')->name('send_reply');

        /* black_list, dashboard pages */
        Route::resource('/black_list', 'BlackListController');
        Route::resource('/account_settings', 'AccountSettingsController');

        /* adv, advertiser favourite */
        Route::resource('/favourite', 'FavouriteController');
        Route::post('favourite_advertiser', 'FavouriteController@add_favourite_advertiser')->name('favourite_advertiser');
        Route::get('show_favourite_advertiser', 'FavouriteController@show_favourite_advertiser')->name('show_favourite_advertiser');
        Route::delete('delete_favourite_advertiser', 'FavouriteController@delete_favourite_advertiser')->name('delete_favourite_advertiser');

        /* add, update, delete ADV */
        Route::resource('/add_adv', 'AddAdvController');
        Route::post('bottom_filter1_', 'AddAdvController@bottom_filter1_');
        Route::post('bottom_filter2_', 'AddAdvController@bottom_filter2_');
        Route::post('bottom_filter3_', 'AddAdvController@bottom_filter3_');
        Route::post('del_img', 'AddAdvController@del_img');
        Route::post('bottom_filter1_123', 'AddAdvController@bottom_filter1_123');
        Route::put('/adv_update_/{id}', 'AddAdvController@adv_update');

        /* subscription request */
        Route::resource('/add_subscription', 'subscriptionController');
        Route::post('add_subscription', 'subscriptionController@add_subscription')->name('add_subscription');

        /* followers */
        Route::resource('/followers', 'FollowersController');

        /* advertiser notification */
        Route::resource('/AdvertiserNotifyController', 'AdvertiserNotifyController');

        Route::put('change_pass', 'HomeController@change_pass')->name('change_pass');

        /* Add Reporting */
        Route::post('add_reporting', 'ReportingController@add_reporting')->name('add_reporting');


        Route::group(['middleware' => 'admin'], function(){
            // done by ramadan
            //dashboard routes  by ramadan
            Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'AdminController@getDashboard']);
            Route::get('/register-request', ['as' => 'register-request', 'uses' => 'AdminController@getRegisterRequest']);

            //main sections
            Route::get('/main-sections', ['as' => 'main-sections', 'uses' => 'AdminController@getMainSections']);
            Route::get('/add-main-section', ['as' => 'add-main-section', 'uses' => 'AdminController@getAddMainSection']);
            Route::get('/edit-main-section/{id}', ['as' => 'edit-main-section', 'uses' => 'AdminController@EditMainSection']);
            Route::post('/main-section-store', ['as' => 'main.section.store', 'uses' => 'AdminController@MainSectionStore']);
            Route::post('/main-section-update', ['as' => 'main.section.update', 'uses' => 'AdminController@MainSectionUpdate']);
            Route::delete('/main-section-delete/{id}', ['as' => 'main.section.delete', 'uses' => 'AdminController@MainSectionDelete']);

            //sub sections
            Route::get('/sub-sections/{id}', ['as' => 'sub-sections', 'uses' => 'AdminController@SubSection']);
            Route::get('/add-sub-section', ['as' => 'add-sub-section', 'uses' => 'AdminController@getAddSubSection']);
            Route::get('/edit-sub-section/{id}', ['as' => 'edit-sub-section', 'uses' => 'AdminController@EditSubSection']);
            Route::post('/sub-section-store', ['as' => 'sub.section.store', 'uses' => 'AdminController@SubSectionStore']);
            Route::post('/sub-section-update', ['as' => 'sub.section.update', 'uses' => 'AdminController@SubSectionUpdate']);
            Route::delete('/sub-section-delete/{id}', ['as' => 'sub.section.delete', 'uses' => 'AdminController@SubSectionDelete']);

            //internal sections
            Route::get('/internal-sections/{id}', ['as' => 'internal-sections', 'uses' => 'AdminController@InternalSection']);
            Route::get('/edit-internal-sections/{id}', ['as' => 'edit-internal-sections', 'uses' => 'AdminController@EditInternalSection']);
            Route::get('/add-internal-section', ['as' => 'add-internal-section', 'uses' => 'AdminController@getAddInternalSection']);
            Route::post('/internal-section-store', ['as' => 'internal.section.store', 'uses' => 'AdminController@InternalSectionStore']);
            Route::post('/internal-section-update', ['as' => 'internal.section.update', 'uses' => 'AdminController@InternalSectionUpdate']);
            Route::delete('/internal-section-delete/{id}', ['as' => 'internal.section.delete', 'uses' => 'AdminController@InternalSectionDelete']);




            // done by mostafa
            //dashboard routes  by mostafa
            Route::resource('/area', 'AreaController');
            Route::resource('/cities', 'CityController');
            Route::resource('/packages', 'PackagesController');
            Route::resource('/advertisers', 'AdvertisersController');
            Route::resource('/notification', 'NotificationController');
            Route::post('adv_search', 'NotificationController@adv_search');
            Route::resource('/site_settings', 'SiteSettingsController');
            Route::resource('/fixed_pages', 'FixedPagesController');
            Route::resource('/contact_us', 'ContactUsController');
            Route::resource('/adv_action', 'AdminAdvController');
            Route::post('bottom_filter1_a', 'AddAdvController@bottom_filter1_');
            Route::post('bottom_filter2_a', 'AddAdvController@bottom_filter2_');
            Route::post('del_img_a', 'AddAdvController@del_img');
            Route::resource('/side_advs', 'SideAdvsController');
            Route::resource('/permissions', 'PermissionsController');
            Route::post('RegisterByAdmin', 'HomeController@RegisterByAdmin')->name('RegisterByAdmin');

            Route::get('normal_user_convert/{id}', 'AdvertisersController@normal_user_convert');
            Route::get('super_user_convert/{id}', 'AdvertisersController@super_user_convert');

            Route::resource('/reporting_reasons', 'ReportingController');
            Route::get('/reports', 'ReportingController@get_reports');
            Route::delete('/del_report/{id}', 'ReportingController@del_report');

            Route::put('/adv_confirm/{id}', 'AdminAdvController@adv_confirm');


        });
    });

});

Route::get('/commission',function (){
	return view('commission');
})->name('commission');