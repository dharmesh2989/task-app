<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $authLayout = '';
    protected $pageLayout = 'admin.pages.';

    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.';
        $this->middleware('Admin');
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }
}
