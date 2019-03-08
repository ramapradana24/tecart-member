<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ForgetPasswordController extends Controller
{
    public function index(){
        return view('app');
    }

    public function search(Request $request){
        $user = User::where('username',$request->q)
        ->orWhere('nim_member', $request->q)
        ->selectRaw('nama_member, nim_member, email, username')
        ->first();

        if(empty($user)){
            return response()->json([
                'success'   => false,
                'msg'       => "User not found"
            ]);
        }

        return response()->json([
            'success'   => true,
            'user'      => $user
        ]);
    }
}
