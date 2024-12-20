<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;

class FrontLoginController extends Controller
{
    protected $redirectTo = '/front/welcome';
    protected $authLayout = 'front.auth.';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        // dd("in");
        return view($this->authLayout . 'login');
    }

    public function login(Request $request)
    {
        $customMessages = [
            'email.required'     => 'Email is Required',
            'password.required'  => 'password is Required',
        ];
        $validatedData = Validator::make($request->all(), [
            'email'       => 'required',
            'password'    => 'required',
        ], $customMessages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try {
            if (Auth::attempt([
                'email'     => $request->get('email'),
                'password'  => $request->get('password'),
                'status'    => 'active',
            ])) {
                if (Auth::user()->user_type == 'user') {
                    smilify('success', 'Welcome to User Panel. 🔥');
                    return redirect()->route('front.home');
                }
            } else {
                Auth::logout();
                smilify('error', 'Invalid credentials 🔥');
                return back()->with(['alert-type' => 'danger', 'message' => "Invalid credentials"]);
            }
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        Auth::logout();
        smilify('success', 'User Logout. 🔥');
        return redirect()->route('front.showLoginForm');
    }
}
