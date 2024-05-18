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

        // $events = Event::orderBy('id')
        //         ->select('id','event_name as title','description','status','color')
        //         ->selectRaw('CONCAT(start_date, "T", start_time) as start')
        //         ->selectRaw('CONCAT(end_date, "T", end_time) as end')
        //         ->where('status', 'PENDING')
        //         ->orWhere('status', 'APPROVED')
        //         ->get();

        // return response()->json($events);


        $appointmentsResponse = file_get_contents('https://scheduler-backend-ruby.vercel.app/api/v1/appointments');
        $appointmentsData = json_decode($appointmentsResponse);
        $appointmentsArray = $appointmentsData->appointments;
        $filteredAppointments = collect($appointmentsArray)->filter(function ($appointment) {
            $allowedLocations = ['Gymnasium', 'Outdoor Court', 'Multipurpose Hall'];
            return in_array($appointment->location, $allowedLocations);
        });
        $appointments = $filteredAppointments->map(function ($appointment) {
            $color = $appointment->status === 'Pending' ? '#D6AD60' : ($appointment->status === 'Approved' ? '#31B4F2' : '#808080');
            return [
                'id' => $appointment->_id ?? null, // Assuming _id is the unique identifier for appointments in MongoDB
                'title' => $appointment->title ?? '',
                'description' => $appointment->description ?? '',
                'start' => $appointment->timeStart ?? '',
                'end' => $appointment->timeEnd ?? '',
                'color' => $color,
                'status' => $appointment->status,
                'venueName' => $appointment->location
            ];
        })->values();

            $events = Event::orderBy('events.id')
                            ->leftjoin('venues','venues.id','events.venue_id')
                            ->select('events.id','events.event_name as title','events.description','events.status','events.color','venues.name as venueName')
                            ->selectRaw('CONCAT(events.start_date, "T", events.start_time) as start')
                            ->selectRaw('CONCAT(events.end_date, "T", events.end_time) as end')
                            ->where('events.status', 'PENDING')
                            ->orWhere('events.status', 'APPROVED')
                            ->get();

            $appointmentsCollection = collect($appointments);
            $eventsCollection = collect($events);
            $mergedData = $appointmentsCollection->merge($eventsCollection);
            $mergedData = $mergedData->sortBy('id')->values();
            // dd($mergedData);

        return response()->json($mergedData);

    }

    public function myCalendarDetails(string $id)
    {
        $appointmentsResponse = file_get_contents('https://scheduler-backend-ruby.vercel.app/api/v1/appointments');
        $appointmentsData = json_decode($appointmentsResponse);
        $appointmentsArray = $appointmentsData->appointments;
        $filteredAppointments = collect($appointmentsArray)->filter(function ($appointment) {
            $allowedLocations = ['Gymnasium', 'Outdoor Court', 'Multipurpose Hall'];
            return in_array($appointment->location, $allowedLocations);
        });
        $appointments = $filteredAppointments->map(function ($appointment) {
            $color = $appointment->status === 'Pending' ? '#D6AD60' : ($appointment->status === 'Approved' ? '#31B4F2' : '#000000');
            $requesterParts = explode('-', $appointment->requester);
            $department = isset($requesterParts[1]) ? trim($requesterParts[1]) : 'N/A';
            
            return [
                'id' => $appointment->_id ?? null, // Assuming _id is the unique identifier for appointments in MongoDB
                'title' => $appointment->title ?? '',
                'description' => $appointment->description ?? '',
                'start_time' => $appointment->timeStart ?? '',
                'end_time' => $appointment->timeEnd ?? '',
                'color' => $color,
                'status' => $appointment->status,
                'organization' => "N/A",
                'department' => $department,
                'venueName' => $appointment->location,
                'role' => "student",
                'eventOrganizerName'=> $appointment->requester,
            ];
        })->values();
        // dd($appointments);
        // $events = Event::leftjoin('venues', 'events.venue_id','venues.id')
        //                 ->leftjoin('users','events.user_id','users.id')
        //                 ->leftjoin('departments', 'departments.id','events.target_dept')
        //                 ->leftjoin('organizations', 'organizations.id','events.target_org')
        //                 ->leftjoin('rooms', 'rooms.id','events.room_id')
        //                 ->select('organizations.organization',
        //                         'departments.department',
        //                         'events.status',
        //                         'events.event_name',
        //                         'events.start_time',
        //                         'events.end_time',
        //                         'venues.name as venueName',
        //                         'users.role',
        //                         'users.name as eventOrganizerName',
        //                         'rooms.name as roomName')
        //                 ->where('events.id', $id)
        //                 ->first();

        $events = Event::leftjoin('venues', 'events.venue_id','venues.id')
                        ->leftjoin('users','events.user_id','users.id')
                        ->leftjoin('departments', 'departments.id','events.target_dept')
                        ->leftjoin('organizations', 'organizations.id','events.target_org')
                        ->leftjoin('rooms', 'rooms.id','events.room_id')
                        ->select('organizations.organization',
                                'departments.department',
                                'events.status',
                                'events.event_name',
                                'events.start_time',
                                'events.end_time',
                                'events.start_date',
                                'events.end_date',
                                'users.role',
                                'users.name as eventOrganizerName',
                                'rooms.name as roomName',
                                'events.feedback_image',
                                'events.type',
                                DB::raw('CASE
                                WHEN rooms.name IS NULL THEN venues.name
                                ELSE rooms.name END AS venueName'),
                                'events.id')
                        ->get();
        // dd($events);

            $appointmentsCollection = collect($appointments);
            // dd($appointmentsCollection);
            $eventsCollection = collect($events);
            $mergedData = $appointmentsCollection->merge($eventsCollection);
            $mergedData = $mergedData->sortBy('id')->values();
            $item = $mergedData->firstWhere('id', $id);
            // $getSingleEvent = $mergedData->where()
            // dd($item);

        return response()->json($item);

    }

    public function myApiCalendar()
    {
        $events = Event::leftjoin('venues', 'events.venue_id','venues.id')
                        ->leftjoin('users','events.user_id','users.id')
                        ->leftjoin('departments', 'departments.id','events.target_dept')
                        ->leftjoin('organizations', 'organizations.id','events.target_org')
                        ->leftjoin('rooms', 'rooms.id','events.room_id')
                        ->select('organizations.organization',
                                'departments.department',
                                'events.status',
                                'events.event_name',
                                'events.start_time',
                                'events.end_time',
                                'venues.name as venueName',
                                'users.role',
                                'users.name as eventOrganizerName',
                                'venues.name')
                        ->selectRaw('CONCAT(start_date, "T", start_time) as start')
                        ->selectRaw('CONCAT(end_date, "T", end_time) as end')       
                        ->where('events.room_id', null)
                        ->where('status', 'PENDING')
                        ->orWhere('status', 'APPROVED')
                        ->get();
        
        // dd($events);

        return response()->json($events);

    }
    public function myApiCalendarMobile()
    {
        $events = Event::leftjoin('venues', 'events.venue_id','venues.id')
                        ->leftjoin('users','events.user_id','users.id')
                        ->leftjoin('departments', 'departments.id','events.target_dept')
                        ->leftjoin('organizations', 'organizations.id','events.target_org')
                        ->leftjoin('rooms', 'rooms.id','events.room_id')
                        ->select('organizations.organization',
                                'departments.department',
                                'events.status',
                                'events.description',
                                'events.event_name',
                                'events.start_time',
                                'events.end_time',
                                'users.role',
                                'events.id',
                                'events.feedback_image',
                                'users.name as eventOrganizerName',
                                DB::raw('CASE
                                WHEN rooms.name IS NULL THEN venues.name
                                ELSE rooms.name END AS venueName'))
                        ->selectRaw('CONCAT(start_date, "T", start_time) as start')
                        ->selectRaw('CONCAT(end_date, "T", end_time) as end')
                        ->where('status', 'PENDING')
                        ->orWhere('status', 'APPROVED')
                        ->get();
    
        $formattedEvents = [];
        $colors = ['lightblue', 'lightgreen', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow'];
        foreach ($events as $event) {
            $startDate = substr($event->start, 0, 10);
            $startTime = date('h:i A', strtotime(substr($event->start, 11, 5)));
            $endTime = date('h:i A', strtotime(substr($event->end, 11, 5)));
    
            $randomColor = $colors[array_rand($colors)];

            $formattedEvents[$startDate][] = [
                'event_name' => $event->event_name,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'description' => $event->description, // Assuming `description` field exists in your events table
                'venue' => $event->venueName,
                'eventOrganizer' => $event->eventOrganizerName,
                'backgroundColor' => $randomColor,
                'status' => $event->status,
                'id' => $event->id,
                'qr' => $event->feedback_image,
            ];
        }
    
        return response()->json($formattedEvents);
    }
    
}
