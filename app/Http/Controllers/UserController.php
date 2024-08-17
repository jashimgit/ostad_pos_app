<?php

namespace App\Http\Controllers;

use App\Helpers\JwtTokenHelper;
use App\Mail\OTPMailer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    public function userRegistration(Request $request)
    {

        try {
            User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $request->password,
                'mobile' => $request->mobile,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function userLogin(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();

        if (Hash::check($request->password, $user['password'])) {
            $token = JwtTokenHelper::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
            ], 200)->cookie('token', $token, time() + 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 200);
        }
    }



    public function sendOtp(Request $request)
    {
        $email = $request->email;
        $otp = rand(1000, 9999);



        $count = User::where('email', $email)->count();

        if ($count == 1) {

            // send  otp to users email
            Mail::to($email)->send(new OTPMailer($otp));

            // update otop to user table

            User::where('email', $email)->update([
                'otp' => $otp
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'otp send'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'someting wrong'
            ], 200);
        }
    }


    public function verifyOtp(Request $request)
    {
        $otp = $request->otp;
        $email = $request->email;

        // validate
        $count = User::where('email', $email)->where('otp', $otp)->count();
        if ($count == 1) {
            // update otp
            User::where('email', $email)->update(['otp' => 0]);

            // passwrod reset token  issue
            $token = JwtTokenHelper::ResetPasswordToken($email);
            
            return response()->json([
                'status' => 'success',
                'message' => 'otp verification successfull',
                'token' => $token,
            ], 200);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'otp not matched'
            ], 200);
        }
    }
}
