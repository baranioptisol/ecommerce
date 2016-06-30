<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiTrait;
use Request;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Auth\AuthManager as Auth;
use App\Http\Models\Users as User;
use App\Http\Models\Customers as Customer;
use App\Http\Models\PasswordResets;
use Validator;
use Session;
use URL;
use Mail;

class CarrierApiController extends Controller
{
    use ApiTrait;

    public $api;

    private $user;

    private $customer;

    public function __construct(Auth $auth, User $user, Customer $customer)
    {
        $this->api = Request::segment(2);
        $this->auth = $auth;
        $this->user = $user;
        $this->customer = $customer;
        $admin = $this->user->select('email')->whereId('1')->first();
        $this->email = $admin->email;
    }

    public function saveAddress() {
        try
        {
            $post = $this->getData($_REQUEST);
            if(!empty($post)) {
                $rules = [ 
                        'name' => 'required',
                        'street1' => 'required',
                        'street_no' => 'required',
                        'city' => 'required',
                        'state' => 'required',
                        'zip' => 'required',
                        'country' => 'required',
                        'phone' => 'required',
                        'email' => 'required'
                        ];
                $validator = Validator::make($post,$rules);
                if($validator->fails()){
                    $messages = $validator->messages();
                    $response = $this->getResponse(FALSE, 3, $messages);
                } else {

                    if(isset($post['id']) && !empty($post['id'])) {
                         $oCustomer = $this->customer->where(['id' => $post['id'], 'is_active' => 1, 'is_deleted' => 0])->first();
                        $msgcode = 37;
                    } else {
                        $oCustomer= new Customer;
                        $msgcode = 31;
                    }
                   $oCustomer->fill($post);
                   $oCustomer->object_purpose = $post['object_purpose'];
                   $customerresponse = \Shippo_Address::create([
                            'object_purpose' => $post['object_purpose'],
                            'name' => $post['name'],
                            'company' =>'',
                            'street1' => $post['street1'],
                            'street_no' => $post['street_no'],
                            'street2' => '',
                            'city' => $post['city'],
                            'state' =>$post['state'],
                            'zip' => $post['zip'],
                            'country' => $post['country'],
                            'phone' => $post['phone'],
                            'email' => $post['email'],
                            'validate' => true
                        ]);
                   echo "<Pre>"; print_r($customerresponse);exit;
                    if(isset($customerresponse) && !empty($customerresponse)) {
                      if($oCustomer->save()) {
                         $response = $this->getResponse(TRUE, $msgcode, $customerresponse);
                        } else {
                        $response = $this->getResponse(FALSE, 32, FALSE);
                        }  
                    } else {
                         $response = $this->getResponse(FALSE, 39, FALSE);
                    }
                    
                }

            } else {
                $response = $this->getResponse(FALSE, 3, FALSE);
            }
            return $response;
        }
        catch (\Exception $e)
        {
            $response = $this->getResponse(FALSE, 6, $e->getMessage());
            return $response;
        }

    }

    
}
