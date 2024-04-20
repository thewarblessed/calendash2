<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccomplishmentReport;
use App\Models\Event;
use App\Models\Documentation;
use DB;

class AccomplishmentReportsController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'APPROVED')->orderBy('id')->get();

        return view('admin.accomplishmentreports.index', compact('events'));
    }

    public function getAllApprovedEvents()
    {
        $events = Event::leftJoin('venues', 'venues.id', 'events.venue_id')
            ->leftJoin('rooms', 'rooms.id', 'events.room_id')
            ->leftJoin('organizations', 'organizations.id', 'events.target_org')
            ->leftJoin('departments', 'departments.id', 'events.target_dept')
            ->select('organizations.organization',
                'departments.department',
                'events.status',
                'events.event_name',
                'events.start_date',
                'events.end_date',
                'events.start_time',
                'events.end_time',
                'events.type',
                'events.event_letter',
                DB::raw('CASE
                                    WHEN rooms.name IS NULL THEN venues.name
                                    ELSE rooms.name END AS venueName'),
                'events.id')
            ->where('status', 'APPROVED')
            ->get();
    
        return response()->json($events);
    }

    public function getEventsImages()
    {
        $documentations = Documentation::select('image')->orderBy('id')->get();
        
        return response()->json($documentations);
    }
    

}
