<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class ForgotController extends Controller
{
    //forget password
    public function ForgetPassword(ForgetRequest $request){
        //get the email address
        $email=$request->email;
        //check if email address does not exist
        if(DB::table("users")->where("email",$email)->doesntExist()){
            return response([
                'message'=>"Invalid Email"], 401);
    }
    //if email exists
    //generate a pin code
    $token = rand(10,1000);
    try{
        //insert to password reset table
        DB::table('password_reset_tokens')->insert([
            'email'=>$email,
            'token'=>$token
            ]) ;
         //send mail using ForgetMail
         Mail::to($email)->send(new ForgetMail($token));
         return response([
            'message'=>'Reset password mail sent to email'], 200);   
    }catch(Exception $exception){
        return response([
            'message' => $exception->getMessage()
            ],400);
}
}}