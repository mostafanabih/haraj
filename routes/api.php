<?php

use Illuminate\Http\Request;

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



Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'api\AuthController@login');
    Route::post('my-advs', ['uses' => 'api\APIController@MyADV']);
    Route::get('/advs', ['uses' => 'api\APIController@getADVS']);
    Route::post('my-info', ['uses' => 'api\APIController@MyInfo']);
    Route::post('advertiser-info', ['uses' => 'api\APIController@AdvertiserInfo']);
    Route::post('advertiser-ADVs', ['uses' => 'api\APIController@AdvertiserAdvs']);
    Route::get('cities', ['uses' => 'api\APIController@getCities']);
    Route::get('main-sections', ['uses' => 'api\APIController@MainSections']);
    Route::get('/sub-sections/{id}', ['uses' => 'api\APIController@SubSections']);
    Route::get('/internal-sections/{id}', ['uses' => 'api\APIController@InternalSections']);
    Route::post('edit_info', ['uses' => 'api\APIController@EditInfo']);
    Route::post('edit_save', ['uses' => 'api\APIController@EditSave']);
    Route::post('add-new-advertisement', ['uses' => 'api\APIController@AddNewAdvertisement']);
    Route::post('advertise-details', ['uses' => 'api\APIController@AdvertiseDetails']);
    Route::post('/sign-up', ['uses' => 'api\APIController@SignUp']);
    Route::post('black-list-search', ['uses' => 'api\APIController@BlackListSearch']);
    Route::post('get-favorites', ['uses' => 'api\APIController@getFavorites']);
    Route::post('add-to-favorites', ['uses' => 'api\APIController@AddToFavorites']);
    Route::post('remove-from-favorites', ['uses' => 'api\APIController@RemoveFromFavorites']);
    Route::post('search', ['uses' => 'api\APIController@Search']);
    Route::post('follow', ['uses' => 'api\APIController@Follow']);
    Route::post('unfollow', ['uses' => 'api\APIController@UnFollow']);
    Route::post('remove-advertisement', ['uses' => 'api\APIController@RemoveAdvertisement']);
    Route::post('edit-advertisement', ['uses' => 'api\APIController@EditAdvertisement']);
    Route::post('edit-advertisement-save', ['uses' => 'api\APIController@EditAdvertisementSave']);
    Route::post('contact-us', ['uses' => 'api\APIController@ContactUs']);
    Route::post('advertise-rate', ['uses' => 'api\APIController@AdvertiseRate']);
    Route::post('advertiser-rate', ['uses' => 'api\APIController@AdvertiserRate']);
    Route::post('sign-up-confirm', ['uses' => 'api\APIController@SignUpConfirm']);
    Route::post('reset-password', ['uses' => 'api\APIController@ResetPassword']);
    Route::post('new-password-save', ['uses' => 'api\APIController@NewPasswordSave']);

});





Route::group(['prefix' => 'v2'], function () {
    Route::post('login', 'api\AuthController@login');
    Route::post('my-advs', ['uses' => 'api\V2APIController@MyADV']);
    Route::get('/advs', ['uses' => 'api\V2APIController@getADVS']);
    Route::post('my-info', ['uses' => 'api\V2APIController@MyInfo']);
    Route::post('advertiser-info', ['uses' => 'api\V2APIController@AdvertiserInfo']);
    Route::get('/advertiser-ADVs/{id}', ['uses' => 'api\V2APIController@AdvertiserAdvs']);
    Route::get('cities', ['uses' => 'api\V2APIController@getCities']);
    Route::get('main-sections', ['uses' => 'api\V2APIController@MainSections']);
    Route::get('/sub-sections/{id}', ['uses' => 'api\V2APIController@SubSections']);
    Route::get('/internal-sections/{id}', ['uses' => 'api\V2APIController@InternalSections']);
    Route::post('edit_info', ['uses' => 'api\V2APIController@EditInfo']);
    Route::post('edit_save', ['uses' => 'api\V2APIController@EditSave']);
    Route::post('add-new-advertisement', ['uses' => 'api\V2APIController@AddNewAdvertisement']);
    Route::post('advertise-details', ['uses' => 'api\V2APIController@AdvertiseDetails']);
    Route::post('/sign-up', ['uses' => 'api\V2APIController@SignUp']);
    Route::post('black-list-search', ['uses' => 'api\V2APIController@BlackListSearch']);
    Route::post('get-favorites', ['uses' => 'api\V2APIController@getFavorites']);
    Route::post('add-to-favorites', ['uses' => 'api\V2APIController@AddToFavorites']);
    Route::post('remove-from-favorites', ['uses' => 'api\V2APIController@RemoveFromFavorites']);
    Route::post('search', ['uses' => 'api\V2APIController@Search']);
    Route::post('follow', ['uses' => 'api\V2APIController@Follow']);
    Route::post('unfollow', ['uses' => 'api\V2APIController@UnFollow']);
    Route::post('remove-advertisement', ['uses' => 'api\V2APIController@RemoveAdvertisement']);
    Route::post('edit-advertisement', ['uses' => 'api\V2APIController@EditAdvertisement']);
    Route::post('edit-advertisement-save', ['uses' => 'api\V2APIController@EditAdvertisementSave']);
    Route::post('contact-us', ['uses' => 'api\V2APIController@ContactUs']);
    Route::post('advertise-rate', ['uses' => 'api\V2APIController@AdvertiseRate']);
    Route::post('advertiser-rate', ['uses' => 'api\V2APIController@AdvertiserRate']);
    Route::post('sign-up-confirm', ['uses' => 'api\V2APIController@SignUpConfirm']);
    Route::post('reset-password', ['uses' => 'api\V2APIController@ResetPassword']);
    Route::post('new-password-save', ['uses' => 'api\V2APIController@NewPasswordSave']);

});

Route::group(['prefix' => 'v3'], function () {
    Route::post('login', 'api\AuthController@login');
    Route::post('my-advs', ['uses' => 'api\V3APIController@MyADV']);
    Route::get('/advs', ['uses' => 'api\V3APIController@getADVS']);
    Route::post('my-info', ['uses' => 'api\V3APIController@MyInfo']);
    Route::post('advertiser-info', ['uses' => 'api\V3APIController@AdvertiserInfo']);
    Route::get('/advertiser-ADVs', ['uses' => 'api\V3APIController@AdvertiserAdvs']);
    Route::post('cities', ['uses' => 'api\V3APIController@getCities']);
    Route::get('main-sections', ['uses' => 'api\V3APIController@MainSections']);
    Route::get('/sub-sections/{id}', ['uses' => 'api\V3APIController@SubSections']);
    Route::get('/internal-sections/{id}', ['uses' => 'api\V3APIController@InternalSections']);
    Route::post('edit_info', ['uses' => 'api\V3APIController@EditInfo']);
    Route::post('edit_save', ['uses' => 'api\V3APIController@EditSave']);
    Route::post('add-new-advertisement', ['uses' => 'api\V3APIController@AddNewAdvertisement']);
    Route::post('advertise-details', ['uses' => 'api\V3APIController@AdvertiseDetails']);
    Route::post('/sign-up', ['uses' => 'api\V3APIController@SignUp']);
    Route::post('black-list-search', ['uses' => 'api\V3APIController@BlackListSearch']);
    Route::post('get-favorites', ['uses' => 'api\V3APIController@getFavorites']);
    Route::post('add-to-favorites', ['uses' => 'api\V3APIController@AddToFavorites']);
    Route::post('remove-from-favorites', ['uses' => 'api\V3APIController@RemoveFromFavorites']);
    Route::post('search', ['uses' => 'api\V3APIController@Search']);
    Route::post('follow', ['uses' => 'api\V3APIController@Follow']);
    Route::post('unfollow', ['uses' => 'api\V3APIController@UnFollow']);
    Route::post('remove-advertisement', ['uses' => 'api\V3APIController@RemoveAdvertisement']);
    Route::post('edit-advertisement', ['uses' => 'api\V3APIController@EditAdvertisement']);
    Route::post('edit-advertisement-save', ['uses' => 'api\V3APIController@EditAdvertisementSave']);
    Route::post('contact-us', ['uses' => 'api\V3APIController@ContactUs']);
    Route::post('advertise-rate', ['uses' => 'api\V3APIController@AdvertiseRate']);
    Route::post('advertiser-rate', ['uses' => 'api\V3APIController@AdvertiserRate']);
    Route::post('sign-up-confirm', ['uses' => 'api\V3APIController@SignUpConfirm']);
    Route::post('reset-password', ['uses' => 'api\V3APIController@ResetPassword']);
    Route::post('new-password-save', ['uses' => 'api\V3APIController@NewPasswordSave']);
    Route::post('message-advertiser', ['uses' => 'api\V3APIController@MessageAdvertiser']);
    Route::post('my-message', ['uses' => 'api\V3APIController@MyMessages']);
    Route::post('message-replies', ['uses' => 'api\V3APIController@MessageReplies']);
    Route::get('areas', ['uses' => 'api\V3APIController@Areas']);
    Route::get('pages', ['uses' => 'api\V3APIController@Pages']);
    Route::get('/page-details/{id}', ['uses' => 'api\V3APIController@PageDetails']);
    
    Route::get('/site-info', ['uses' => 'api\V3APIController@SiteInfo']);
    Route::post('followers', ['uses' => 'api\V3APIController@Followers']);
    
    Route::post('my-notifications', ['uses' => 'api\V3APIController@MyNotifications']);
    
    Route::post('notification-read', ['uses' => 'api\V3APIController@NotificationRead']);
    
    
    
    Route::post('reply-message', ['uses' => 'api\V3APIController@ReplyMessage']);

  
    Route::get('commission', ['uses' => 'api\V3APIController@commission']);
    Route::post('logout', ['uses' => 'api\AuthController@Logout']);


});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
