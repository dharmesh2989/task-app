<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Models\User;
use App\Models\PasswordReset;
use Exception;
use Illuminate\Support\Facades\Validator;

class FrontPasswordResetController extends Controller
{
    /*
|--------------------------------------------------------------------------
| Password Reset Controller
|--------------------------------------------------------------------------
|
| This controller is responsible for handling password reset requests
| and uses a simple trait to include this behavior. You're free to
| explore this trait and override any methods you wish to tweak.
|
*/
    /* ------------------------------------------------------------------------------
@Description: Function Index Client Page
------------------------------------------------------------------------------ */
    public function showPasswordRest()
    {
        $title = "Send New Password";
        return view('front.auth.restPassword', compact('title'));
    }

    /* ------------------------------------------------------------------------------
@Description: Function Send email with rest password link to the user.
------------------------------------------------------------------------------ */
    public function create(Request $request)
    {
        $customMessages = [
            'email.required'     => 'Email is Required',
        ];
        $validatedData = Validator::make($request->all(), [
            'email'       => 'required',
        ], $customMessages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try {
            $user = User::where(['email' => $request->email, 'status' => 'active'])->whereIn('user_type', ['user'])->first();
            if (!$user)
                smilify('error', "We can't find a user with that e-mail address. 🔥");
            return back()->with(['alert-type' => 'danger', 'message' => "We can't find a user with that e-mail address."]);
            $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => Str::random(60)]);
            if ($user && $passwordReset)
                $user->notify(new PasswordResetRequest($passwordReset->token));
            smilify('success', "We have e-mailed your password reset link! 🔥");
            return back()->with(['alert-type' => 'success', 'message' => 'We have e-mailed your password reset link!']);
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /* ------------------------------------------------------------------------------
@Description: Function Show Reset Password page
------------------------------------------------------------------------------ */
    public function find($token)
    {
        $title = "Change Password";
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset)
            smilify('error', "This password reset token is invalid. 🔥");
        return back()->with(['alert-type' => 'danger', 'message' => 'This password reset token is invalid.']);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            smilify('error', "This password reset token is invalid. 🔥");
            return back()->with(['alert-type' => 'danger', 'message' => 'This password reset token is invalid.']);
        }
        smilify('success', "Change Password 🔥");
        return view('front.auth.reset', compact('passwordReset', 'title'));
    }

    /* ------------------------------------------------------------------------------
@Description: Function Rest password
------------------------------------------------------------------------------ */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required||min:6|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([['token', $request->token], ['email', $request->email]])->first();
        if (!$passwordReset) {
            return back()->with(['alert-type' => 'danger', 'message' => 'This password reset token is invalid.']);
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return back()->with(['alert-type' => 'danger', 'message' => "We can't find a user with that e-mail address."]);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        smilify('success', "Password reset successfully. 🔥");
        return redirect()->route('front.login')->with(['alert-type' => 'success', 'message' => "Password reset successfully."]);
    }
}
