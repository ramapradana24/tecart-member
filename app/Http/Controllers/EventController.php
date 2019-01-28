<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Interest;
use Validator;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->service) && $request->service == 'index'){
            $limit = 10;
            // $events = Event::with(['interest' => function($q){
            //         $q->selectRaw('interest_id, interest_name');
            //     }])
            //     ->offset(($request->page - 1 * $limit))->limit(10)
            //     ->orderBy('event_id', 'desc')
            //     ->get();

            $events = Event::with(['interest' => function($q){
                    $q->selectRaw('interest_id, interest_name');
                }])->orderBy('event_id', 'desc')->get();

            
            $interest = Interest::all();
            return response()->json([
                'events'    => $events,
                'interest'  => $interest
            ]);
        }
        return view('admin.event');
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
        // return $request;
        $validator = Validator::make($request->all(), [
            'event_name'    => 'required',
            'interest_id'   => 'required',
            'event_pts'     => 'required',
            'event_desc'    => 'required',
            'event_location'    => 'required',
            'event_datetime'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => false,
                'errors'     => $validator->errors()
            ], 500);
        }

        Event::insert($request->all());
        return response()->json([
            'status'    => true,
            'msg'       => 'Success inserting event.'
        ]);
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
        $event = Event::find($id);
        if(empty($event)){
            return response()->json([
                'success'    => false,
                'errors'     => "Event Not Found"
            ], 500);
        }

        $validator = Validator::make($request->all(), [
            'event_name'    => 'required',
            'interest_id'   => 'required',
            'event_pts'     => 'required',
            'event_desc'    => 'required',
            'event_location'    => 'required',
            'event_datetime'    => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'success'    => false,
                'errors'     => $validator->errors()
            ], 500);
        }

        $event->update($request->except('created_at', 'event_id','updated_at', 'interest'));
        return response()->json([
            'success'    => true,
            'msg'       => 'Success inserting event.'
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
        $event = Event::find($id);
        if(empty($event)){
            return response()->json([
                'success'    => false,
                'msg'        => "Not Found!"
            ], 500);
        }

        $event->delete();
        return response()->json([
            'success' => true,
            'msg'       => 'Success deleting event.'
        ]);
    }
}
