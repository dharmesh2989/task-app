<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $redirectTo = '/admin/dashboard';
    protected $authLayout = 'admin.auth.';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
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
                if (Auth::user()->user_type == 'admin') {
                    smilify('success', 'Welcome to Admin Panel. 🔥');
                    return redirect()->route('admin.dashboard');
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
        smilify('success', 'Logout Admin Panel. 🔥');
        return redirect()->route('admin.login');
    }
}
