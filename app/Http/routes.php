<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();
Route::get('/', function () {
    return view('welcome');
});
Route::get('/tinychat',function(){
    return view('tinychat');
});
//Tools
Route::post('/tools/onlines','chatController@onlines');
Route::post('/tools/djob','chatController@djob');
Route::post('/tools/ban','chatController@ban');
Route::get('/tools/chkol','chatController@chkol');

Route::get('/profile', 'HomeController@index');
Route::get('/profile/{id}', 'HomeController@index');

//facebook
Route::get('auth/facebook', 'Auth\AuthController@fbRedirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@fbHandleProviderCallback');

//twitter
Route::get('auth/twitter', 'Auth\AuthControllerTwitter@twRedirectToProvider');
Route::get('auth/twitter/callback', 'Auth\AuthControllerTwitter@twHandleProviderCallback');

//chatbox
Route::get('sendchat',function(){
	return "this is not accessible";
});
Route::post('sendchat/now','chatController@sendmsg');
Route::post('getchats','chatController@getMsg');
Route::post('getmorechats','chatController@getMoreMsg');
Route::post('report','chatController@report');
Route::post('announcement','chatController@announcement');
//Personal Messages
Route::get('/messages/','messagesController@fetchConv');
Route::get('/messages/{social_id}','messagesController@fetchConv');
//User shits Here
Route::post('/update/status','userController@sendstatus');
Route::post('/user/like','userController@likethis');
Route::post('/user/unlike','userController@unlikethis');
Route::post('/user/delstatus','userController@delstatus');
Route::post('/user/updatebio','userController@userBio');
//Dashboard
Route::get('/admin','adminController@admin');
Route::get('/admin/dj','adminController@dj');
//Dashboard DJs
Route::post('/admin/dj/add','adminController@addDj');
Route::post('/admin/dj/edit','adminController@editDj');
Route::post('/admin/dj/delete','adminController@deleteDj');
Route::post('/admin/djob/update','adminController@djob');
//Dashboard Users
Route::get('/admin/users','adminController@users');
Route::post('/admin/users/edit','adminController@userEdit');
Route::post('/admin/users/edit','adminController@userEdit');
//Dashboard Banners
Route::get('/admin/banners','adminController@banner');
Route::post('/admin/banners/uploadbanner','adminController@uploadBanner');