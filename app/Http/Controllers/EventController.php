<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;
use App\Models\User;
use View;
use Auth;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showVenues()
    {
        $venues = Venue::orderBy('id')->get();
        // return response()->json($venues);
        return View::make('event.create', compact('venues'));
    }

    public function searchVenues()
    {
        $venues = Venue::orderBy('id')->select('capacity')->get();

        return response()->json($venues);
        // return View::make('event.create', compact('venues'));
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
        // dd($request->all());
        $event = new Event();
        $event->user_id = $request->user_id;
        $event->venue_id = $request->event_venue;
        $event->event_name = $request->eventName;
        $event->description = $request->eventDesc;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->participants = $request->numParticipants;
        $event->target_dept = 'MTICS';
        $event->status = "PENDING";

        $request->validate([
            'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
        ]);

        // $pdfFile = $request->file('request_letter');
        // $pdfFileName = time() . '' . $pdfFile->getClientOriginalName();
        // $pdfFile->move(public_path('uploads/pdf'), $pdfFileName);

        // $file->research_file = $pdfFileName;

        $files = $request->file('request_letter');
        $event->event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
        // $venues->save();
        Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

        // $event->event_letter = "default.pdf";
        // $event->dept_head = 0;
        // $event->adaa = 0;
        // $event->atty = 0;
        // $event->osa = 0;
        
        // dd($event);
        $event->save();
        return response()->json(["success" => "Event Created Successfully.", "Event" => $event, "status" => 200]);
    }

    public function showLetter(string $id)
    {
        $event = Event::find($id);
        $request_letter = $event->event_letter;
        // dd($request_letter);
        return response()->json($request_letter);
    }


    public function showEvents()
    {   
        $events = Event::orderBy('id')->get();
        return response()->json($events);
        // return View::make('event.create', compact('venues'));
    }

    public function statusEvents()
    {   
        $eventForUser = Event::orderBy('id')->where('user_id', Auth::id())->get();
        
        return View::make('event.myEvents', compact('eventForUser'));
        
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

    /////////////// MOBILE ////////////////////
    
    public function storeMobileEvent(Request $request)
    {
        $event = new Event();
        $event->user_id = $request->user_id;
        $event->venue_id = $request->venue_id;
        $event->event_name = $request->eventname;
        $event->description = $request->description;
        $event->event_date = $request->date;
        $event->participants = $request->participants;
        $event->target_dept = $request->target_dept;
        $event->status = "PENDING";
        $event->dept_head = 0;
        $event->adaa = 0;
        $event->atty = 0;
        $event->osa = 0;
        
        $event->save();
        return response()->json(["success" => "Event Created Successfully.", "Venues" => $event, "status" => 200]);
    }

    public function getMobileEvents()
    {
        $events = Event::orderBy('id')->select('*')->where('status','approved')->get();
        // dd($venues);
        return response()->json($events);
    }

    public function getMobileAdminEvents()
    {
        $events = Event::join('users', 'users.id', 'events.user_id')->orderBy('events.id')->get();
        // $user = User::orderBy('id')->
        // $events->user_id;
        // $user = User::find(6);
        // $user = User::orderBy('id')->where('id', $events->user_id)->get();
        // dd(user)
        // dd($venues);
        return response()->json(['events' => $events, 'user']);
    }
}
