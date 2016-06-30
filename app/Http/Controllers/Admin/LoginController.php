<?php
/**
   * Admin Login Class
   *
   * @package    Laravel
   * @subpackage Controller
   * @author     Barani <barani.p@optisolbusiness.com>
   */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Redirect;
use Session;

class LoginController extends Controller
{
    use Helpers;

    public function __construct() {

    }

    /**
	    *
	    * Login Form Request
	    * @return Array
	    */


    public function postLogin(Request $request) {
    	$data = $request->all();
    	$response = $this->api->post('/api/loginCheck', $data);      
    	if(isset($response['status']) && $response['status'] )
    	{
        
    		return Redirect::to('/dashboard');
    	}
    	else 
    	{
    		return Redirect::to('/login')->with('flash_notice',$response['message']);
    	}
    }
}
