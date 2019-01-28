<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Going;

class MyEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->s) && $request->s='i'){
            $user = Auth::user();

            $events = Event::with(['interest' => function($q){
                $q->selectRaw('interest_id, interest_name');
            }])
            ->join('going', 'going.event_id', '=', 'event.event_id')
            ->where([
                'member_id' => $user->member_id
            ])
            ->orderBy('event.event_id', 'desc')
            ->orderBy('valid', 'asc')
            ->get();

            return $events;
        }
        return view('myevent');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $going = Going::find($id);
        if(empty($going)){
            return response()->json([
                'success'   => false,
                'msg'       => 'Not Found!'
            ], 500);
        }

        $going->delete();
        return response()->json([
            'success'   => true,
            'msg'       => 'Success leaving this event!'
        ]);
    }
}
