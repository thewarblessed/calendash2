<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomplishment;
use App\Models\Event;
use App\Models\Documentation;
use DB;

class AccomplishmentReportsController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'APPROVED')->orderBy('id')->get();

        return view('admin.accomplishmentReports.index', compact('events'));
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

    public function getEventsImages(string $id)
    {
        $documentations = Documentation::join('accomplishmentreports','accomplishmentreports.id','documentations.accomplishmentreports_id')
        ->select('image')->where('accomplishmentreports.event_id',$id)->get();
        
        return response()->json($documentations);
    } 

    public function checkUserAccomplishment(String $id)
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
                        ->where('events.user_id', $id)
                        ->where('events.end_date', '<', now()->format('Y-m-d'))
                        ->get();

        if ($events->isEmpty()) {
            return response()->json(['error' => 'No approved events found']);
        }
        
        $eventIds = $events->pluck('id')->toArray();
        // dd($eventIds);
        $pendingAccomplishments = Accomplishment::whereIn('event_id', $eventIds)
                                                ->exists();
        
        if ($pendingAccomplishments) {
            return response()->json(['success' => 'User has already accomplishment report']);
        }
        else{
            return response()->json(['error' => 'User has pending accomplishment report']);
        }
        
        // return response()->json(['success' => true]);
        // dd($events->id)
    }
}
