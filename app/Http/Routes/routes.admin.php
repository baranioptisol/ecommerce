<?php

/*
|--------------------------------------------------------------------------
| Application Routes For Admin Panel
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
   
    // Login

    Route::get('/', ['as' => 'homelogin','middleware' => 'exist', function () {
    	
    	return view('login.login');
    }]);

    Route::get('/login', ['as' => 'login','middleware' => 'exist', function () {
    	return view('login.login');
    }]);

    Route::post('/postlogin',['as' => 'postlogin', 'uses' => 'LoginController@postLogin']);

    Route::get('/logout', ['as' => 'logout', function () {      
    	Auth::logout();
    	return Redirect::to('/');
    }]);

    // Forgot Password

    Route::get('/forgotpassword',['as' => 'forgotpassword', function () {
    	return view('forgotpassword.forgot');
    }]);

    Route::post('/postforgotpassword', ['as' => 'postforgotpassword', 'uses' => 'PasswordController@postForgotPassword']);

    Route::get('/resetpassword/{code}/{email}', ['as' => 'resetpassword', 'uses' => 'PasswordController@resetPassword']);

    Route::post('/postresetpassword', ['as' => 'postresetpassword', 'uses' => 'PasswordController@postResetPassword']);

    // Admin Profile

    Route::get('/dashboard',['as' => 'dashboard', 'middleware'=> 'auth', function () {
    	return view('dashboard.dashboard');
    }]);

    Route::get('/profile/view', ['as' => 'viewprofile','middleware'=> 'auth','uses' => 'ProfileController@view']);

    Route::get('/profile/edit', ['as' => 'editprofile','middleware'=> 'auth', 'uses' => 'ProfileController@editProfile']);
    
    Route::post('/profile/save',['as' => 'updateprofile','middleware'=> 'auth', 'uses' => 'ProfileController@updateProfile']);
    
    Route::get('/changepassword', ['as' => 'changepassword', 'middleware'=> 'auth',  function () {
    	return view('profile.changepassword');
    }]);

    Route::post('/postchangepassword',['as' => 'postchangepassword','middleware'=> 'auth', 'uses' => 'ProfileController@changePassword']);


});

Route::get('/address', function() {

    echo "<pre>";
    return \Shippo_Address::create([
                            'object_purpose' => 'PURCHASE',
                            'name' => 'John Smith',
                            'company' =>'',
                            'street1' => 'Golden Street',
                            'street_no' => '53',
                            'street2' => '',
                            'city' => 'Nashua',
                            'state' => 'NH',
                            'zip' => '03062',
                            'country' => 'US',
                            'phone' => '23423234234',
                            'email' => 'webplb85@gmail.com',
                            'validate' => true
                        ]);
    /*return \Shippo_Address::create([
        'object_purpose' => 'PURCHASE',
        'name' => 'John Smith',
        'company' => 'Initech',
        'street1' => 'Thanjaoor Rd.',
        'street_no' => '6512',
        'street2' => '',
        'city' => 'Thanjaoor',
        'state' => 'IL',
        'zip' => '60517',
        'country' => 'US',
        'phone' => '123 353 2345',
        'email' => 'jmercouris@iit.com',
        'validate' => true
    ]);*/
    //return Shippo_Address::validate('39f5afad42bc4b5e950e3e7451438e9e');
    /*return \Shippo_Address::create([
        'object_purpose' => 'PURCHASE',
        'name' => 'John Smith',
        'company' => 'Initech',
        'street1' => 'Greene Rd.',
        'street_no' => '6512',
        'street2' => '',
        'city' => 'Woodridge',
        'state' => 'IL',
        'zip' => '60517',
        'country' => 'US',
        'phone' => '123 353 2345',
        'email' => 'jmercouris@iit.com',
        'validate' => true
    ]);*/
    /*return \Shippo_Address::create([
        'object_purpose' => 'QUOTE',
        'name' => 'John Smith',
        'company' => 'Initech',
        'street1' => 'Greene Rd.',
        'street_no' => '6512',
        'street2' => '',
        'city' => 'Woodridge',
        'state' => 'IL',
        'zip' => '60517',
        'country' => 'US',
        'phone' => '123 353 2345',
        'email' => 'jmercouris@iit.com',
        'metadata' => 'Customer ID 234;234'
    ]);*/

});
?>