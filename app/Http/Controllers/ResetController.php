<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    //reset route
    public function ResetPassword(ResetRequest $request){
        //initialized email,token,password
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);
        //create query variable
        $emailcheck=DB::table("password_reset_tokens")->where("email",$email)->first();
        $pincheck=DB::table("password_reset_tokens")->where("token",$token)->first();
        //check if the email and pin exist
        if(!$emailcheck){
            return response([
                'message'=>'Email not found'
                ],401);
        }
        if(!$pincheck){
            return response([
                'message'=>"Pin not found"
                ],401);
        }
        //update password in users table
        DB::table('users')->where('email',$email)->update(['password'=>$password]);
        //delete the email entry
        DB::table('password_reset_tokens')->where('email',$email)->delete();
        //return message
        return response([
            'message'=>'Password change Successfully'
            ]);
    }
}
