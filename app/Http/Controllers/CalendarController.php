<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    //
    public function myCalendar()
    {
        $data['header_title'] =  "My Calendar";
        $events = Event::orderBy('id')->get();
        return view ('mycalendar', ['event' => $events]);
    }
}
