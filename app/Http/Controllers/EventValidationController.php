<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Going;
use App\Http\Controllers\FindEventController;

class EventValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->s) && $request->s == 1){
            $events = Event::whereRaw("date(event_datetime) >= '" . date('Y-m-d') ."'")
                ->selectRaw('event_id, event_name, event_location, event_datetime, interest_id')
                ->with(['interest' => function($q){
                    $q->selectRaw('interest_id, interest_name');
                }])
                ->withCount('going')
                ->orderBy('event_datetime', 'desc')
                ->get();
            
            return $events;
        }
        return view('eventvalidation');
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
    public function show($id, Request $request)
    {
        if(isset($request->s) && $request->s == 1){
            $participants = Going::where('event_id', $id)
                ->selectRaw('going_id, member_id, valid')
                ->with(['member' => function($q){
                    $q->selectRaw('member_id, nim_member, nama_member, interest_id');
                }])
                ->orderBy('going_id', 'desc')
                ->get();
            
            return $participants;

        }

        if(isset($request->t)){
            $member = Going::where([
                'ticket' => $request->t,
                'event_id'  => $id
                ])
                ->selectRaw('going_id, member_id, event_id, valid, ticket')
                ->with('member')
                ->with('event')
                ->first();
            
            if(empty($member)){
                return response()->json([
                    'success'   => false,
                    'msg'       => 'Ticket not found'
                ], 500);
            }
            return $member;
        }
        return view('eventvalidation');
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
        
        $going = Going::find($id);
        if(empty($going)){
            return response()->json([
                'success'   => false,
                'msg'       => 'Ticket not found'
            ], 500);
        }

        if(isset($request->s) && $request->s == 'unv'){
            $going->valid = 0;
            $ticketInUse = true;
            while($ticketInUse){
                $ticket = FindEventController::uniqidReal();
                $ticketExist = Going::where('ticket', $ticket)->count();
                if($ticketExist == 0){
                    $ticketInUse = false;
                }
            }

            $going->ticket = $ticket;
            $going->save();

            return response()->json([
                'success'   => true,
                'msg'       => 'Unverified Ticket success!'
            ]);
        }


        $going->valid = 1;
        $going->ticket = null;
        $going->valid_at = date('Y-m-d H:i:s');
        $going->save();

        return response()->json([
            'success'   => true,
            'msg'       => 'Verify ticket success!'
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
