<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\MasterAdmin;
use Session; 
class LoginContoller extends Controller
{use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $table = 'master_admin';

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function showLogin()
    {
    	return view('auth.login');
    }

    // public function authenticate(Request $request)
    // { #request
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
    //         // Authentication passed...
    //         return redirect()->intended('/home');
    //     }
    // }
}
