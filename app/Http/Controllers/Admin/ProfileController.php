<?php

/**
   * Admin Profile Class
   *
   * @package    Laravel
   * @subpackage Controller
   * @author     Barani <barani.p@optisolbusiness.com>
   */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers; // helps in role 
use App\Http\Models\Users;
use Auth;
use Hash;
use Redirect;
use Validator;

class ProfileController extends Controller
{
    use Helpers;

    public function _construct()
    {


    }

    /**
       * 
       * View Profile
       *
       * @return view 
       */

    public function view() {
       $data['id'] = Auth::user()->id;
       $response = $this->api->post('/api/user/getProfile',$data) ;
      // echo "<pre>";print_r($response);exit;
       if(isset($response['status']) && $response['status']) {
            $data['user'] = $response['result'][0];
       } else {
          $data['error'] = "User does not exists";
       }
       return view('profile.viewprofile')->with($data);
    }

     /**
       * 
       * Edit Profile
       *
       * @return view
       */

     public function editProfile() {
        $data['id'] = Auth::user()->id;
        $response = $this->api->post('/api/user/getProfile',$data);
        if(isset($response['status']) && $response['status']) {
            $data['user'] = $response['result'][0];
        } else {
            $data['error'] = 'User not exist';
        }   
        return view("profile.editprofile")->with($data);
     }

      /**
       * 
       * Update profile form request
       *
       * @return array
       */
      public function updateProfile(Request $request){
        $data = $request->all();
        $response = $this->api->post('/api/user/saveProfile', $data);  
        //echo "<pre>";print_r($response);exit;
        if(isset($response['status']) && $response['status']){
            return Redirect::to('/profile/view')->with('flash_success', $response['message']);
        } else {
            return Redirect::to('/profile/edit')->with('flash_notice', $response['message']);
        } 
    } 

    /**
       * 
       * Change Password form request
       *
       * @return array
       */

    public function changePassword(Request $request) {
        $data =$request->all();
        $old_password = $data['old_password'];
        if(Hash::check( $old_password, Auth::user()->password))
        {
            $rules = ['old_password'     => 'required|min:6',
                      'password'         => 'required|min:6|different:old_password',
                      'conf_password'    => 'required|min:6|same:password'];
            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                $messages = $validator->messages();
                return Redirect::back()->withErrors($messages);
            } else {
                $update = Users::where('id', Auth::user()->id)->update(['password' => Hash::make($data['password'])]);
                if($update) {
                    return Redirect::to('/changepassword')->with('flash_success','Password updated successfully.'); 
                } else {
                    return Redirect::to('/changepassword')->with('flash_success', 'Whoops! Something went wrong.'); 
                }
            }
        } else {
            return Redirect::back()->with('flash_notice', 'Your current password was incorrect.');
        }
    }
}
