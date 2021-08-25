<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterAdmin;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        if($admin->status!=1)
        {
            Auth::logout();
            return redirect('/login')->with('message','Account Deactivated');
            exit();
        }
        return view('home');
    }
}
