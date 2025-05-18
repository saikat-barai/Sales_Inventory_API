<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function userRegistration(Request $request) {
        try {
            User::create([
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => $request->password,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully...!!!',
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed...!!!',
            ],200);
        }
    }

    public function userLogin(Request $request){
        $user_id = User::where([ 'email' => $request->email,'password' => $request->password,])->select('id')->first();
        if ($user_id !== null) {
            $token = JWTToken::createToken($request->email, $user_id->id);
            return response()->json([
               'status' => 'success',
               'message' => 'User Login Successfully...!!!',
            ], 200)->cookie('token', $token, 60 * 60 * 24);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'User Login Failed...!!!',
            ]);
        }
    }

    public function logout(){
        return response()->json([
            'status' => 'success',
            'message' => 'User Logout Successfully...!!!',
        ], 200)->cookie('token', null, -1);
    }

    public function sentOtp(Request $request){
        $email = $request->email;
        $otp = rand(1000,9999);
        $count = User::where('email', $request->email)->count();
        if ($count === 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => 'Otp Sent Successfully...!!!',
            ],200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Unable to sent otp...!!!',
            ],200);
        }
    }
}
