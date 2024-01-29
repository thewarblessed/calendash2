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
        $events = Event::orderBy('id')->select('event_name as title','description','status')->selectRaw('CONCAT(event_date, "T", start_time) as start')->selectRaw('CONCAT(event_date, "T", end_time) as end')->get();
        

        return response()->json($events);

    }
}
