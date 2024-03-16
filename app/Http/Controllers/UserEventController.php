<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Venue;
use App\Models\Room;
use App\Models\Event;

class UserEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function myApproved()
    {
        return view('user.myApproved');
    }

    public function myRejected()
    {
        return view('user.myRejected');
    }
    
    public function getAllRejectedRequest(Request $request, String $id)
    {
        $user_id = $id;
        // $myRejected = Events::
        $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->leftjoin('rooms','rooms.id','events.room_id')
                                ->leftjoin('users','users.id','events.rejected_by')
                                ->where('events.user_id',$user_id)
                                ->where('events.status','REJECTED')
                                ->select('organizations.organization',
                                        'users.role as rejected_by',
                                        'departments.department',
                                        'events.status',
                                        'events.event_name',
                                        'events.start_date',
                                        'events.end_date',
                                        'events.start_time',
                                        'events.end_time',
                                        'events.type',
                                        'events.remarks_org_adviser',
                                        'events.remarks_sec_head',
                                        'events.remarks_dept_head',
                                        'events.remarks_osa',
                                        'events.remarks_adaa',
                                        'events.remarks_atty',
                                        'events.remarks_campus_director',
                                        \DB::raw('CASE
                                                    WHEN rooms.name IS NULL THEN venues.name
                                                    ELSE rooms.name
                                                END AS venueName'),
                                        'events.id')
                                ->orderBy('events.id')
                                ->get();

        return response()->json($myRejectList);
    }

    public function getAllApprovedRequest (Request $request, String $id)
    {
        $user_id = $id;
        // $myRejected = Events::
        $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->leftjoin('rooms','rooms.id','events.room_id')
                                ->where('events.user_id',$user_id)
                                ->where('events.status','APPROVED')
                                ->select('organizations.organization',
                                        'departments.department',
                                        'events.status',
                                        'events.event_name',
                                        'events.start_date',
                                        'events.end_date',
                                        'events.start_time',
                                        'events.end_time',
                                        'events.type',
                                        \DB::raw('CASE
                                                    WHEN rooms.name IS NULL THEN venues.name
                                                    ELSE rooms.name
                                                END AS venueName'),
                                        'events.id')
                                ->orderBy('events.id')
                                ->get();

        return response()->json($myRejectList);
    }
}
