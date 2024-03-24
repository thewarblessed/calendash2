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
                'status' => $appointment->status
            ];
        })->values();

            $events = Event::orderBy('id')
                            ->select('id','event_name as title','description','status','color')
                            ->selectRaw('CONCAT(start_date, "T", start_time) as start')
                            ->selectRaw('CONCAT(end_date, "T", end_time) as end')
                            ->where('status', 'PENDING')
                            ->orWhere('status', 'APPROVED')
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
                'start' => $appointment->timeStart ?? '',
                'end' => $appointment->timeEnd ?? '',
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
                                'venues.name as venueName',
                                'users.role',
                                'users.name as eventOrganizerName',
                                'rooms.name as roomName',
                                'events.id')
                        ->get();
        // dd($events);

            $appointmentsCollection = collect($appointments);
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
}
