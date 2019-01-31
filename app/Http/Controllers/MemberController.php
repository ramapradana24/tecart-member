<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Interest;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->service) && $request->service == 'index'){
            $memberCount = Interest::leftJoin('member', 'interest.interest_id', '=', 'member.interest_id')
                ->selectRaw('count(member_id) as member_count, interest_name')
                ->groupBy('interest.interest_id')
                ->get();
            
            $allUsersCount = 0;
            foreach($memberCount as $item){
                $allUsersCount += $item->member_count;
            }
            
            return response()->json([
                'all_users' => $allUsersCount,
                'interest_counts'   => $memberCount,
                'members'   => Member::with('interest')->orderBy('member_id', 'desc')->get()
            ]);
        }
        return view('admin.member');
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
        #update status admin
        if(isset($request->s) && $request->s == 1){
            $member = Member::find($id);
            $member->is_admin = ($member->is_admin == 1) ? 0 : 1;
            $member->save();

            return response()->json([
                'success'   => true,
                'msg'       => 'Change member admin status success'
            ]);
        }
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
