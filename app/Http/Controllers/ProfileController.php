<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Going;
use Auth;
use App\User;
use App\Interest;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(isset($request->service) && $request->service == 'index'){
            $going = Going::where('member_id', Auth::user()->member_id)
                ->where('valid', 1)
                ->select('event_id')
                ->with('event')
                ->orderBy('valid_at', 'desc')
                ->limit(5)
                ->get();
            
            $countGoing = Going::where('member_id', Auth::user()->member_id)
                ->where('valid', 1)
                ->count();
            
            $pts = Going::where('member_id', Auth::user()->member_id)
                ->join('event', 'event.event_id', '=', 'going.event_id')
                ->where('valid', 1)
                ->selectRaw('ifnull(sum(event_pts),0) as pts')
                ->first()->pts;
            
            $avalableInterest = Interest::selectRaw('interest_id, interest_name')->get();

            return response()->json([
                'user' => User::with('interest')->find(Auth::user()->member_id),
                'going' => $going,
                'count_going' => $countGoing,
                'pts'   => $pts,
                'interests' => $avalableInterest
            ]);
        }
        
        return view('profile', compact('going'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'nim_member' => 'required',
            'id_line'    => 'required',
            'nama_member'   => 'required',
            'username'       => 'required|unique:member,username,'. $id . ',member_id',
            'jk_member'     => 'required',
            'interest_id'   => 'required',
            'email'         => 'email',
        ],[
            'nim_member.required'   => 'NIM is required',
            'id_line.required'   => 'ID LINE is required',
            'nama_member.required'   => 'Your name is required',
            'jk_member.required'   => 'Your gender is required',
            'interest_id.required'   => 'Pick one of those interest',
            'email.email'       => 'Wrong email format',
        ]);

        if($valid->fails()){
            return response()->json([
                'success'   => false,
                'error'     => $valid->errors()
            ], 500);
        }

        $user = User::find($id);
        $user->nim_member = $request->nim_member;
        $user->nama_member = $request->nama_member;
        $user->id_line = $request->id_line;
        $user->username = $request->username;
        $user->jk_member = $request->jk_member;
        $user->interest_id = $request->interest_id;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'success'   => true,
            'msg'       => 'Success updating data.',
            'user' => User::with('interest')->find(Auth::user()->member_id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
