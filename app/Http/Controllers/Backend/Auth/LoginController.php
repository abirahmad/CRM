<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }


    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {

        //Validate the form data
        $request->validate([
            'username'         => 'required',
            'password'         => 'required|min:6'
        ]);

        //Attempt to log the employee in
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password, 'is_approved' => 1], $request->remember)) {
            //If successful then redirect to the intended location
            session()->flash('login_success', 'Successfully Logged In');
            return redirect()->intended(route('admin.index'));
        } else {
            if (Auth::guard('admin')->attempt(['email' => $request->username, 'password' => $request->password, 'is_approved' => 1], $request->remember)) {
                //If successful then redirect to the intended location
                session()->flash('login_success', 'Successfully Logged In');
                return redirect()->intended(route('admin.index'));
            } else {
                //If unsuccessfull, then redirect to the admin login with the data
                Session::flash('login_error', "Username and password combination doesn't match. Please provide correct email and password");
                return redirect()->back()->withInput($request->only('username', 'remember'));
            }
        }
    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
