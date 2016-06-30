<?php
/**
   * Api Trait Class
   *
   * @package    Laravel
   * @subpackage Controller
   * @author     Barani <barani.p@optisolbusiness.com>
   */

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Input;
use Request;
use Config;
use Route;
use Mail;

trait ApiTrait {
	/**
       * 
       * To get http request data for the current request
       *
       * @param array $data  
       * @return array
       */

	public function getData($data)
	{
		$post = Input::json()->all();
		if(!isset($post) || empty($post))
			$post = Input::all();
		return $post;
	}

	/**
       * 
       * To create interanl request to the form to call api method
       *
       * @param string $api  
       * @param array $data  
       * @param string $method  
       * @return array
       */

    public  function requestForm($api,$data,$method)
    {
        $request       = Request::create($api, $method, $data);
        $originalInput = Request::input();
        Request::replace($request->input());
        $response = Route::dispatch($request);
        $content  = $response->getContent();
        $results  = json_decode($content);
        Request::replace($originalInput);
        return $results; 
    }

    /**
      * 
      * @param boolean $status
      * @param integer $code
      * @param array $result
      * @return array
      **/
    public function getResponse($status, $code,$result = array('*'))
    {
     	$response['status'] = $status;
    	$response['code'] = $code;
    	$response['message'] = Config::get('errorcode')[$code];
    	$response['api'] = $this->api;
    	$response['result'] = $result;
      return $response;
    }

    /**
       * 
       * To send email 
       *
       * @param string $emailTemplate  
       * @param array  $emailData  
       * @param string $emailFrom 
       * @param string $emailTo 
       * @param string $emailSubject  
       * @return boolean
       */

    public function sendEmail($emailTemplate,$emailData = array('*'),$emailFrom,$emailTo,$emailSubject)
    {
        if($emailData && $emailTemplate)
        {
            $emailSent = Mail::send('emails.'.$emailTemplate, $emailData, function($mail) use ($emailTo, $emailFrom,$emailSubject)
            {
                $mail->from($emailFrom);
                $mail->to($emailTo)->subject($emailSubject);
            });
            if ($emailSent) return TRUE;
            else return FALSE;
        } else {
           return FALSE; 
        }
    }

    /**
       * 
       * To create random number
       *
       * @param integer $length  
       * @param string  $prefix  
       * @return boolean
       */

    public function creteRandomNumber($length = 7,$prefix=NULL)
    {
        $rand           = strtoupper(uniqid(sha1(time())));
        $orderNumber    = substr($rand, -1 * $length);  
        if($prefix)
            $generateNumber = $prefix.$orderNumber;   
        else
            $generateNumber = $orderNumber;
        return $generateNumber;
    }

    /**
       * 
       * To create random string
       *
       * @param integer $length  
       * @return boolean
       */

    public function creteRandomString($length = 7)
    {
        $key = '';
        $keys = array_merge(range('A', 'Z'), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    /**
       * 
       * To upload profile image for user
       *
       * @param string $path  
       * @param string $image    
       * @return string
       */

    public function uploadimage($path,$imagecontent)
    {
        if($path && $imagecontent) {
            $imageName = time() . ".jpg";
            $base64img = explode(",", $imagecontent);
            file_put_contents(public_path() . "/".$path."/" . $imageName, base64_decode($base64img[1])); 
            return $imageName;
        } 
    }

    /**
       * 
       * To create user role
       *
       * @param integer $userID  
       * @param string $role         
       * @return void
       */

    /*public function assignRole($userID,$role)
    {
        if($userID && $role) {
            $role_id = Role::select('id')->where('name',$role)->first();
            if($role_id->id!=''){
                $userRole = UserRole::where('user_id',$userID)->first();
                if($userRole){
                    $userRole->update(['role_id'=>$role_id->id]);
                } else {
                    $userRole = UserRole::create(['user_id'=>$userID,'role_id'=>$role_id->id]);
                }
            }
            return TRUE;
        } 
    }*/
}