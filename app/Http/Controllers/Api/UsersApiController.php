<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiTrait;
use Request;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Auth\AuthManager as Auth;
use App\Http\Models\Users as User;
use App\Http\Models\PasswordResets;
use Validator;
use Session;
use URL;
use Mail;

class UsersApiController extends Controller
{
    use ApiTrait;

    public $api;

    private $user;

    public function __construct(Auth $auth, User $user, PasswordResets $userpwdreset)
    {
        $this->api = Request::segment(2);
        $this->auth = $auth;
        $this->user = $user;
        $this->userpwdreset = $userpwdreset;
        $admin = $this->user->select('email')->whereId('1')->first();
        $this->email = $admin->email;
    }
    /**
       * 
       * Login validation 
       *
       * @return array
       */

    public function loginCheck()
    {
    	try
    	{
            $post = $this->getData($_REQUEST);
            if(!empty($post))                                                    
            {

                $data =array('username' => $post['username'], 'password' => $post['password'],'is_deleted' => 0);
                $rules = array (
                        'username' => 'required',
                        'password' => 'required'
                    );
                $validator = Validator::make($post, $rules);
                if($validator->fails()){                   
                    $messages = $validator->messages();
                    $response = $this->getResponse(FALSE,7,$messages);
                } else {
                    
                    $auth = $this->auth->attempt($data);

                    if($auth) {

                        $userData = $this->auth->user();
                        if ($userData->is_active == FALSE){
                            $response = $this->getResponse(FALSE, 22, FALSE);     
                        } else  {
                            $response = $this->getResponse(TRUE,1,$userData);    
                        }                        
                    } else {                                                
                        $response = $this->getResponse(FALSE, 11,FALSE);                       
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


    public function getProfile()
    {
        try
        {
            $post = $this->getData($_REQUEST);
            if(isset($post['id'])&& !empty($post['id'])) {
                $oUser = $this->user->select('id','username','email','first_name','last_name','address','telephone')->where(['id' => $post['id'],'is_active' => 1, 'is_deleted' => 0])->get();
                if($oUser) {
                    $response = $this->getResponse(TRUE, 1, $oUser);
                } else {
                     $response = $this->getResponse(FALSE, 4, FALSE);
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

    public function saveProfile()
    {
        try
        {
            $post = $this->getData($_REQUEST);
            if(!empty($post)) {
                $rules = [ 'first_name' => 'required',
                            'last_name' => 'required',
                             'address' => 'required',
                             'telephone' => 'required',
                             'is_active' => 'required',
                             'email' => 'required'];
                $validator = Validator::make($post, $rules);
                if($validator->fails()) {
                    $message = $validator->messages();
                    $response = $this->getResponse(FALSE, 7, $message);
                } else {
                    $oUser = $this->user->where(['id'=> $post['id'], 'is_active' => 1, 'is_deleted' =>0])->first();
                     
                    if($oUser) {
                        $oUser->fill($post);
                        $oUser->updated_at = date('Y-m-d H:i:s');
                        if(isset($post['image']) && !empty($post['image']))
                        {
                            $oUser->profile_image = $this->uploadimage('profile',$post['image']);
                        }
                        if($oUser->save()) {
                           $response = $this->getResponse(TRUE, 21, $oUser);
                        } else {
                           $response = $this->getResponse(FALSE, 5, FALSE); 
                        }
                    } else {
                        $response = $this->getResponse(FALSE, 4, FALSE);
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


    public function forgotPasswordCheck() {
        try 
        {
            $post = $this->getData($_REQUEST);
            if(!empty($post)) {
                $rules = ['email' => 'required|email'];
                $validator = Validator::make($post, $rules);
                if($validator->fails()) {
                    $messages = $validator->messages();
                    $response = $this->getResponse(FALSE, 7, $messages);
                } else {
                    $oUser = $this->user->where(['email' => $post['email']])->first();
                    if($oUser) {
                        $token = sha1(mt_rand(10000,99999).time().$oUser->email);
                        $link = URL::to('/resetpassword/'.$token.'/'.$oUser->email);
                        $emailTemplate = 'forgotpassword';
                        $emailTo = $post['email'];
                        $emailFrom = $this->email;
                        $emailSubject = 'E-Commerce Admin';
                        $token = PasswordResets::create(['email' => $post['email'],'token' => $token, 'created_at' => date('Y-m-d H:i:s')]);
                        if($token) {
                            $sent = $this->sendEmail($emailTemplate, ['link' => $link], $emailFrom, $emailTo, $emailSubject);
                            if($sent) {
                                $response = $this->getResponse(TRUE, 17, $oUser);          
                            } else {
                                $response = $this->getResponse(FALSE, 19, FALSE);          
                            }
                        } else {
                            $response = $this->getResponse(FALSE, 5, FALSE);  
                        }
                    } else {
                        $response = $this->getResponse(FALSE, 14, FALSE);
                    }   
                }
                
            } else {
                $response = $this->getReponse(FALSE, 3,  FALSE);
            }
            return $response;
        }
        catch (\Exception $e)
        {
           $response = $this->getResponse(FALSE, 6, $e->getMessage());
            return $response; 
        }
    }

    /**
       * 
       * Reset password update
       *
       * @return array
       */
    public function resetPasswordCheck() {

        try
        {
            $post = $this->getData($_REQUEST);
            if(!empty($post)) {
                $rules = ['password' => 'required'];
                $validator = Validator::make($post, $rules);
                if($validator->fails()) {
                    $messages = $validator->messages();
                    $response = $this->getResponse(FALSE, 7, $messages);
                } else {
                    $oUser = $this->user->where('email',$post['email'])->first();
                    if($oUser) {
                        $code = PasswordResets::where(['email' => $post['email'],'token' => $post['token']])->first();
                        $oUser->password = Hash::make($post['password']);
                        $oUser->updated_at = date('Y-m-d H:i:s');
                        if($oUser->save()) {  
                            $code->delete();
                            $response = $this->getResponse(TRUE, 18, TRUE);
                        } else {
                            $response = $this->getReponse(FALSE, 20, FALSE);
                        }
                    } else {
                        $response = $this->getReponse(FALSE, 4, FALSE);
                    }
                }
            } else {
                 $response = $this->getReponse(FALSE, 3,  FALSE);
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
