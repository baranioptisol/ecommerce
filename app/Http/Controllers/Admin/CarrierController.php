<?php
/**
   * Carrier Controller 
   * Carrier -> Fedex Service
   * @package    Laravel
   * @subpackage Controller
   * @author     Barani <barani.p@optisolbusiness.com>
   */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Http\Models\Customers as Customer;
use Redirect;
use Session;

class CarrierController extends Controller
{
    use Helpers;

    public function __construct() {

    }

     /**
        *
        * Get customer Address 
        * @return Array
        */
     public  function saveAddress(Request $request) {
            $data = $request->all();
            $response =$this->api->post('/api/customer/saveAddress',$data);
            if(isset($response['status']) && $response['status'])
            {
                $data['address'] = $response['result'];
                return Redirect::to('/dashboard')->with($data);
            }
            else
            {
                return Redirect::to('/dashboard')->with('flash_notice',$response['message']);
            }
     }

}
