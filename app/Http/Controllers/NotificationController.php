<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Official;
use Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_role = 'org_adviser';
        $user_id = 1;
        // dd($user_id);
        $official = Official::where('user_id',$user_id)->first();
        $org_id = $official->organization_id;
        $dept_id = $official->department_id;
        $section_id = $official->section_id;

        // $pending = Venue::join('events','events.venue_id','venues.id')
        //     ->orderBy('events.status')
        //     ->orderByDesc('events.id')
        //     ->where('events.target_org', $org_id)
        //     ->where('events.status','PENDING')
        //     ->get();

        // dd($pending);

        if($user_role === "org_adviser")
        {
            $pending = Venue::leftjoin('events','events.venue_id','venues.id')
                            ->leftjoin('users','events.user_id','users.id')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->where('events.target_org', $org_id)
                            ->where('events.status','PENDING')
                            ->select('events.created_at','users.name')
                            ->get();
            // dd($pending);
            // $PenEvents = Event::orderBy('id')->whereNull('org_adviser')->get();
            // dd($PenEvents);
            return response()->json($pending);
        }   
        elseif($user_role === "section_head")
        {
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->whereNotNull('org_adviser')
                        ->where('students.section_id', $section_id)
                        ->get();
            // $pending = Venue::join('events','events.venue_id','venues.id')->orderBy('events.status')->orderByDesc('events.id')->get();
            // $pending = Event::orderBy('id')->get();
            // $pending = Event::orderBy('id')->whereNotNull('org_adviser')->get();
            // dd($PenEvents);
            return response()->json($pending);
        }     
        elseif($user_role === "department_head")
        {
            // $pending = Venue::join('events','events.venue_id','venues.id')->orderBy('events.status')->orderByDesc('events.id')->get();
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->whereNotNull('sect_head')
                        ->where('students.section_id', $section_id)
                        ->get();
            // $pending = Event::orderBy('id')->get();
            // $pending = Event::orderBy('id')->whereNotNull('sect_head')->get();
            return response()->json($pending);
        }
        elseif ($user_role === "osa")
        {
            $pending = Event::orderBy('id')->whereNotNull('dept_head')
                            // ->where('status', 'PENDING')
                            ->get();
            // dd($pending);
            return response()->json($pending);
        }
        elseif ($user_role === "adaa")
        {
            $pending = Event::orderBy('id')->whereNotNull('osa')->get();
            return response()->json($pending);
        }
        elseif ($user_role === "atty")
        {
            // $pending = Event::orderBy('id')->whereNotNull('adaa', null);
            $pending = Event::join('venues', 'venues.id', 'events.venue_id')
            ->orderBy('events.id')
            ->where('venues.name', 'IT Auditorium')
            ->whereNotNull('adaa')
            ->get();
            return response()->json($pending);
        }
        elseif ($user_role === "campus_director")
        {
            // hindi dapat lalabas yung sa IT FUNCTION HALL na venue.
            $pending = Event::join('venues', 'venues.id', 'events.venue_id')
            ->orderBy('events.id')
            ->where('venues.name', '!=', 'IT Auditorium')
            ->whereNotNull('adaa')
            ->get();
            return response()->json($pending);
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
    public function store(Request $request)
    {
        //
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
