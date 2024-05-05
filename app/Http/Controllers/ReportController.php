<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Organization;
use DB;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index()
    {
        // Your code to show the main reports dashboard view
    }

    public function countEventPerOrgReport()
    {
        $events = DB::table('events')
                    ->whereNotNull('target_dept')
                    ->whereNotNull('target_org')
                    ->leftjoin('organizations', 'organizations.id', 'events.target_org')
                    ->selectRaw('organizations.organization as organization_name, count(*) as total')
                    ->groupBy('organizations.organization')
                    ->where('events.status','APPROVED')
                    ->get();


        $venues = DB::table('events')
                    ->leftJoin('organizations', 'organizations.id', 'events.target_org')
                    ->leftJoin('venues', 'venues.id', 'events.venue_id')
                    ->selectRaw('venues.name AS venue_name, COUNT(*) AS total_events')
                    ->whereNull('events.room_id')
                    ->groupBy('venues.name')
                    ->get();


        $eventsPerRole = DB::table('events')
                            ->leftJoin('users', 'users.id', '=', 'events.user_id')
                            ->leftJoin('organizations', 'organizations.id', '=', 'events.target_org')
                            ->selectRaw('organizations.organization as organization_name, users.role as user_role, events.start_date, count(*) as total')
                            ->groupBy('organizations.organization', 'users.role', 'events.start_date')
                            ->orderBy('events.start_date')
                            // ->where('events.status', 'APPROVED')
                            ->get();
        // dd($eventsPerRole);
        $studentData = $eventsPerRole->where('user_role', 'student')->pluck('total')->toArray();
        $facultyData = $eventsPerRole->where('user_role', 'faculty')->pluck('total')->toArray();
        $staffData = $eventsPerRole->where('user_role', 'staff')->pluck('total')->toArray();
        $outsiderData = $eventsPerRole->where('user_role', 'outsider')->pluck('total')->toArray();
        $datesOfEventsPerRole = $eventsPerRole->pluck('start_date')->map(function ($date) {
            return Carbon::parse($date)->format('F d, Y');
        })->toArray();
        // dd($outsiderData);
        // dd($eventsPerRole->start_date);
        
        $venueNames = $venues->pluck('venue_name')->toArray();
        $totalEvents = $venues->pluck('total_events')->toArray();


        return view('admin.report.event', compact('events', 
                                                'venues',
                                                'venueNames',
                                                'totalEvents',
                                                'eventsPerRole',
                                                'datesOfEventsPerRole',
                                                'studentData',
                                                'facultyData',
                                                'staffData',
                                                'outsiderData'));
    }

    // public function countNumberOfOrgPerVenue()
    // {
    //     $venues = DB::table('events')
    //                 ->leftJoin('organizations', 'organizations.id', 'events.target_org')
    //                 ->selectRaw('events.venue, COUNT(DISTINCT organizations.id) AS total_organizations')
    //                 ->groupBy('events.venue')
    //                 ->get();

    //     dd($venues);
    //     return view('admin.report.event', compact('venues'));

    //     // $rolesCount = DB::table('users')
    //     // ->select('role', DB::raw('count(*) as count'))
    //     // ->groupBy('role')
    //     // ->get();
        
    // }
}

