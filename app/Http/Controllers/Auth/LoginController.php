<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function loginMember(Request $request){
        // return $request;
        if(Auth::attempt($request->only('nim_member', 'password'))){
            return Auth::user();
        }else{
            return response()->json([
                'success'   => false,
                'errors'    => [
                    'username'  => ["Username or password is incorrect!"]
                ]
            ], 500);
        }
    }

    public function logoutMember(){
        Auth::logout();
        return redirect(route('login'));
    }
}
