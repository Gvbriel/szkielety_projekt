<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        if(!Auth::attempt(['email'=>$login['email'], 'password'=>$login['password']]))
        {
            return response(['message' => 'Invalid login']);
        }

        $user = User::where('email', $request->email)->first();
        $accessToken = User::where('email', $request->email)->first()->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json(['user' => $user, 'access_token' => $accessToken]);
    }
}
