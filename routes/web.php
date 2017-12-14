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

// Route::auth();
use Illuminate\Support\Facades\Input;

Route::get('/push','UploadController@push');

Route::get('/testMail','InboxController@sendMail');


Route::get('/login', 'UserController@login');
Route::post('/login', 'UserController@doLogin');
Route::get('/logout', 'UserController@logout');

Route::get('/verify/{token}','UserController@verify');

Route::get('/register', 'UserController@register');
Route::get('/signup', 'UserController@signup');
Route::post('/register', 'UserController@sendtoken');
Route::post('/doregister', 'UserController@doRegister');

Route::group(array('middleware' => 'auth'), function(){
    Route::post('sendmessage', 'ChatController@sendMessage');


    Route::get('/', 'InboxController@index');


    Route::get('/msg', 'UserController@checkMessage');
    Route::get('/messages', 'ChatController@showMessages');



    Route::get('/delete/{id}', 'InboxController@delete');

    ///////////////
    Route::get('/trashDelete/{id}', 'InboxController@trashDelete');
    ///////////////


    Route::get('/filter/{id}', 'InboxController@filter');
    Route::get('/trash', 'InboxController@trash');
    // Route::get('/', 'HomeController@index');
    Route::get('/upload/delete/{id}', 'UploadController@delete');    
    Route::get('/upload', 'UploadController@index');
    Route::post('/replace', 'UploadController@replace');    
    Route::get('/uploader', 'UploadController@uploader');
    Route::post('/upload', 'UploadController@fileUpload');
    Route::get('/inbox', 'BillsController@index');
    Route::get('/favourite', 'InboxController@favourite');
    Route::get('/favorite/{id}', 'InboxController@onFavorite' );
    Route::get('/unfavorite/{id}', 'InboxController@unFavorite');

    
    Route::get('/group/{id}', 'InboxController@friends');
    
    //Angel
    Route::get('/check/{id}', 'InboxController@check');
    Route::get('/search/{searchStr}','InboxController@search');
    Route::post('/add_group','InboxController@add_group');
    Route::post('/edit_group','InboxController@edit_group');

    Route::post('/records/pay', 'RecordsController@pay');
    Route::get('/disputes/{dispute_id}', 'DisputesController@responsd');
    Route::post('/filldispute', 'DisputesController@fileDispute');
    Route::post('/sendtoken', 'DisputesController@sendToken');
    Route::post('/getrecorddetail', 'RecordsController@getRecordDetail');
    Route::get('/payments', 'PaymentsController@index');
    Route::get('/phoneline', 'PhonelineController@index');
    Route::get('/account', 'UserController@account');
    Route::post('/updateprofile', 'UserController@updateprofile');

    //Angel
    //Image upload Ajax
    Route::post('/upload_img','UploadController@upload_img');
    Route::post('/get_message','InboxController@get_message');
    Route::post('/getMusicInfo','UploadController@getMusicInfo');

    //Setting
    Route::get('/setting','SettingController@index');
    Route::post('/check_old_password','SettingController@checkOldPassword');
    Route::post('/update_password','SettingController@updatePassword');
    Route::post('/add_second_email','SettingController@addSecondEmail');

});



//Backend
Route::match(['get', 'post'],'api/login','APIController@postLogin');
Route::match(['get', 'post'],'api/register','APIController@postRegister');
Route::match(['get', 'post'],'api/get-uploads','APIController@postGetUploads');
Route::match(['get', 'post'],'api/get-inbox','APIController@postGetInbox');
Route::match(['get', 'post'],'api/get-favourite','APIController@postGetFavourite');
Route::match(['get', 'post'],'api/get-menu','APIController@postGetMenu');
Route::match(['get', 'post'],'api/remove_music','APIController@postRemoveMusic');
Route::match(['get', 'post'],'api/get-group_music','APIController@postGetGroupMusic');
Route::match(['get', 'post'],'api/set-favorite','APIController@postSetFavorite');


AdvancedRoute::controller('/api', 'UserController');

