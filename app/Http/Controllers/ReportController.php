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

        $monthlyEvents = DB::table('events')
                    ->whereNotNull('target_dept')
                    ->whereNotNull('target_org')
                    ->leftJoin('organizations', 'organizations.id', '=', 'events.target_org')
                    ->selectRaw('organizations.organization as organization_name, MONTH(events.start_date) as month, YEAR(events.start_date) as year, COUNT(*) as total')
                    ->where('events.status', 'APPROVED')
                    ->groupBy('organizations.organization', 'year', 'month')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get();
                    // dd($monthlyEvents);

        $monthlyChartData = [];
        foreach ($monthlyEvents as $event) {
            $yearMonth = $event->year . '-' . str_pad($event->month, 2, '0', STR_PAD_LEFT);
            $monthlyChartData[$event->organization_name][$yearMonth] = $event->total;
        }
        
        // Prepare labels (unique year-month combinations)
        $monthlyLabels = [];
        foreach ($monthlyChartData as $organization => $data) {
            $monthlyLabels = array_merge($monthlyLabels, array_keys($data));
        }
        $monthlyLabels = array_unique($monthlyLabels);
        sort($monthlyLabels); // Sort labels chronologically

        // Prepare datasets for each organization
        $datasets = [];
        $colors = ['rgb(75, 192, 192)', 'rgb(255, 99, 132)', 'rgb(54, 162, 235)']; // Example colors
        $colorIndex = 0;
        foreach ($monthlyChartData as $organization => $data) {
            $dataset = [
                'label' => $organization,
                'data' => [],
                'fill' => false,
                'borderColor' => $colors[$colorIndex % count($colors)],
                'tension' => 0.1
            ];
            foreach ($monthlyLabels as $label) {
                $dataset['data'][] = $data[$label] ?? 0; // Use 0 if no data for that month
            }
            $datasets[] = $dataset;
            $colorIndex++;
        }



        $venues = DB::table('events')
                    ->leftJoin('organizations', 'organizations.id', 'events.target_org')
                    ->leftJoin('venues', 'venues.id', 'events.venue_id')
                    ->selectRaw('venues.name AS venue_name, COUNT(*) AS total_events')
                    ->whereNull('events.room_id')
                    ->groupBy('venues.name')
                    ->get();
        
        $organizationVenueEvents = DB::table('events')
                                        ->leftJoin('organizations', 'organizations.id', '=', 'events.target_org')
                                        ->leftJoin('venues', 'venues.id', '=', 'events.venue_id')
                                        ->selectRaw('organizations.organization AS organization_name, venues.name AS venue_name, COUNT(*) AS total_events')
                                        ->whereNotNull('events.target_dept')
                                        ->whereNotNull('events.target_org')
                                        ->whereNull('events.room_id') // Ensure room_id is null to exclude room events
                                        ->where('events.status', 'APPROVED') // Ensure the status is 'APPROVED'
                                        ->groupBy('organizations.organization', 'venues.name')
                                        ->get();
        // dd($organizationVenueEvents);
        $data = [];
        $venuesPerOrg = [];
        foreach ($organizationVenueEvents as $event) {
            $data[$event->organization_name][$event->venue_name] = $event->total_events;
            if (!in_array($event->venue_name, $venuesPerOrg)) {
                $venuesPerOrg[] = $event->venue_name;
            }
        }
        
        $organizations = array_keys($data);
        
        $chartData = [];
        foreach ($organizations as $organization) {
            $dataset = [
                'label' => $organization,
                'data' => [],
                'backgroundColor' => '#' . substr(md5(rand()), 0, 6), // Random color for each organization
            ];
            foreach ($venuesPerOrg as $venue) {
                $dataset['data'][] = $data[$organization][$venue] ?? 0;
            }
            $chartData[] = $dataset;
            }  


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
        // dd($venueNames);
        $totalEvents = $venues->pluck('total_events')->toArray();
// dd($totalEvents);

        return view('admin.report.event', compact('events', 
                                                'venues',
                                                'venueNames',
                                                'totalEvents',
                                                'eventsPerRole',
                                                'datesOfEventsPerRole',
                                                'studentData',
                                                'facultyData',
                                                'staffData',
                                                'outsiderData',
                                                'organizationVenueEvents',
                                                'venuesPerOrg',
                                                'chartData',
                                            'monthlyLabels', 'datasets'));
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