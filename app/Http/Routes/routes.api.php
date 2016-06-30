<?php
	
 /*
|--------------------------------------------------------------------------
| Application Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$api->group(['middleware' => ['api']], function ($api) {

	$api->post('{loginCheck}', ['as' =>'loginCheck', 'uses' => 'UsersApiController@loginCheck'])
	    ->where('loginCheck', '(?i)loginCheck(?-i)');	

    $api->post('{forgotPasswordCheck}', ['as' => 'forgotPasswordCheck', 'uses' => 'UsersApiController@forgotPasswordCheck'])->where('forgotPasswordCheck', '(?i)forgotPasswordCheck(?-i)');
    
    $api->post('{resetPasswordCheck}', ['as' =>'resetPasswordCheck', 'uses'=>'UsersApiController@resetPasswordCheck'])
        ->where('resetPasswordCheck', '(?i)resetPasswordCheck(?-i)');

    $api->group(['prefix' => 'user'], function($api) {
        
        $api->post('{getProfile}',['as' => 'user.api.getProfile', 'uses' => 'UsersApiController@getProfile'])->where('getProfile', '(?i)getProfile(?-i)');
       
        $api->post('{saveProfile}', ['as' => 'user.api.saveProfile', 'uses' => 'UsersApiController@saveProfile'])->where('saveProfile', '(?i)saveProfile(?-i)');
    });

    $api->group(['prefix' => 'customer'], function($api) {

        $api->post('{saveAddress}', ['as' => 'customer.api.saveAddress', 'uses' => 'CarrierApiController@saveAddress'])->where('saveAddress', '(?i)saveAddress(?-i)');

    });
});


?>