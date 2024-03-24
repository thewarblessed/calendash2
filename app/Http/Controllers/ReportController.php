<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Organization;


class ReportController extends Controller
{
    public function index()
    {
        // Your code to show the main reports dashboard view
    }

    public function showEventReport()
    {
        // // Your code to fetch and display the event report view
        // // $venues = Venue::all();
        // $events = Event::all();
        // return view('admin.report.event');
        // Fetch events from the database
        $events = Event::all(); // Adjust this according to your specific criteria for fetching events

        // Pass the events data to the view
        return view('admin.report.event', compact('events'));
    }
}

