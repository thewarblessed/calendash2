<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Organization;
use DB;


class ReportController extends Controller
{
    public function index()
    {
        // Your code to show the main reports dashboard view
    }

    public function countEventPerOrgReport()
    {
        $events = DB::table('events')
                    ->leftjoin('organizations', 'organizations.id', 'events.target_org')
                    ->selectRaw('organizations.organization as organization_name, count(*) as total')
                    ->groupBy('organizations.organization')
                    // ->where('events.status','APPROVED')
                    ->get();


        $venues = DB::table('events')
                    ->leftJoin('organizations', 'organizations.id', 'events.target_org')
                    ->leftJoin('venues', 'venues.id', 'events.venue_id')
                    ->selectRaw('venues.name AS venue_name, COUNT(*) AS total_events')
                    ->groupBy('venues.name')
                    ->get();
    
        $venueNames = $venues->pluck('venue_name')->toArray();
        $totalEvents = $venues->pluck('total_events')->toArray();
        // dd($venues);
        
        // $venueNames = $venues->pluck('venue_name')->toArray();
        // $organizationNames = $venues->pluck('organization_name')->toArray();
        // // dd($venues);
        return view('admin.report.event', compact('events', 'venues','venueNames','totalEvents'));

        // $rolesCount = DB::table('users')
        // ->select('role', DB::raw('count(*) as count'))
        // ->groupBy('role')
        // ->get();
        
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

