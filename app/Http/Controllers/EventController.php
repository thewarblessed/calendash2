<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Notification;
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
use DB;
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

    public function eventData()
    {
        $appointmentsResponse = file_get_contents('https://scheduler-backend-ruby.vercel.app/api/v1/appointments');
        $appointmentsData = json_decode($appointmentsResponse);
        $appointmentsArray = $appointmentsData->appointments;
        $filteredAppointments = collect($appointmentsArray)->filter(function ($appointment) {
            $allowedLocations = ['Gymnasium', 'Outdoor Court', 'Multipurpose Hall'];
            return in_array($appointment->location, $allowedLocations);
        });
        $appointments = $filteredAppointments->map(function ($appointment) {
            $color = $appointment->status === 'Pending' ? '#D6AD60' : ($appointment->status === 'Approved' ? '#31B4F2' : '#808080');
            $timeStart = $appointment->timeStart ? new \DateTime($appointment->timeStart) : null;
            $timeEnd = $appointment->timeEnd ? new \DateTime($appointment->timeEnd) : null;

            return [
                'id' => $appointment->_id ?? null,
                'title' => $appointment->title ?? '',
                'description' => $appointment->description ?? '',
                'status' => $appointment->status,
                'color' => $color,
                'venueName' => $appointment->location,
                'start' => $timeStart ? $timeStart->format('Y-m-d\TH:i:s') : '',
                'end' => $timeEnd ? $timeEnd->format('Y-m-d\TH:i:s') : '',
                'start_time' => $timeStart ? $timeStart->format('H:i:s') : '',
                'end_time' => $timeEnd ? $timeEnd->format('H:i:s') : '',
                'start_date' => $timeStart ? $timeStart->format('Y-m-d') : '',
                'end_date' => $timeEnd ? $timeEnd->format('Y-m-d') : '',
            ];
        })->values();

        $events = Event::orderBy('events.id')
                                ->leftJoin('venues', 'venues.id', 'events.venue_id')
                                ->select('events.id', 'events.event_name as title', 'events.description', 'events.status', 'events.color', 'venues.name as venueName')
                                ->selectRaw('CONCAT(events.start_date, "T", events.start_time) as start')
                                ->selectRaw('CONCAT(events.end_date, "T", events.end_time) as end')
                                ->selectRaw('DATE_FORMAT(events.start_date, "%Y-%m-%d") as start_date')
                                ->selectRaw('TIME_FORMAT(events.start_time, "%H:%i:%s") as start_time')
                                ->selectRaw('DATE_FORMAT(events.end_date, "%Y-%m-%d") as end_date')
                                ->selectRaw('TIME_FORMAT(events.end_time, "%H:%i:%s") as end_time')
                                ->where('events.status', 'PENDING')
                                ->orWhere('events.status', 'APPROVED')
                                ->get();

        $appointmentsCollection = collect($appointments);
        $eventsCollection = collect($events);
        $mergedData = $appointmentsCollection->merge($eventsCollection);
        $mergedData = $mergedData->sortBy('id')->values();

        return response()->json($mergedData);;
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

            $venue = Venue::where('id', $venueId)
                                ->select('name')
                                ->first();
            $venueName = $venue->name;
            // dd($venueName);

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
            //     $conflict = Event::where('venue_id', $venueId)
            //     ->where('status', '!=', 'REJECTED')
            //     ->where(function ($query) use ($date, $startTime, $endTime) {
            //         $query->where(function ($q) use ($date, $startTime, $endTime) {
            //             $q->where('start_date', $date)
            //                 ->where('start_time', '<', $endTime)
            //                 ->where('end_time', '>', $startTime);
            //         })->orWhere(function ($q) use ($date, $startTime, $endTime) {
            //             $q->where('start_date', '<', $date)
            //                 ->where('end_date', '>', $date);
            //         });
            //     })
            //     ->exists();
            // return response()->json(['conflict' => $conflict]);
            
                $eventData = $this->eventData()->getData();
                // dd($eventData);
                // Assuming $startDate, $endDate, $startTime, $endTime, and $venueName are defined before this code snippet

                $conflict = collect($eventData)->filter(function ($event) use ($date, $startTime, $endTime, $venueName) {
                    // Check if the event's venue name matches and if there's a time overlap
                    return $event->venueName == $venueName &&
                        $event->status != 'REJECTED' &&
                        (
                            ($event->start_date <= $date && $event->end_date >= $date) ||  // Check if event starts during the new event
                            ($event->start_date <= $date && $event->end_date >= $date) ||      // Check if event ends during the new event
                            ($event->start_date >= $date && $event->end_date <= $date) ||    // Check if event is completely within the new event
                            ($event->start_date <= $date && $event->end_date >= $date)       // Check if new event is completely within the event
                        ) &&
                        (
                            ($event->start_time <= $startTime && $event->end_time >= $startTime) ||  // Check if event starts during the new event
                            ($event->start_time <= $endTime && $event->end_time >= $endTime) ||      // Check if event ends during the new event
                            ($event->start_time >= $startTime && $event->end_time <= $endTime) ||    // Check if event is completely within the new event
                            ($event->start_time <= $startTime && $event->end_time >= $endTime)       // Check if new event is completely within the event
                        );
                })->isEmpty();

                return response()->json(['conflict' => !$conflict]);

            }
        }
        elseif($event_type ==='wholeDay')
        {   
            $date = $request->input('date');
            $venueId = $request->input('venue_id');
            $venue = Venue::where('id', $venueId)->select('name')->first();
            $venueName = $venue->name;
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
                // $conflict = Event::where('venue_id', $venueId)
                // ->where('status', '!=', 'REJECTED')
                // ->where(function ($query) use ($date) {
                //     $query->where('start_date', '<=', $date)
                //         ->where('end_date', '>=', $date);
                // })
                // ->exists();
                // return response()->json(['conflict' => $conflict]);

                $eventData = $this->eventData()->getData();
                // dd($eventData);
                $conflict = collect($eventData)->filter(function ($event) use ($date, $venueName) {
                    // Check if the event's venue name matches and if there's a date overlap
                    return $event->venueName == $venueName &&
                        $event->status != 'REJECTED' &&
                        $event->start_date == $date; // Check if the event's start date is the same as the given date
                })->isNotEmpty();
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
            $venue = Venue::where('id', $venueId)->select('name')->first();
            $venueName = $venue->name;
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
                // $conflict = Event::where('venue_id', $venueId)
                // ->where('status', '!=', 'REJECTED')
                // ->where(function ($query) use ($startDate, $endDate) {
                //     $query->where('start_date', '<=', $endDate)
                //         ->where('end_date', '>=', $startDate);
                // })
                // ->exists();
                // // dd($conflict);
                // return response()->json(['conflict' => $conflict]);
                $eventData = $this->eventData()->getData();

                $conflict = false;
                // Iterate over each day in the week
                for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate = date("Y-m-d", strtotime($currentDate . "+1 day"))) {
                    // Check for conflicts for each day
                    $conflict = collect($eventData)->filter(function ($event) use ($currentDate, $venueName) {
                        // Check if the event's venue name matches and if there's a date overlap
                        return $event->venueName == $venueName &&
                            $event->status != 'REJECTED' &&
                            $event->start_date == $currentDate; // Check if the event's start date is the same as the current date
                    })->isNotEmpty();

                    // If a conflict is found for any day, break out of the loop
                    if ($conflict) {
                        break;
                    }
                }

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
            $venue = Venue::where('id', $venueId)->select('name')->first();
            $venueName = $venue->name;
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
                // $conflict = Event::where('venue_id', $venueId)
                //     ->where('status', '!=', 'REJECTED')
                //     ->where(function ($query) use ($startDate, $endDate) {
                //     $query->where(function ($q) use ($startDate, $endDate) {
                //         $q->where('start_date', '<=', $endDate)
                //             ->where('end_date', '>=', $startDate);
                //     })->orWhere(function ($q) use ($startDate, $endDate) {
                //         $q->where('start_date', '>=', $startDate)
                //             ->where('end_date', '<=', $endDate);
                //     })->orWhere(function ($q) use ($startDate, $endDate) {
                //         $q->where('start_date', '<=', $startDate)
                //             ->where('end_date', '>=', $endDate);
                //     });
                // })
                // ->exists();
            $eventData = $this->eventData()->getData();

            $conflict = false;
            // Iterate over each day in the date range
            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate = date("Y-m-d", strtotime($currentDate . "+1 day"))) {
                // Check for conflicts for each day
                $conflict = collect($eventData)->filter(function ($event) use ($currentDate, $venueName) {
                    // Check if the event's venue name matches and if there's a date overlap
                    return $event->venueName == $venueName &&
                        $event->status != 'REJECTED' &&
                        $event->start_date <= $currentDate &&
                        $event->end_date >= $currentDate; // Check if the current date is between the event's start and end dates
                })->isNotEmpty();

                // If a conflict is found for any day, break out of the loop
                if ($conflict) {
                    break;
                }
            }

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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
    
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));

                Notification::create([
                    'to_user_id' => $users->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
    
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $users->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $users->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
                    'created_at' => now()
                ]);
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $users->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
                    'created_at' => now()
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }

        }
        elseif($role === 'professor')
        {
            $professor = Prof::where('user_id',$request->user_id)->first();
            // dd($professor);
            $adaf = User::where('role','atty')->first();
            $adafEmail = $adaf->email;
            // dd($adafEmail);
            // dd($professor);
            $target_dept = $professor->department_id;
            // dd($target_dept);

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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
                if ($request->event_place === 'room'){
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'org_adviser' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                else{
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'adaa' => 'notnull',
                        'created_at' => now()
                    ]);
    
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaf->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                if ($request->event_place === 'room'){
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'org_adviser' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                else{
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'adaa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaf->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                if ($request->event_place === 'room'){
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'org_adviser' => 'notnull',
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
                        'start_time' => '00:00:00',
                        'end_time' => '00:00:00',
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'adaa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaf->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'org_adviser' => 'notnull',
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'adaa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaf->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
                    'created_at' => now()
                ]);
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
        }
        elseif($role === 'staff')
        {
            $staff = Staff::where('user_id',$request->user_id)->first();

            $target_dept = $staff->department_id;
            // $target_org = $staff->organization;
            
            $adaa = User::where('role','adaa')->first();
            $adaaEmail = $adaa->email;

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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $feedback_image = $request->feedback_qr_code;
                // // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                $feedback_image = $request->feedback_qr_code;

                
                if ($request->event_place === 'room'){
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'type' => 'whole_week',
                        'venue_id' => $request->event_venue,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'start_time' => '00:00:00',
                        'end_time' => '00:00:00',
                        'whole_week' => true,
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'osa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaa->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                $feedback_image = $request->feedback_qr_code;
                // $feedback_image = 'images/'.time().'-'.$files->getClientOriginalName();
                // // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                if ($request->event_place === 'room'){
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'type' => 'within_day',
                        'venue_id' => $request->event_venue,
                        'start_date' => $date,
                        'end_date' => $date,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'osa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaa->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                if ($request->event_place === 'room'){
                    Event::create([
                        'user_id' => $request->user_id,
                        'event_name' => $request->eventName,
                        'description' => $request->eventDesc,
                        'type' => 'whole_day',
                        'room_id' => $request->event_venue,
                        'start_date' => $date,
                        'end_date' => $date,
                        'start_time' => '00:00:00',
                        'end_time' => '00:00:00',
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'start_time' => '00:00:00',
                        'end_time' => '00:00:00',
                        'participants' => $request->numParticipants,
                        'target_dept' => $target_dept,
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'osa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaa->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                // $feedback_image = 'images/'.time().'-'.$files->getClientOriginalName();
                // // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                $feedback_image = $request->feedback_qr_code;
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'osa' => 'notnull',
                        'created_at' => now()
                    ]);
                }
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                Notification::create([
                    'to_user_id' => $adaa->id,
                    'subject' => "Calendash Pending Request",
                    'message' => "You have a pending request!",
                    'from_user_id' => $request->user_id,
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
    
        return view('admin.event.index');
    }

    public function getAdminAllEvents()
    {
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
                                'events.event_letter',
                                DB::raw('CASE
                                    WHEN rooms.name IS NULL THEN venues.name
                                    ELSE rooms.name END AS venueName'),
                                'events.id')
                        ->orderByDesc('events.id')
                        ->get();

        return response()->json($events);
    }

    //ADMIN SEARCH EVENTDATE
    public function getEventDate(Request $request)
    {
        // dd($request->all());
        $startDate = $request->input('start_date');
        
        $event = Event::leftjoin('venues','venues.id','events.venue_id')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->select('organizations.organization',
                                    'departments.department',
                                    'events.status',
                                    'events.event_name',
                                    'events.start_date',
                                    'events.end_date',
                                    'events.start_time',
                                    'events.end_time',
                                    'events.type',
                                    'events.event_letter',
                                    DB::raw('CASE
                                    WHEN rooms.name IS NULL THEN venues.name
                                    ELSE rooms.name END AS venueName'),
                                    'events.id')
                        ->where('start_date', $startDate)->get();

        return response()->json($event);
        
    }

    //AdminEvents - Edit Event
    public function showAdminSingleEvent(String $id)
    {
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
                                DB::raw('CASE
                                WHEN rooms.name IS NULL THEN venues.name
                                ELSE rooms.name END AS venueName'),
                                'events.id')
                        ->where('events.id', $id)
                        ->orderByDesc('events.id')
                        ->first();
           return response()->json($events);
    }

    // public function editAdminEvents(string $id)
    // {
    //      // Find the event by its ID
    //        $event = Event::where('id', $id)->first();
       
    //        // Check if the event exists
    //        if (!$event) {
    //            return response()->json(["error" => "Event not found.", "status" => 404]);
    //        }
       
    //        // Return the event data as JSON response
    //        return response()->json(["event" => $event, "status" => 200]);
    // }
    
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
        $eventForUser = Event::orderByDesc('id')->where('user_id', Auth::id())
                                ->where('status','PENDING')                                    
                                ->get();
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

            $request->validate([
                'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('feedback_image');
            $feedback_image = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

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
                'feedback_image' => $feedback_image,
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

            $request->validate([
                'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('feedback_image');
            $feedback_image = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

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
                'feedback_image' => $feedback_image,
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

            $request->validate([
                'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
            ]);
    
            $files = $request->file('feedback_image');
            $feedback_image = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
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
                'feedback_image' => $feedback_image,
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

    public function storeEventMobile(Request $request)
    {
        //
        $user = User::where('id',$request->user_id)->first();
        $role = $user->role;
        $inputType = $request->dateType;
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
                $weekDate = $request->selectedDate;
                // dd($weekDate);
                
                // list($year, $week) = explode("-W", $weekDate);
                $startDate = $weekDate;
                $endDate = Carbon::parse($weekDate)->addDays(6)->toDateString();
                // dd($endDate);
                $request->validate([    
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
    
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            elseif ($inputType === 'withinDay') {
                // Handle whole_day or within_day events
                $date = $request->event_date;
                $start_time = $request->startTime;
                $end_time = $request->endTime;
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                $feedback_image = $request->feedback_qr_code;
    
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }   
            else if ($inputType === 'wholeDay'){
                //whole day
                $date = $request->event_date;
                
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            else
            {
                // $dateRange = $request->daterange;
                // [$startDate, $endDate] = explode(' - ', $dateRange);
                // // dd($startDate);
                $startDate = $request->startDate;
                $endDate = $request->endDate;

                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'feedback_image' => $feedback_image,
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
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$users->name}!, You have a new pending approval request!"
                ];
                Mail::to($email)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }

        }
        elseif($role === 'professor')
        {
            $professor = Prof::where('user_id',$request->user_id)->first();
            // dd($professor);
            $adaf = User::where('role','atty')->first();
            $adafEmail = $adaf->email;
            $inputType = $request->dateType;
            // dd($adafEmail);
            // dd($professor);
            $target_dept = $professor->department_id;
            // dd($target_dept);

            if ($inputType === 'wholeWeek') {
                $weekDate = $request->selectedDate;
                $startDate = $weekDate;
                $endDate = Carbon::parse($weekDate)->addDays(6)->toDateString();

                $request->validate([    
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                $feedback_image = $request->feedback_qr_code;
                
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
    
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            elseif ($inputType === 'withinDay') {
                // Handle whole_day or within_day events
                $date = $request->event_date;
                $start_time = $request->startTime;
                $end_time = $request->endTime;
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                $feedback_image = $request->feedback_qr_code;
    
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }   
            else if ($inputType === 'wholeDay'){
                //whole day
                $date = $request->event_date;
                
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            else
            {
                // $dateRange = $request->daterange;
                // [$startDate, $endDate] = explode(' - ', $dateRange);
                // // dd($startDate);
                $startDate = $request->startDate;
                $endDate = $request->endDate;

                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaf->name}!, You have a new pending approval request!"
                ];
                Mail::to($adafEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
        }
        elseif($role === 'staff')
        {
            $staff = Staff::where('user_id',$request->user_id)->first();

            $target_dept = $staff->department_id;

            $adaa = User::where('role','adaa')->first();

            $adaaEmail = $adaa->email;
            // $target_org = $staff->organization;

            if ($inputType === 'wholeWeek') {
                $weekDate = $request->selectedDate;
                $startDate = $weekDate;
                $endDate = Carbon::parse($weekDate)->addDays(6)->toDateString();

                $request->validate([    
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                $feedback_image = $request->feedback_qr_code;
                
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
    
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            elseif ($inputType === 'withinDay') {
                // Handle whole_day or within_day events
                $date = $request->event_date;
                $start_time = $request->startTime;
                $end_time = $request->endTime;
    
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                $feedback_image = $request->feedback_qr_code;
    
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }   
            else if ($inputType === 'wholeDay'){
                //whole day
                $date = $request->event_date;
                
                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaa)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
            else
            {
                // $dateRange = $request->daterange;
                // [$startDate, $endDate] = explode(' - ', $dateRange);
                // // dd($startDate);
                $startDate = $request->startDate;
                $endDate = $request->endDate;

                $request->validate([
                    'request_letter' => 'required|mimes:pdf|max:2048', // PDF file validation
                ]);
        
                $files = $request->file('request_letter');
                $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
                // $venues->save();
                Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                // $request->validate([
                //     'feedback_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Image file validation
                // ]);
        
                // $files = $request->file('feedback_image');
                $feedback_image = $request->feedback_qr_code;
                // $venues->save();
                // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
                
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
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
                        'event_letter' => $event_letter,
                        'feedback_image' => $feedback_image,
                        'whole_week' => false,
                        'status' => 'PENDING',
                        'color' => '#D6AD60',
                        'created_at' => now()
                    ]);
                }
                
                $data = [
                    "subject" => "Calendash Pending Request",
                    "body" => "Hello {$adaa->name}!, You have a new pending approval request!"
                ];
                Mail::to($adaaEmail)->send(new MailNotify($data));
                return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
            }
        }
        // return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
    }

    public function myEventsMobile(Request $request)
    {
        //
        $user = User::where('id',$request->user_id)->first();
        // $role = $user->role;
        // $inputType = $request->dateType;
        // $events = Event::join('venues','venues.id','events.venue_id')
        //                 ->join('rooms',)
        //                 ->where('user_id',$user->id)->get();

        $events = Event::leftjoin('venues','venues.id','events.venue_id')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->select('organizations.organization',
                                'departments.department',
                                'events.*',
                                DB::raw('CASE
                                    WHEN rooms.name IS NULL THEN venues.name
                                    ELSE rooms.name END AS venueName'),
                                'events.id')
                        ->orderByDesc('events.id')
                        ->where('user_id',$user->id)
                        ->get();
        return response()->json($events);
 
    }

    public function myEventStatusMobile(Request $request, String $id)
    {
        $events = Event::find($id);
        $section = Event::leftjoin('students','students.user_id','events.user_id')
                        ->where('events.id',$id)
                        ->select('events.id',
                                'students.section_id')
                        ->first();
        $user = User::where('id',$events->user_id)->first();
        $role = $user->role;
        $venues = Venue::find($events->venue_id);
        $rooms = Room::find($events->room_id);

        $eventType = Event::leftjoin('venues', 'events.venue_id', '=', 'venues.id')
                            ->leftJoin('rooms', 'events.room_id', '=', 'rooms.id')
                            ->where('events.id', $id)
                            ->select('venues.name as venue_name', 'rooms.name as room_name',
                                \DB::raw('CASE
                                            WHEN rooms.id IS NOT NULL THEN "Room"
                                            ELSE "Venue"
                                        END AS event_type')
                            )
                            ->first();
        // dd($eventType->event_type);
        $place = $eventType->event_type;
        // dd($role);
        if ($role === 'student')
        {
            $orgID = $events->target_org;
            $deptID = $events->target_dept;
            $sectID = $section->section_id;
        
            $official_org = Official::where('organization_id',$orgID)->first();
            $official_dept = Official::where('department_id',$deptID)->first();
            $official_section = Official::where('section_id',$sectID)->first();
            // dd($official_dept);

            $official_user = User::where('id',$official_org->user_id)->first(); // fetch the name of org adviser
            $dept_user = User::where('id',$official_dept->user_id)->first();    // fetch the name of department head
            $sect_user = User::where('id',$official_section->user_id)->first(); // fetch the name of section head
        
            $rejectedBy = User::where('id',$events->rejected_by)->first();

            $orgAdviser = $events->org_adviser;
            $secHead = $events->sect_head;
            $depHead = $events->dept_head;
            $osa = $events->osa;
            $adaa = $events->adaa;
            $atty = $events->atty;
            $cd = $events->campus_director;

            $message = 'Your Request is on Process';
            // dd($events->status);
            if($place === 'Room')
            {
                // dd($place);
                if ($orgAdviser === null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                {
                    $message = 'Your Request is on process...';
                            return response()->json([
                                                    ["pendingMsg" => $message],
                                                ]);
                }
                elseif ($orgAdviser !== null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                {
                    // $appSecDate = $events->approved_sec_head_at;
                    $classes = [
                        [
                            'pendingMsg' => 'Your Request is on process...',
                            'dateApproved' => $events->created_at,
                        ],
                        [
                            'dateApproved' => $events->approved_org_adviser_at,
                            'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            'pendingMsg' => 'Waiting for Approval of Section Head of IT',
                            'bgColor' => '#E0FFFF',
                        ],
                        // Add more classes as needed
                    ];

                    return response()->json($classes);
                }
                elseif ($orgAdviser !== null && $secHead !== null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                {
                    $classes = [
                        [
                            'pendingMsg' => 'Your Request is on process...',
                            'dateApproved' => $events->created_at,
                        ],
                        [
                            'dateApproved' => $events->approved_org_adviser_at,
                            'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            'bgColor' => '#E0FFFF',
                        ],
                        [
                            'dateApproved' => $events->approved_sec_head_at,
                            'approvalMessage' => 'APPROVED BY SECTION HEAD OF IT',
                            'pendingMsg' => 'Officially Approved!',
                            'bgColor' => '#E6E6FA',
                        ],
                        // Add more classes as needed
                    ];

                    return response()->json($classes);
                }
            }
            else
            {
                if($venues->name ==='IT Auditorium')
                {
                    if ($orgAdviser === null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                    {
                        $message = 'Your Request is on process...';
                            return response()->json([
                                                    ["pendingMsg" => $message],
                                                ]);
                    }
                    elseif ($orgAdviser !== null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'pendingMsg' => 'Waiting for Approval of Section Head',
                                'bgColor' => '#E0FFFF',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'bgColor' => '#E0FFFF',
                            ],
                            [
                                'dateApproved' => $events->approved_sec_head_at,
                                'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                'pendingMsg' => 'Waiting for Approval of Department Head',
                                'bgColor' => '#E6E6FA',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa === null && $adaa === null && $atty === null) 
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'bgColor' => '#E0FFFF',
                            ],
                            [
                                'dateApproved' => $events->approved_sec_head_at,
                                'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_dept_head_at,
                                'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                'pendingMsg' => 'Waiting for Approval of OSA',
                                'bgColor' => '#E6E6FA',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa === null && $atty === null) 
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'bgColor' => '#E0FFFF',
                            ],
                            [
                                'dateApproved' => $events->approved_sec_head_at,
                                'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_dept_head_at,
                                'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_osa_at,
                                'approvalMessage' => 'APPROVED BY OSA',
                                'pendingMsg' => 'Waiting for Approval of ADAA',
                                'bgColor' => '#E6E6FA',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $atty === null) 
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'bgColor' => '#E0FFFF',
                            ],
                            [
                                'dateApproved' => $events->approved_sec_head_at,
                                'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_dept_head_at,
                                'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_osa_at,
                                'approvalMessage' => 'APPROVED BY OSA',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_adaa_at,
                                'approvalMessage' => 'APPROVED BY ADAA',
                                'pendingMsg' => 'Waiting for Approval of ADAF/Atty.',
                                'bgColor' => '#E6E6FA',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $atty !== null) 
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'bgColor' => '#E0FFFF',
                            ],
                            [
                                'dateApproved' => $events->approved_sec_head_at,
                                'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_dept_head_at,
                                'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_osa_at,
                                'approvalMessage' => 'APPROVED BY OSA',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_adaa_at,
                                'approvalMessage' => 'APPROVED BY ADAA',
                                'bgColor' => '#E6E6FA',
                            ],
                            [
                                'dateApproved' => $events->approved_atty_at,
                                'approvalMessage' => 'APPROVED BY ADAF/Atty.',
                                'pendingMsg' => 'APPROVED',
                                'bgColor' => '#E6E6FA',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                }
                else
                {
                    if ($events->status === 'PENDING' || $events->status ==='APPROVED') 
                    {
                        if ($orgAdviser === null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $cd === null)
                        {
                            $message = 'Your Request is on process...';
                            return response()->json([
                                                    ["pendingMsg" => $message],
                                                ]);
                        }
                        elseif ($orgAdviser !== null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $cd === null)
                        {
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'pendingMsg' => 'Waiting for Approval of Section Head',
                                    'bgColor' => '#E0FFFF',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead === null && $osa === null && $adaa === null && $cd === null)
                        {
                            // $approvalDates = [
                            //     $events->approved_org_adviser_at,
                            //     $events->approved_sec_head_at,
                            // ];
                            
                            // $approvalMessage = [
                            //     'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            //     'APPROVED BY SECTION HEAD',
                            // ];

                            // $pendingMsg = 'Waiting for Approval of Department Head';
                            // // return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);

                            // return response()->json([
                            //     ["message" => $message],
                            //     ["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200],
                            //     ["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200],
                            // ]);

                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'pendingMsg' => 'Waiting for Approval of Department Head',
                                    'bgColor' => '#E6E6FA',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa === null && $adaa === null && $cd === null) 
                        {
                            // $approvalDates = [
                            //     $events->approved_org_adviser_at,
                            //     $events->approved_sec_head_at, 
                            //     $events->approved_dept_head_at,
                            // ];
                            
                            // $approvalMessage = [
                            //     'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            //     'APPROVED BY SECTION HEAD',
                            //     'APPROVED BY DEPARTMENT HEAD',
                            // ];
                            // $pendingMsg = 'Waiting for Approval OSA';
                            // return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);


                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'pendingMsg' => 'Waiting for Approval of OSA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa === null && $cd === null) 
                        {
                            // $approvalDates = [
                            //     $events->approved_org_adviser_at,
                            //     $events->approved_sec_head_at, 
                            //     $events->approved_dept_head_at,
                            //     $events->approved_osa_at,
                            // ];
                            
                            // $approvalMessage = [
                            //     'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            //     'APPROVED BY SECTION HEAD',
                            //     'APPROVED BY DEPARTMENT HEAD',
                            //     'APPROVED BY OSA',
                            // ];
                            // $pendingMsg = 'Waiting for Approval of ADAA';
                            // return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);

                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_osa_at,
                                    'approvalMessage' => 'APPROVED BY OSA',
                                    'pendingMsg' => 'Waiting for Approval of ADAA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);

                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $cd === null) 
                        {
                            // $approvalDates = [
                            //     $events->approved_org_adviser_at,
                            //     $events->approved_sec_head_at, 
                            //     $events->approved_dept_head_at,
                            //     $events->approved_osa_at,
                            //     $events->approved_adaa_at,
                            // ];
                        
                            // $approvalMessage = [
                            //     'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            //     'APPROVED BY SECTION HEAD',
                            //     'APPROVED BY DEPARTMENT HEAD',
                            //     'APPROVED BY OSA',
                            //     'APPROVED BY ADAA',
                            // ];
                            // $pendingMsg = 'Waiting for Approval of Campus Director';
                            // return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);

                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_osa_at,
                                    'approvalMessage' => 'APPROVED BY OSA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_adaa_at,
                                    'approvalMessage' => 'APPROVED BY ADAA',
                                    'pendingMsg' => 'Waiting for Approval of Campus Director',
                                    'bgColor' => '#E6E6FA',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $cd !== null) 
                        {
                            // $approvalDates = [
                            //     $events->approved_org_adviser_at,
                            //     $events->approved_sec_head_at, 
                            //     $events->approved_dept_head_at,
                            //     $events->approved_osa_at,
                            //     $events->approved_adaa_at,
                            //     $events->approved_campus_director_at,
                            // ];
                        
                            // $approvalMessage = [
                            //     'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            //     'APPROVED BY SECTION HEAD',
                            //     'APPROVED BY DEPARTMENT HEAD',
                            //     'APPROVED BY OSA',
                            //     'APPROVED BY ADAA',
                            //     'APPROVED BY CAMPUS DIRECTOR',
                            // ];
                            
                            // $pendingMsg = 'APPROVED';
                            // return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);

                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_osa_at,
                                    'approvalMessage' => 'APPROVED BY OSA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_adaa_at,
                                    'approvalMessage' => 'APPROVED BY ADAA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_campus_director_at,
                                    'approvalMessage' => 'APPROVED BY CAMPUS DIRECTOR',
                                    'pendingMsg' => 'APPROVED',
                                    'bgColor' => '#E6E6FA',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                    }
                    else if($events->status === 'REJECTED')
                    {
                        // dd($events->remarks_sec_head);
                        if ($events->remarks_org_adviser !== null)
                        {
                            // $message = 'Your Request is Rejected By Organization Adviser';
                            // // return response()->json(["msg" => $message, "status" => 200]);
                            // $rejectedDates = [
                            //     $events->updated_at,
                            // ];
                        
                            // $approvalMessage = [
                            //     'REJECTED BY ORGANIZATION ADVISER: ' . $rejectedBy->name. '<br>Reason: ' . $events->remarks_org_adviser,
                            // ];
                            // $pendingMsg = 'REJECTED';
                            // return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_org_adviser,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);

                        }
                        else if($events->remarks_sec_head !== null){
                            // $message = 'Your Request is Rejected By Section Head';
                            // // return response()->json(["msg" => $message, "status" => 200]);
                            // $rejectedDates = [
                            //     $events->approved_org_adviser_at,
                            //     $events->updated_at,
                            // ];
                        
                            // $approvalMessage = [
                            //     'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            //     'REJECTED BY SECTION HEAD: ' . $rejectedBy->name . '<br>Reason: ' . $events->remarks_sec_head,
                            // ];
                            // $pendingMsg = 'REJECTED';
                            // return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY SECTION HEAD ADVISER: ' . $official_user->name,
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_sec_head,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        else if($events->remarks_dept_head !== null){
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY DEPARTMENT HEAD',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_dept_head,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        else if($events->remarks_osa !== null){
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY OSA',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_osa,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }   
                        else if($events->remarks_adaa !== null){
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_osa_at,
                                    'approvalMessage' => 'APPROVED BY OSA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY ADAA',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_adaa,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        else if($events->remarks_atty !== null){
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_osa_at,
                                    'approvalMessage' => 'APPROVED BY OSA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_adaa_at,
                                    'approvalMessage' => 'APPROVED BY ADAA',
                                    'pendingMsg' => 'Waiting for Approval of Campus Director',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY ADAF',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_atty,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        else if($events->remarks_campus_director !== null){
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY SECTION HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_dept_head_at,
                                    'approvalMessage' => 'APPROVED BY DEPARTMENT HEAD',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_osa_at,
                                    'approvalMessage' => 'APPROVED BY OSA',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->approved_adaa_at,
                                    'approvalMessage' => 'APPROVED BY ADAA',
                                    'pendingMsg' => 'Waiting for Approval of Campus Director',
                                    'bgColor' => '#E6E6FA',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY CAMPUS DIRECTOR',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_campus_director,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        
                    }
                    
                }
            }
        }
        elseif ($role === 'professor')
        {
            $sec_head = $events->sect_head;
            $adaa = $events->adaa;
            $atty = $events->atty;
            $cd = $events->campus_director;

            $message = 'Your Request is on Process';
            // dd($events->status);
            if($place === 'Room')
            {
                // dd($place);
                if ($sec_head === null)
                {
                    $message = 'Your Request is on process...';
                            return response()->json([
                                                    ["pendingMsg" => $message],
                                                ]);
                }
                elseif ($sec_head !== null)
                {
                    // $appSecDate = $events->approved_sec_head_at;
                    $classes = [
                        [
                            'pendingMsg' => 'Your Request is on process...',
                            'dateApproved' => $events->created_at,
                        ],
                        [
                            'dateApproved' => $events->approved_org_adviser_at,
                            'approvalMessage' => 'APPROVED BY IT SECTION HEAD',
                            'pendingMsg' => 'Officially Approved!',
                            'bgColor' => '#E0FFFF',
                        ],
                        // Add more classes as needed
                    ];

                    return response()->json($classes);
                }

            }
            else
            {
                if($venues->name ==='IT Auditorium')
                {
                    if ($atty === null)
                    {
                        $message = 'Your Request is on process...';
                            return response()->json([
                                                    ["pendingMsg" => $message],
                                                ]);
                    }
                    elseif ($atty !== null)
                    {
                        $classes = [
                            [
                                'pendingMsg' => 'Your Request is on process...',
                                'dateApproved' => $events->created_at,
                            ],
                            [
                                'dateApproved' => $events->approved_org_adviser_at,
                                'approvalMessage' => 'APPROVED BY ADAF: ',
                                'pendingMsg' => 'Officially Approved!',
                                'bgColor' => '#E0FFFF',
                            ],
                            // Add more classes as needed
                        ];

                        return response()->json($classes);
                    }
                }
                else
                {
                    if ($events->status === 'PENDING' || $events->status ==='APPROVED') 
                    {
                        if ($atty === null && $cd === null)
                        {
                            $message = 'Your Request is on process...';
                            return response()->json([
                                                    ["pendingMsg" => $message],
                                                ]);
                        }
                        elseif ($atty !== null && $cd === null)
                        {
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_atty_at,
                                    'approvalMessage' => 'APPROVED BY ADAF',
                                    'pendingMsg' => 'Waiting for Campus Director',
                                    'bgColor' => '#E0FFFF',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                        elseif ($atty !== null && $cd !== null)
                        {
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_atty_at,
                                    'approvalMessage' => 'APPROVED BY ADAF',
                                    'pendingMsg' => 'Waiting for Campus Director',
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->approved_sec_head_at,
                                    'approvalMessage' => 'APPROVED BY CAMPUS DIRECTOR',
                                    'pendingMsg' => 'Officially Approved!',
                                    'bgColor' => '#E6E6FA',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                    }
                    else if($events->status === 'REJECTED')
                    {
                        // dd($events->remarks_sec_head);
                        if ($events->remarks_atty !== null)
                        {
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY ADAF',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_atty,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);

                        }
                        else if($events->remarks_campus_director !== null){
                            $classes = [
                                [
                                    'pendingMsg' => 'Your Request is on process...',
                                    'dateApproved' => $events->created_at,
                                ],
                                [
                                    'dateApproved' => $events->approved_org_adviser_at,
                                    'approvalMessage' => 'APPROVED BY ADAF',
                                    'bgColor' => '#E0FFFF',
                                ],
                                [
                                    'dateApproved' => $events->updated_at,
                                    'approvalMessage' => 'REJECTED BY CAMPUS DIRECTOR',
                                    'pendingMsg' => 'Remarks: ' .$events->remarks_campus_director,
                                    'bgColor' => '#D6AD60',
                                ],
                                // Add more classes as needed
                            ];

                            return response()->json($classes);
                        }
                    }
                    
                }
            }
        }   
        elseif ($role === 'staff')
        {
            $adaa = $events->adaa;
            $cd = $events->campus_director;
            $sec_head = $events->sect_head;
            $message = 'Your Request is on Process';
            // dd($events->status);
            if($place === 'Room')
            {
                if ($events->status === 'PENDING' || $events->status ==='APPROVED') 
                {
                    if ($sec_head === null){
                        $message = 'Waiting for approval of section head of IT';
                        return response()->json(["pendingMsg" => $message, "status" => 200]);
                    }
                    else{
                        $approvalDates = [
                            $events->approved_sec_head_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY SECTION HEAD OF IT',
                        ];
                        $pendingMsg = 'APPROVED';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }

                }
                else if($events->status === 'REJECTED')
                {
                    $message = 'Your Request is Rejected By ADAF';
                    // return response()->json(["msg" => $message, "status" => 200]);
                    $rejectedDates = [
                        $events->updated_at,
                    ];
                
                    $approvalMessage = [
                        'REJECTED BY ADAF',
                    ];
                    $pendingMsg = 'REJECTED';
                    return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                }
            }
            else
            {
                if ($events->status === 'PENDING' || $events->status ==='APPROVED') 
                {
                    if ($adaa === null && $cd === null)
                    {
                        $message = 'Your Request is on Process';
                        return response()->json(["msg" => $message, "status" => 200]);
                    }
                    elseif ($adaa !== null && $cd === null) 
                    {
                        $approvalDates = [
                            $events->approved_adaa_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ADAA',
                        ];
                        $pendingMsg = 'Waiting for Approval of Campus Director';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    elseif ($adaa !== null && $cd !== null) 
                    {
                        $approvalDates = [
                            $events->approved_adaa_at,
                            $events->approved_campus_director_at,
                        ];
                    
                        $approvalMessage = [
                            'APPROVED BY ADAA',
                            'APPROVED BY CAMPUS DIRECTOR',
                        ];
                        
                        $pendingMsg = 'APPROVED';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                }
                else if($events->status === 'REJECTED')
                {
                    // dd($events->remarks_sec_head);
                    if ($events->remarks_adaa !== null)
                    {
                        $message = 'Your Request is Rejected By ADAA';
                        // return response()->json(["msg" => $message, "status" => 200]);
                        $rejectedDates = [
                            $events->updated_at,
                        ];
                    
                        $approvalMessage = [
                            'REJECTED BY ADAA',
                        ];
                        $pendingMsg = 'REJECTED';
                        return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    else if($events->remarks_campus_director !== null){
                        $message = 'Your Request is Rejected By Campus Director';
                        // return response()->json(["msg" => $message, "status" => 200]);
                        $rejectedDates = [
                            $events->approved_adaa_at,
                            $events->updated_at,
                        ];
                    
                        $approvalMessage = [
                            'APPROVED BY ADAA ',
                            'REJECTED BY CAMPUS DIRECTOR ',
                        ];
                        $pendingMsg = 'REJECTED';
                        return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                }
            }
        }
        else
        {

        }   
    }
}
