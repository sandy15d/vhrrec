<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if (Auth()->user()->role == 'A') {
            return route('admin.dashboard');
        } elseif (Auth()->user()->role == 'R') {
            return route('recruiter.dashboard');
        } elseif (Auth()->user()->role == 'H') {
            return route('hod.dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if (auth()->user()->role == 'A') {
           return redirect()->route('admin.dashboard');
        
            }elseif(auth()->user()->role=='R'){
                return redirect()->route('recruiter.dashboard');
            }elseif(auth()->user()->role=='H'){
                return redirect()->route('hod.dashboard');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email or Password are wrong...');
        }
    }
}
