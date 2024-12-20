<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CommonController extends Controller
{
    public function __construct()
    {
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getMessage());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getMessage());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getMessage());
        }
        return response()->json(compact('user'));
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Forgot Password
    -------------------------------------------------------------------------------------------- */
    public function forgotPassword(Request $request)
    {
        $customMessages = [
            'email.required'     => 'Email is Required',
            'user_type.required'      => 'User Type is Required',
        ];
        $validatedData = Validator::make($request->all(), [
            'email'          => 'required',
            'user_type'      => 'required',
        ], $customMessages);
        if ($validatedData->fails()) {
            return response()->json(['status' => 'validtion', 'errors' => $validatedData->errors()], 200);
        }
        try {
            $user = User::where(['email' => $request->email, 'user_type' => $request->user_type])->first();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => "Please Correct E-mail Address..!"]);
            } else {
                $password = Str::random(8);
                $mailData['mail_to']     = $user->email;
                $mailData['to_name']     = $user->first_name;
                $mailData['mail_from']   = 'admin@admin.com';
                $mailData['from_title']  = 'Reset Password';
                $mailData['subject']     = 'Reset Password';
                $data = ['data' => $mailData, 'username' => $user->first_name, 'password' => $password];
                Mail::send('emails.verify', $data, function ($message) use ($mailData) {
                    $message->subject($mailData['subject']);
                    $message->from($mailData['mail_from'], $mailData['from_title']);
                    $message->to($mailData['mail_to'], $mailData['to_name']);
                });
                $user->password = Hash::make($password);
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'New Password is been Sent to your e-mail..!',]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
