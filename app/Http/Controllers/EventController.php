<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;
use App\Models\MyEvent;
use App\Models\User;
use App\Models\Prof;
use App\Models\Student;
use App\Models\Staff;
use View;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;


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
        $user = User::where('id',$request->user_id)->first();
        $role = $user->role;
        $inputType = $request->input('event_type');
        // dd($request->all());
        if ($role === 'student')
        {
            $student = Student::where('user_id',$request->user_id)->first();
            // dd($request->user_id);
            $target_dept = $student->department;
            $target_org = $student->studOrg;
            //EVENT DATE TYPE
            if ($inputType === 'wholeWeek') {
                $weekDate = $request->input('event_date_wholeWeekUser');
                // dd($weekDate);
                list($year, $week) = explode("-W", $weekDate);
                $startDate = Carbon::now()->setISODate($year, $week, 1)->toDateString();
                $endDate = Carbon::now()->setISODate($year, $week, 7)->toDateString();
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'whole_week',
                    'venue_id' => $request->event_venue,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'whole_week' => true,
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            elseif ($inputType === 'withinDay') {
                // Handle whole_day or within_day events
                $date = $request->event_date_withinDayUser;
                $start_time = $request->start_time_withinDayUser;
                $end_time = $request->end_time_withinDayUser;
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'within_day',
                    'venue_id' => $request->event_venue,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }   
            else if ($inputType === 'wholeDay'){
                //whole day
                $date = $request->event_date_wholeDayUser;
                
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'whole_day',
                    'venue_id' => $request->event_venue,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => '05:00:00',
                    'end_time' => '21:00:00',
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }

        }
        elseif($role === 'professor')
        {
            $professor = Prof::where('user_id',$request->user_id)->first();
            // dd($professor);
            $target_dept = $professor->department;
            $target_org = $professor->organization;

            if ($inputType === 'wholeWeek') {
                $weekDate = $request->input('event_date_wholeWeekUser');
                // dd($weekDate);
                list($year, $week) = explode("-W", $weekDate);
                $startDate = Carbon::now()->setISODate($year, $week, 1)->toDateString();
                $endDate = Carbon::now()->setISODate($year, $week, 7)->toDateString();
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'whole_week',
                    'venue_id' => $request->event_venue,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'whole_week' => true,
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            elseif ($inputType === 'withinDay') {
                // Handle whole_day or within_day events
                $date = $request->event_date_withinDayUser;
                $start_time = $request->start_time_withinDayUser;
                $end_time = $request->end_time_withinDayUser;
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'within_day',
                    'venue_id' => $request->event_venue,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }   
            else if ($inputType === 'wholeDay'){
                //whole day
                $date = $request->event_date_wholeDayUser;
                
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'whole_day',
                    'venue_id' => $request->event_venue,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
        }
        elseif($role === 'staff')
        {
            $staff = Staff::where('user_id',$request->user_id)->first();

            $target_dept = $staff->department;
            $target_org = $staff->organization;

            if ($inputType === 'wholeWeek') {
                $weekDate = $request->input('event_date_wholeWeekUser');
                // dd($weekDate);
                list($year, $week) = explode("-W", $weekDate);
                $startDate = Carbon::now()->setISODate($year, $week, 1)->toDateString();
                $endDate = Carbon::now()->setISODate($year, $week, 7)->toDateString();
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'whole_week',
                    'venue_id' => $request->event_venue,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'whole_week' => true,
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            elseif ($inputType === 'withinDay') {
                // Handle whole_day or within_day events
                $date = $request->event_date_withinDayUser;
                $start_time = $request->start_time_withinDayUser;
                $end_time = $request->end_time_withinDayUser;
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'within_day',
                    'venue_id' => $request->event_venue,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }   
            else if ($inputType === 'wholeDay'){
                //whole day
                $date = $request->event_date_wholeDayUser;
                
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
                Event::create([
                    'user_id' => $request->user_id,
                    'event_name' => $request->eventName,
                    'description' => $request->eventDesc,
                    'type' => 'whole_day',
                    'venue_id' => $request->event_venue,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60'
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
        }
        // return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
    }

    public function showLetter(string $id)
    {
        $event = Event::find($id);
        $request_letter = $event->event_letter;
        // dd($request_letter);
        return response()->json($request_letter);
    }

                //ADMIN
    public function showAdminEvents()
    {   
        $events = Event::with('venue')->get();

                        // dd($events);
        // $user_id = $events->user_id;
        // $user = User::find($user_id);
        // dd($user);
        // return response()->json($events);
        return View::make('admin.event.index', compact('events'));
    }

    public function createAdminEvents()
    {   
        $venues = Venue::all();
        return View::make('admin.event.create', compact('venues'));
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

    public function storeMyEventsAdmin(Request $request)
    {
        $inputType = $request->input('event_type');
        // $randomColor = '#' . Str::random(6);
        // dd($inputType);
        if ($inputType === 'wholeWeek') {
            $weekDate = $request->input('event_date_wholeWeek');
            // dd($weekDate);
            list($year, $week) = explode("-W", $weekDate);
            $startDate = Carbon::now()->setISODate($year, $week, 1)->toDateString();
            $endDate = Carbon::now()->setISODate($year, $week, 7)->toDateString();

            $request->validate([
                'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
            ]);
    
            $files = $request->file('request_letter');
            $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

            Event::create([
                'event_name' => $request->eventName,
                'description' => $request->eventDesc,
                'type' => 'whole_week',
                'venue_id' => $request->event_venue,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => '00:00:00',
                'end_time' => '00:00:00',
                'whole_week' => true,
                'participants' => $request->numParticipants,
                'target_dept' => $request->event_dept,
                'target_org' => $request->event_org,
                'description' => $request->eventDesc,
                'event_letter' => $event_letter,
                'status' => 'APPROVED',
                'color' => '#31B4F2'
            ]);

            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
        elseif ($inputType === 'withinDay') {
            // Handle whole_day or within_day events
            $date = $request->event_date;
            $start_time = $request->start_time_withinDay;
            $end_time = $request->end_time_withinDay;

            $request->validate([
                'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
            ]);
    
            $files = $request->file('request_letter');
            $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

            Event::create([
                'event_name' => $request->eventName,
                'description' => $request->eventDesc,
                'type' => 'within_day',
                'venue_id' => $request->event_venue,
                'start_date' => $date,
                'end_date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'participants' => $request->numParticipants,
                'target_dept' => $request->event_dept,
                'target_org' => $request->event_org,
                'description' => $request->eventDesc,
                'event_letter' => $event_letter,
                'whole_week' => false,
                'status' => 'APPROVED',
                'color' => '#31B4F2'
            ]);
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }   
        else if ($inputType === 'wholeDay'){
            //whole day
            $date = $request->event_date_wholeDay;
            
            $request->validate([
                'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
            ]);
    
            $files = $request->file('request_letter');
            $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
            Event::create([
                'event_name' => $request->eventName,
                'description' => $request->eventDesc,
                'type' => 'whole_day',
                'venue_id' => $request->event_venue,
                'start_date' => $date,
                'end_date' => $date,
                'start_time' => '00:00:00',
                'end_time' => '00:00:00',
                'participants' => $request->numParticipants,
                'target_dept' => $request->event_dept,
                'target_org' => $request->event_org,
                'description' => $request->eventDesc,
                'event_letter' => $event_letter,
                'whole_week' => false,
                'status' => 'APPROVED',
                'color' => '#31B4F2'
            ]);
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
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
