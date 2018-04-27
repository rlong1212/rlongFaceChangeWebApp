<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
	public function __construct() {
		$this->middleware('guest:admin');
	}
    public function showLoginForm() {
    	return view('auth.adminlogin');
    }
    public function login(Request $request) {
    	//form validation
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:6'
    	]);
    	//login attempt
    	if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    		//redirect if successful
    		return redirect()->intended(route('admin.dashboard'));
    	}
    	//redirect back if not successful
    	return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
