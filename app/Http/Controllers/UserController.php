<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function userRegistration(Request $request)
    {
        try {
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => $request->password,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully...!!!',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed...!!!',
            ], 200);
        }
    }

    public function userLogin(Request $request)
    {
        $user_id = User::where(['email' => $request->email, 'password' => $request->password,])->select('id')->first();
        if ($user_id !== null) {
            $token = JWTToken::createToken($request->email, $user_id->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successfully...!!!',
            ], 200)->cookie('token', $token, 60 * 60 * 24);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Login Failed...!!!',
            ]);
        }
    }

    public function logout()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User Logout Successfully...!!!',
        ], 200)->cookie('token', null, -1);
    }

    public function sentOtp(Request $request)
    {
        $email = $request->email;
        $otp = rand(1000, 9999);
        $count = User::where('email', $request->email)->count();
        if ($count === 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => 'Otp Sent Successfully...!!!',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unable to sent otp...!!!',
            ], 200);
        }
    }

    public function verifyOtp(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;
        $user = User::where(['email' => $email, 'otp' => $otp])->first();
        if ($user !== null) {
            User::where('email', $email)->update(['otp' => 0]);
            $token = JWTToken::createTokenForResetPassword($email);
            return response()->json([
                'status' => 'success',
                'message' => 'Otp Verified Successfully...!!!'
            ], 200)->cookie('token', $token, 60 * 60 * 24);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unable to verify otp...!!!',
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $email = $request->header('user_email');
            $password = $request->password;
            User::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successfully...!!!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Password Reset Failed...!!!',
            ]);
        }
    }

    public function userProfile(Request $request)
    {
        $email = $request->header('user_email');
        return $email;
        dd();
        $user = User::where('email', $email)->first();
        if ($user !== null) {
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile Successfully.',
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Profile Failed.',
            ]);
        }
    }

    public function userProfileUpdate(Request $request)
    {
        // $email = $request->header('user_email');
        // return $email;
        // dd();
        try {
            $email = $request->header('user_email');
            // $user = User::where('email', $email)->first();
            // return $user;
            // dd();
            $validation = Validator::make($request->all(), [
                "first_name" => "required|string|max:255",
                "last_name" => "required|string|max:255",
                "email" => "required|email|max:255",
                // "email" => [ "nullable", "email", "max:255", Rule::unique('users')->ignore($user->id),],
                "mobile" => 'nullable|numeric|digits:11',

            ]);
            if ($validation->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation Error',
                    'errors' => $validation->errors(),
                ], 422);
            }
            // $validated = $validation->validated();
            $user = User::where('email', $email)->update([
                'first_name' => $validation->validated()['first_name'],
                'last_name' => $validation->validated()['last_name'],
                'email' => $validation->validated()['email'],
                'mobile' => $validation->validated()['mobile'],
                'password' => $request->password,
                'updated_at' => now(),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile Update Successfully.',
                'data' => $user,
            ], 200)->cookie('token', null, -1);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Profile Update Failed.',
            ]);
        }
    }
}
