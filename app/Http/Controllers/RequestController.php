<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Models\Official;
use View;
use Carbon\Carbon;
// use Auth;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ROLE BASED TABLE
        $user_role = Auth::user()->role;
        // $events = Event::orderBy('id')
        //                 ->where('sect_head', null)
        //                 ->where('dept_head', null)
        //                 ->where('osa', null)
        //                 ->where('atty', null)
        //                 ->where('adaa', null)
        //                 ->where('campus_director', null)
        //                 ->get();
        // dd($events);
        if($user_role === "section_head")
        {
            $events = Event::orderBy('id')->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }     
        elseif($user_role === "department_head")
        {
            $events = Event::orderBy('id')->whereNotNull('sect_head', null)->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "osa")
        {
            $events = Event::orderBy('id')->whereNotNull('sect_head', null)
                                        ->whereNotNull('dept_head', null)
                                        ->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "atty")
        {
            $events = Event::orderBy('id')->whereNotNull('sect_head', null)
                                        ->whereNotNull('dept_head', null)
                                        ->whereNotNull('osa', null)
                                        ->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "adaa")
        {
            $events = Event::orderBy('id')->whereNotNull('sect_head', null)->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "campus_director")
        {
            $events = Event::orderBy('id')->whereNotNull('sect_head', null)->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        // dd($request->eventApproveId);
        $user_id = $request->eventAuthId;
        $event_id = $request->eventApproveId;

        $users = User::find($user_id);
        // dd($users->role);
        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();

        $events = Event::find($event_id);
        $events->sect_head = $officials->hash;
        // dd($events->sect_head);
        $events->save();
        // $events->
        // dd($officials->hash);
        // dd(Auth::user());
        //APPROVE REQUEST
        // 
        // $official = Auth::user();
        
        // $events->sect_head = 1; // dito dapat yung hash
        return response()->json(["events" => $events]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $events = Event::find($id);

        // dd($events->venue_id);
        $venues = Venue::find($events->venue_id);
        return response()->json(["events" => $events, "venues" => $venues, "status" => 200]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
