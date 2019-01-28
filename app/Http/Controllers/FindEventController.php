<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Auth;
use App\Going;

class FindEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if((isset($request->service) && $request->service == 'index') || $request->q == 'all'){
            $user = Auth::user();

            $events = Event::with(['interest' => function($q){
                $q->selectRaw('interest_id, interest_name');
            }])
            ->withCount(['going' => function($q) use ($user){
                $q->where('member_id', $user->member_id);
            }])
            ->orderBy('event_id', 'desc')->get();

            return $events;
        }

        if(isset($request->q)){
            $user = Auth::user();

            $events = Event::where('event_name', 'like', '%'. $request->q .'%')
            ->with(['interest' => function($q){
                $q->selectRaw('interest_id, interest_name');
            }])
            ->withCount(['going' => function($q) use ($user){
                $q->where('member_id', $user->member_id);
            }])
            ->orderBy('event_id', 'desc')->get();

            return $events;
        }

        return view('findevent');
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
        if(isset($request->f) && $request->f==1){
            $user = Auth::user();
            
            $event = Event::where('event_name', 'like', '%'. $request->q .'%')
            ->where('event.event_id', $id)
            ->with(['interest' => function($q){
                $q->selectRaw('interest_id, interest_name');
            }])
            ->withCount(['going' => function($q) use ($user){
                $q->where('member_id', $user->member_id);
            }])
            ->first();

            return $event;
        }
        return view('findevent');
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
        //
    }

    public static function uniqidReal($lenght = 6) {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }

    public function join(Request $request){
        $alreadyGoing = Going::where([
            'event_id'  => $request->event_id,
            'member_id' => Auth::user()->member_id
        ])->count();

        if($alreadyGoing){
            return response()->json([
                'success'   => false,
                'msg'       => 'You joined this event already!'
            ], 500);
        }

        $going = new Going;
        $going->event_id = $request->event_id;
        $going->member_id = Auth::user()->member_id;
        
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
            'msg'       => 'Now you joined this event. Remember the date! Your Ticket number is:',
            'ticket'    => $ticket
        ]);
    }
}
