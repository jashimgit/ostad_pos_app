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



    public function login()
    {
        return view('pages.auth.login-page');
    }


    public  function register()
    {
        return view('pages.auth.registration-page');
    }


    public function showSendOtpForm()
    {
        return view('pages.auth.send-otp-page');
    }


    public function showVerifyOtpForm()
    {
        return view('pages.auth.verify-otp-page');
    }



    public function showResetPasswordForm()
    {
        return view('pages.auth.reset-pass-page');
    }





    public function showUserProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }



    public function showUserProfile(Request $request)
    {
        $email = $request->header('email');

        $user = User::where('email', $email)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Request Successfull',
            'data' => $user,
        ], 200);
    }



    // update user profile


    public function userProfileUpdate(Request $request)
    {
        $data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ];

        User::where('email', $request->header('email'))->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'profile update successful',
        ], 200);
    }


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


    /**
     *  process user login
     *  method : post
     *  return response
     * 
     */

    public function userLogin(Request $request)
    {
        try {
            $user = User::where('email', $request->input('email'))->first();

            if (Hash::check($request->password, $user->password)) {

                $token = JwtTokenHelper::CreateToken($request->email, $user->id);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User Login Successful',
                ], 200)->cookie('token', $token, time() + 60 * 24 * 30);

            } else {

                return response()->json([
                    'status' => 'failed',
                    'message' => 'unauthorized'
                ], 401);
            }
            
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function sendOtp(Request $request)
    {
        try {

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
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status' => 'success',
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function verifyOtp(Request $request)
    {
        try {
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

                ], 200)->cookie('token', $token, 60 * 24 * 30);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 501);
        }
    }

    // reset password

    public function resetPassword(Request $request)
    {
        try {
            $password = $request->password;
            $email = $request->header('email');


            // dd($email);

            User::where('email', $email)->update([
                'password' => Hash::make($password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset succssfully, please Login',
            ], 200);
            
        } catch (\Throwable $th) {


            return response()->json([
                'status' => 'success',
                'message' => $th->getMessage(),
            ], 401);
        }
    }





    // logout

    public function logout()
    {
        return redirect('/login')->cookie('token', '', -1);
    }
}
