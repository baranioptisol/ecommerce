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

/*Route::group(['middleware' => ['web']], function () {
	
	// Login

	Route::get('/',['as' => 'homelogin', 'middleware' => 'exist', function() {
		return view('login.login');
	}]);

});*/
Route::get('/', function () {

    return View::make('crop.imgform');
});
Route::get('/login', function(){
	return view('login.login');
});
Route::get('/imageform', function()
{
	 return view('welcome');    
});

Route::post('imageformpost',['as' => 'imageform', function()
{
    return View::make('imageform');
}]);

?>