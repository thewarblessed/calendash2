<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingUser;
use App\Models\Venue;

class BusinessManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pending = Venue::join('events','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->where('users.role','outsider')
                        ->select('events.event_name',
                                'venues.name',
                                'events.type',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.status',
                                'users.name as eventOrganizer')
                        ->get();
        // dd($pending);
        return view('bm.index',compact('pending'));
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
    
    public function getAllOutsideUser()
    {
        $pendingUsers = PendingUser::leftJoin('users', 'pending_users.user_id', 'users.id')
                                    ->leftJoin('organizations', 'pending_users.organization_id', 'organizations.id')
                                    ->leftJoin('departments', 'pending_users.department_id', 'departments.id')
                                    ->leftJoin('sections', 'pending_users.section_id', 'sections.id')
                                    ->select('pending_users.user_id','pending_users.tupID','pending_users.lastname','pending_users.firstname','organizations.organization','departments.department','sections.section','pending_users.role','users.email_verified_at','users.email')
                                    ->orderByDesc('pending_users.id')
                                    ->where('pending_users.role', 'outsider')
                                    ->paginate(5);

        return view('bm.outsider', compact('pendingUsers'));
    }
}
