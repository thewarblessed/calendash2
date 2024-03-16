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
use App\Models\Organization;
use App\Models\Official;
use App\Models\Department;
use App\Models\Room;
use View;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use App\Mail\MailNotify;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkEventConflict(Request $request)
    {
        $event_type = $request->input('event_type');
        if($event_type ==='withinDay')
        {
            $date = $request->input('date');
            $startTime = $request->input('start_time');
            $endTime = $request->input('end_time');
            $venueId = $request->input('venue_id');
            $roomId = $request->input('room_id');

            $venueType = $request->input('selectedVenueType');

            if ($venueType === 'room'){
                $conflict = Event::where('room_id', $roomId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($date, $startTime, $endTime) {
                    $query->where(function ($q) use ($date, $startTime, $endTime) {
                        $q->where('start_date', $date)
                            ->where('start_time', '<', $endTime)
                            ->where('end_time', '>', $startTime);
                    })->orWhere(function ($q) use ($date, $startTime, $endTime) {
                        $q->where('start_date', '<', $date)
                            ->where('end_date', '>', $date);
                    });
                })
                ->exists();

            return response()->json(['conflict' => $conflict]);
            }
            else{
                $conflict = Event::where('venue_id', $venueId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($date, $startTime, $endTime) {
                    $query->where(function ($q) use ($date, $startTime, $endTime) {
                        $q->where('start_date', $date)
                            ->where('start_time', '<', $endTime)
                            ->where('end_time', '>', $startTime);
                    })->orWhere(function ($q) use ($date, $startTime, $endTime) {
                        $q->where('start_date', '<', $date)
                            ->where('end_date', '>', $date);
                    });
                })
                ->exists();

            return response()->json(['conflict' => $conflict]);
            }
            // Check if there are any events with the same venue and overlapping time
            
        }
        elseif($event_type ==='wholeDay')
        {   
            $date = $request->input('date');
            $venueId = $request->input('venue_id');
            $roomId = $request->input('room_id');

            $venueType = $request->input('selectedVenueType');
            
            if ($venueType === 'room'){
                $conflict = Event::where('room_id', $roomId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                        ->where('end_date', '>=', $date);
                })
                ->exists();
                return response()->json(['conflict' => $conflict]);
            }
            else{
                $conflict = Event::where('venue_id', $venueId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                        ->where('end_date', '>=', $date);
                })
                ->exists();
                return response()->json(['conflict' => $conflict]);
            }
            
        }
        elseif($event_type ==='wholeWeek')
        {
            $venueType = $request->input('selectedVenueType');
            $week = $request->input('date');
            $year = substr($week, 0, 4);
            $weekNumber = substr($week, 6);

            // Convert week format to start and end dates
            $startDate = date("Y-m-d", strtotime($year . "W" . $weekNumber));
            $endDate = date("Y-m-d", strtotime($year . "W" . $weekNumber . "7"));

            $venueId = $request->input('venue_id');
            $roomId = $request->input('room_id');
            // $venueId = $request->input('venue_id');
            if ($venueType === 'room'){
                $conflict = Event::where('room_id', $roomId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                })
                ->exists();
                // dd($conflict);
                return response()->json(['conflict' => $conflict]);
            }
            else{
                $conflict = Event::where('venue_id', $venueId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                })
                ->exists();
                // dd($conflict);
                return response()->json(['conflict' => $conflict]);
            }
            // Check if there are any events with the same venue and overlapping dates
            
        }
        else
        {
            $venueType = $request->input('selectedVenueType');
            // $venueId = $request->input('venue_id');
            $dateRange = $request->input('daterange');
            [$startDate, $endDate] = explode(' - ', $dateRange);
            $venueId = $request->input('venue_id');
            $roomId = $request->input('room_id');
            // dd($endDate);
            if($venueType ==='room'){
                $conflict = Event::where('room_id', $roomId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate);
                    })->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '>=', $startDate)
                            ->where('end_date', '<=', $endDate);
                    })->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
                })
                ->exists();

            return response()->json(['conflict' => $conflict]);
            }
            else{
                $conflict = Event::where('venue_id', $venueId)
                ->where('status', '!=', 'REJECTED')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate);
                    })->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '>=', $startDate)
                            ->where('end_date', '<=', $endDate);
                    })->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
                })
                ->exists();

            return response()->json(['conflict' => $conflict]);
            }
            // Check if there are any events with the same venue and overlapping date range
            
        }
        
    }

    public function showVenues()
    {
        $venues = Venue::orderBy('id')->get();
        $rooms = Room::orderBy('id')->get();
        // dd($rooms)
        // dd($rooms)
        // $departments = 
        // return response()->json($venues);
        return View::make('event.create', compact('venues','rooms'));
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
            // dd($student);
            $depID = $student->department_id;
            $orgID = $student->organization_id;
            // $td = Department::where('id',$depID)->first();
            // $to = Organization::where('id',$orgID)->first();
            // dd($depID);
            
            $target_dept = $depID;
            $target_org = $orgID;
            
            $official = Official::where('organization_id',$orgID)->first();
            // dd($official);
            // dd($official);
            $users = User::where('id',$official->user_id)->first();
            $email = $users->email;
            
            // $orgAdviser = 
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
                
                if ($request->event_place === 'room')
                {
                    Event::create([
                        'user_id' => $request->user_id,
                        'event_name' => $request->eventName,
                        'description' => $request->eventDesc,
                        'type' => 'whole_week',
                        'room_id' => $request->event_venue,
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
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                else
                {
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
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
    
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$user->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
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
    
                if ($request->event_place === 'room')
                {
                    Event::create([
                        'user_id' => $request->user_id,
                        'event_name' => $request->eventName,
                        'description' => $request->eventDesc,
                        'type' => 'within_day',
                        'room_id' => $request->event_venue,
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
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                else
                {
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
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$user->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
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
                
                if ($request->event_place === 'room')
                {
                    Event::create([
                        'user_id' => $request->user_id,
                        'event_name' => $request->eventName,
                        'description' => $request->eventDesc,
                        'type' => 'whole_day',
                        'room_id' => $request->event_venue,
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
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                else{
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
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$user->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                Mail::to($email)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            else
            {
                $dateRange = $request->daterange;
                [$startDate, $endDate] = explode(' - ', $dateRange);
                // dd($startDate);
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
                if ($request->event_place === 'room'){
                    Event::create([
                        'user_id' => $request->user_id,
                        'event_name' => $request->eventName,
                        'description' => $request->eventDesc,
                        'type' => 'whole_day',
                        'room_id' => $request->event_venue,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'start_time' => '05:00:00',
                        'end_time' => '21:00:00',
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'target_org' => $target_org,
                        'event_letter' => $event_letter,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                else{
                    Event::create([
                        'user_id' => $request->user_id,
                        'event_name' => $request->eventName,
                        'description' => $request->eventDesc,
                        'type' => 'whole_day',
                        'venue_id' => $request->event_venue,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'start_time' => '05:00:00',
                        'end_time' => '21:00:00',
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'target_org' => $target_org,
                        'event_letter' => $event_letter,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$user->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
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
                    'room_id' => $request->event_venue,
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
                    'color' => '#D6AD60',
                    'created_at' => now()
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
                    'room_id' => $request->event_venue,
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
                    'color' => '#D6AD60',
                    'created_at' => now()
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
                    'room_id' => $request->event_venue,
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
                    'color' => '#D6AD60',
                    'created_at' => now()
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            else
            {
                $dateRange = $request->daterange;
                [$startDate, $endDate] = explode(' - ', $dateRange);

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
                    'room_id' => $request->event_venue,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '05:00:00',
                    'end_time' => '21:00:00',
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60',
                    'created_at' => now()
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
                    'room_id' => $request->event_venue,
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
                    'color' => '#D6AD60',
                    'created_at' => now()
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
                    'room_id' => $request->event_venue,
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
                    'color' => '#D6AD60',
                    'created_at' => now()
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
                    'room_id' => $request->event_venue,
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
                    'color' => '#D6AD60',
                    'created_at' => now()
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            else
            {
                $dateRange = $request->daterange;
                [$startDate, $endDate] = explode(' - ', $dateRange);

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
                    'room_id' => $request->event_venue,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '05:00:00',
                    'end_time' => '21:00:00',
                    'participants' => $request->numParticipants,
                    'target_dept' => $target_dept,
                    'target_org' => $target_org,
                    'event_letter' => $event_letter,
                    'whole_week' => false,
                    'status' => 'PENDING',
                    'color' => '#D6AD60',
                    'created_at' => now()
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
    public function showAdminEvents(Request $request)
    {
        // $sortColumn = $request->query('sort', 'id'); // Default to sorting by id if no sort parameter is provided
        // $sortDirection = $request->query('direction', 'asc'); // Default to ascending order
    
        $events = Event::leftjoin('venues','venues.id','events.venue_id')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->select('organizations.organization',
                                'departments.department',
                                'events.status',
                                'events.event_name',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.type',
                                'venues.name as venueName',
                                'rooms.name as roomName',
                                'events.id')
                        ->orderByDesc('events.id')
                        ->paginate(10);
    
        return view('admin.event.index', compact('events'));
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
        $eventForUser = Event::orderByDesc('id')->where('user_id', Auth::id())->get();
        // dd($eventForUser);
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
                'room_id' => $request->event_venue,
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
                'room_id' => $request->event_venue,
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
                'room_id' => $request->event_venue,
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

    public function storeOutsiderEvents(Request $request)
    {
        $user = User::where('role','business_manager')->first();
        $email = $user->email;
        $inputType = $request->input('event_type');
        // dd($user);
        // $randomColor = '#' . Str::random(6);
        // dd($inputType);
        if ($inputType === 'wholeWeek') {
            $weekDate = $request->input('event_date_wholeWeekUser');
            // dd($weekDate);
            list($year, $week) = explode("-W", $weekDate);
            $startDate = Carbon::now()->setISODate($year, $week, 1)->toDateString();
            $endDate = Carbon::now()->setISODate($year, $week, 7)->toDateString();

            $request->validate([
                'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('receipt');
            $receipt = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

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
                'receipt_image' => $receipt,
                'status' => 'PENDING',
                'color' => '#31B4F2'
            ]);

            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
        elseif ($inputType === 'withinDay') {
            // Handle whole_day or within_day events
            $date = $request->event_date;
            $start_time = $request->start_time_withinDayUser;
            $end_time = $request->end_time_withinDayUser;

            $request->validate([
                'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('receipt');
            $event_letter = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

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
                'description' => $request->eventDesc,
                'receipt_image' => $receipt,
                'whole_week' => false,
                'status' => 'PENDING',
                'color' => '#31B4F2'
            ]);
            $data = [
                "subject" => "Calendash Pending Request",
                "body" => "Hello {$user->name}!, You have a new pending approval request!"
            ];
            Mail::to($email)->send(new MailNotify($data));
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }   
        else if ($inputType === 'wholeDay'){
            //whole day
            $date = $request->event_date_wholeDayUser;
            
            $request->validate([
                'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('receipt');
            $receipt = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
     
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
                'description' => $request->eventDesc,
                'receipt_image' => $receipt,
                'whole_week' => false,
                'status' => 'PENDING',
                'color' => '#31B4F2'
            ]);
            $data = [
                "subject" => "Calendash Pending Request",
                "body" => "Hello {$user->name}!, You have a new pending approval request!"
            ];
            Mail::to($email)->send(new MailNotify($data));
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
        else{
            $dateRange = $request->daterange;
            [$startDate, $endDate] = explode(' - ', $dateRange);
            // dd($startDate);
            $request->validate([
                'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('receipt');
            $receipt = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            Event::create([
                'user_id' => $request->user_id,
                'event_name' => $request->eventName,
                'description' => $request->eventDesc,
                'type' => 'whole_day',
                'venue_id' => $request->event_venue,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => '05:00:00',
                'end_time' => '21:00:00',
                'participants' => $request->numParticipants,
                'receipt_image' => $receipt,
                'whole_week' => false,
                'status' => 'PENDING',
                'color' => '#D6AD60',
                'created_at' => now()
            ]);
    
            $data = [
                "subject" => "Calendash Pending Request",
                "body" => "Hello {$user->name}!, You have a new pending approval request!"
            ];
            Mail::to($email)->send(new MailNotify($data));
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
    }

    /////////////// MOBILE ////////////////////
    
    public function storeMobileEvent(Request $request)
    {
        $event = new Event();
        $event->user_id = $request->user_id;
        $event->venue_id = $request->venue_id;
        $event->room_id = $request->venue_id;
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
