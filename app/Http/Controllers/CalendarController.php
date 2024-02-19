<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use DB;

class CalendarController extends Controller
{
    //
    public function myCalendar()
    {
        // $data['header_title'] =  "My Calendar";
        // $events = Event::orderBy('id')->get();
        // return view ('mycalendar', ['event' => $events]);
        // $events = Event::orderBy('id')->select('event_name as title','description','event_date as start',)->get();
        $events = Event::orderBy('id')->select('id','event_name as title','description','status','color')->selectRaw('CONCAT(start_date, "T", start_time) as start')->selectRaw('CONCAT(end_date, "T", end_time) as end')->get();
        
        // dd($events);

        return response()->json($events);

    }

    public function myCalendarDetails(string $id)
    {
        // $data['header_title'] =  "My Calendar";
        // $events = Event::orderBy('id')->get();
        // return view ('mycalendar', ['event' => $events]);
        // $events = Event::orderBy('id')->select('event_name as title','description','event_date as start',)->get();
        // IF STUDENT
        $events = Event::join('venues', 'events.venue_id','venues.id')
                        ->where('events.id', $id)
                        ->first();
        // dd($events);

        return response()->json($events);

    }
}
