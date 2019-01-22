<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function regist(Request $request){
        $valid = Validator::make($request->all(), [
            'nim' => 'required|numeric|unique:member,nim_member',
            'nama'  => 'required',
            'gender'    => 'required',
            'username'  => 'required|unique:member,username',
            'password'  => 'required|confirmed|min:8',
            'lineID'    => 'required'
        ]);

        if($valid->fails()){
            return response()->json([
                'success'   => false,
                'error'     => $valid->errors()
            ], 500);
        }

        $user = new User;
        $user->nim_member = $request->nim;
        $user->nama_member = $request->nama;
        $user->id_line = $request->lineID;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->jk_member = $request->gender;
        $user->join_at = date("Y-m-d H:i:s");
        $user->save();

        return response()->json([
            'success'   => true
        ]);

    }
}
