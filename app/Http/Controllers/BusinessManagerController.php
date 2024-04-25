<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingUser;
use App\Models\Venue;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use View;
use Auth;
use App\Models\Event;
use App\Models\OutsideEvent;
use App\Models\Official;
use Illuminate\Support\Facades\Hash;
use DB;

class BusinessManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //BUSINESS MANAGER
        $pending = Event::join('venues','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->leftjoin('outside_events','outside_events.event_id','events.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->where('users.role','outsider')
                        ->where('events.status','PENDING')
                        ->whereNull('outside_events.event_id')
                        ->select('events.event_name',
                                'venues.name',
                                'events.type',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.status',
                                'users.name as eventOrganizer',
                                'events.id')
                        ->get();
        // dd($pending);
        return view('bm.index',compact('pending'));
    }
    
    public function waitingForReceipt()
    {
        $pending = Event::join('venues','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->leftjoin('outside_events','outside_events.event_id','events.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->where('users.role','outsider')
                        ->whereNotNull('outside_events.event_id')
                        ->where('outside_events.status','PENDING')
                        ->select('events.event_name',
                                'venues.name',
                                'events.type',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.status',
                                'users.name as eventOrganizer',
                                'events.receipt_image',
                                'events.id')
                        ->get();
        // dd($pending);
        return view('bm.waiting',compact('pending'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $venues = Venue::orderBy('id')->get();
        $rooms = Room::orderBy('id')->get();
        // dd($rooms)
        // dd($rooms)
        // $departments = 
        // return response()->json($venues);
        return view('bm.create',compact('venues','rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $inputType = $request->input('event_typeOutsider');
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
                    'user_id' => $request->user_idOutsider,
                    'event_name' => $request->eventNameOutsider,
                    'description' => $request->eventDescOutsider,
                    'type' => 'whole_week',
                    'venue_id' => $request->event_venueOutsider,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '00:00:00',
                    'end_time' => '00:00:00',
                    'whole_week' => true,
                    'participants' => $request->numParticipantsOutsider,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60',
                    'created_at' => now()
                ]);

            // $data = [
            //     "subject" => "Calendash Pending Request",
            //     "body" => "Hello {$user->name}!, You have a new pending approval request!"
            // ];
            // Mail::to($email)->send(new MailNotify($data));
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
        elseif ($inputType === 'withinDay') {
            // Handle whole_day or within_day events
            $date = $request->event_date_withinDayOutsider;
            $start_time = $request->start_time_withinDayOutsider;
            $end_time = $request->end_time_withinDayOutsider;

            $files = $request->file('request_letter');
            $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                Event::create([
                    'user_id' => $request->user_idOutsider,
                    'event_name' => $request->eventNameOutsider,
                    'description' => $request->eventDescOutsider,
                    'type' => 'within_day',
                    'venue_id' => $request->event_venueOutsider,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'participants' => $request->numParticipantsOutsider,
                    'whole_week' => false,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60',
                    'created_at' => now()
                ]);
            
            // $data = [
            //     "subject" => "Calendash Pending Request",
            //     "body" => "Hello {$user->name}!, You have a new pending approval request!"
            // ];
            // Mail::to($email)->send(new MailNotify($data));
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }   
        else if ($inputType === 'wholeDay'){
            //whole day
            $date = $request->event_date_wholeDayOutsider;

            $files = $request->file('request_letter');
            $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
                Event::create([
                    'user_id' => $request->user_idOutsider,
                    'event_name' => $request->eventNameOutsider,
                    'description' => $request->eventDescOutsider,
                    'type' => 'whole_day',
                    'venue_id' => $request->event_venueOutsider,
                    'start_date' => $date,
                    'end_date' => $date,
                    'start_time' => '05:00:00',
                    'end_time' => '21:00:00',
                    'participants' => $request->numParticipantsOutsider,
                    'whole_week' => false,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60',
                    'created_at' => now()
                ]);
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
        else
        {
            $dateRange = $request->daterangeOutsider;
            [$startDate, $endDate] = explode(' - ', $dateRange);
            // dd($startDate);
            $files = $request->file('request_letter');
            $event_letter = 'pdf/'.time().'-'.$files->getClientOriginalName();
            // $venues->save();
            Storage::put('public/pdf/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

                Event::create([
                    'user_id' => $request->user_idOutsider,
                    'event_name' => $request->eventNameOutsider,
                    'description' => $request->eventDescOutsider,
                    'type' => 'whole_day',
                    'venue_id' => $request->event_venueOutsider,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => '05:00:00',
                    'end_time' => '21:00:00',
                    'participants' => $request->numParticipantsOutsider,
                    'whole_week' => false,
                    'event_letter' => $event_letter,
                    'status' => 'PENDING',
                    'color' => '#D6AD60',
                    'created_at' => now()
                ]);
        
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showPendingOutsider()
    {
        //
        $pendingUsers = PendingUser::leftJoin('users', 'pending_users.user_id', 'users.id')
                                    ->leftJoin('organizations', 'pending_users.organization_id', 'organizations.id')
                                    ->leftJoin('departments', 'pending_users.department_id', 'departments.id')
                                    ->leftJoin('sections', 'pending_users.section_id', 'sections.id')
                                    ->select('pending_users.user_id','pending_users.tupID','pending_users.lastname','pending_users.firstname','organizations.organization','departments.department','sections.section','pending_users.role','users.email_verified_at','users.email')
                                    ->where('pending_users.role', '=', 'outsider')
                                    ->orderByDesc('pending_users.id')
                                    ->paginate(5);
                                    
        return view('bm.outsider', compact('pendingUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $events = Event::find($id);
        $venues = Venue::find($events->venue_id);
        $rooms = Room::find($events->room_id);
        $users = User::where('id',$events->user_id)->first();
        // dd($events);
        return response()->json(["events" => $events, "venues" => $venues, "users" => $users, "status" => 200]);
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
    
    public function getAllOutsideUser()
    {
        $pendingUsers = PendingUser::leftJoin('users', 'pending_users.user_id', 'users.id')
                                    ->leftJoin('organizations', 'pending_users.organization_id', 'organizations.id')
                                    ->leftJoin('departments', 'pending_users.department_id', 'departments.id')
                                    ->leftJoin('sections', 'pending_users.section_id', 'sections.id')
                                    ->select('pending_users.user_id','pending_users.tupID','pending_users.lastname','pending_users.firstname','organizations.organization','departments.department','sections.section','pending_users.role','users.email_verified_at','users.email')
                                    ->orderByDesc('pending_users.id')
                                    ->where('pending_users.role', 'outsider')
                                    ->paginate(5);

        return view('bm.outsider', compact('pendingUsers'));
    }
    public function statusOutsiderEvents()
    {
        $eventForUser = Event::orderByDesc('id')->where('user_id', Auth::id())
                                            ->where('status','PENDING')                                    
                                            ->get();
        
        // dd($eventForUser);
        return View::make('bm.myEvents', compact('eventForUser'));
    }

    public function storeBusinessManager(Request $request, String $id)
    {
        //
        $amount = $request->input('amount');
        $event_id = $id;
        $user_id = $request->input('key2');
        $password = $request->input('key1');
        
        $hashedPassword = Hash::make($password);
        $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
        $hashOfOfficial = $hashedPasswordFromDatabase->hash;

        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
            OutsideEvent::create([
                'event_id' => $event_id,
                'amount' => $amount,
                'status' => "PENDING",
                'created_at' => now()
            ]);
            return response()->json(["success" => "Event Created Successfully.", "status" => 200]);
        } else {
            // Passwords do not match, handle invalid password
            // echo "Password Does Not Match";
            return response()->json(['error' => 'Invalid passcode'], 422);
        }

    }
    
    public function checkStatusOutsider(Request $request, String $id)
    {
        
        $hasOutsideEvent = DB::table('outside_events')->where('event_id', $id)->exists();
        // dd($hasOutsideEvent);
        $event = Event::find($id);
        if (!$hasOutsideEvent) {
            //not existing on outside_event Table;
            $message = 'Your Request is on Process';
            return response()->json(["pendingMsg" => $message, "status" => 200]);
        }
        else if ($hasOutsideEvent && $event->receipt_image !== null && $event->status === 'APPROVED')
        {
            //existing and hindi pa bayad
            $events = Event::find($id);
            $outside = OutsideEvent::where('event_id',$id)->first();
            // dd($outside);
            $receipt = $events->receipt_image;
            $amount = $outside->amount;

            $approvalDates = [
                $outside->created_at,
                $outside->updated_at,
                $outside->approved_at,
            ];
            
            $approvalMessage = [
                'The amount to be paid is: ₱'.$amount,
                'Already Paid',
                'APPROVED',
            ];
            $pendingMsg = 'APPROVED';
            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
        }
        else if ($hasOutsideEvent && $event->receipt_image !== null)
        {
            //existing and hindi pa bayad
            $events = Event::find($id);
            $outside = OutsideEvent::where('event_id',$id)->first();
            // dd($outside);
            $receipt = $events->receipt_image;
            $amount = $outside->amount;

            $approvalDates = [
                $outside->created_at,
                $outside->updated_at,
            ];
            
            $approvalMessage = [
                'The amount to be paid is: ₱'.$amount,
                'Already Paid',
            ];
            $pendingMsg = 'Your event has been appointed! <br> Waiting for business manager approval';
            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
        }
        else if ($hasOutsideEvent)
        {
            //existing and hindi pa bayad
            $events = Event::find($id);
            $outside = OutsideEvent::where('event_id',$id)->first();
            // dd($outside);
            $receipt = $events->receipt_image;
            $amount = $outside->amount;

            $approvalDates = [
                $outside->created_at,
            ];
            
            $approvalMessage = [
                'The amount to be paid is: ₱'.$amount,
            ];
            $pendingMsg = 'Waiting for Receipt Upload';
            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
        }
        
    }

    public function uploadReceipt(Request $request, String $id)
    {
        // Get the file from the request
        $file = $request->file('image');
        $files = $request->file('image');
        // Check if the file exists
        if ($file) {
            // Store the file
            $path = 'images/'.time().'-'.$files->getClientOriginalName();
            // $venues->image = 
            // Update the event with the receipt image path
            Event::where('id', $id)->update(['receipt_image' => $path]);
            OutsideEvent::where('event_id', $id)->update(['updated_at' => now()]);
            
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            return response()->json(['message' => 'Receipt uploaded successfully'], 200);
        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }
    }

    public function approveReceipt(Request $request, String $id)
    {
        // Get the file from the request
        Event::where('id', $id)->update(['status' => 'APPROVED', 'color' => '#31B4F2']);
        OutsideEvent::where('event_id', $id)->update(['status' => 'APPROVED', 'approved_at' => now()]);

        return response()->json(['message' => 'Event updated successfully'], 200);
    }

    public function rejectEvent(Request $request, String $id)
    {
        // Get the file from the request
        // $event = Event::where('id', $id)->first();
        // $outside_event = OutsideEvent::where('event_id',$id)->first();
        $reason = $request->input('key1');
        $userId = $request->input('key2');
        // dd($reason);
        Event::where('id', $id)->update(['status' => 'REJECTED', 'updated_at' => now(), 'remarks_business_manager' => $reason, 'rejected_by' => $userId]);
        // OutsideEvent::where('event_id', $id)->update(['status' => 'REJECTED', 'updated_at' => now(), 'reason' => $reason]);

        return response()->json(['message' => 'Event updated successfully', 'reason' => $reason], 200);
    }

    ///// rejected event for outsider
    public function rejectedEventsOutsider()
    {
        return view('outsider.myRejected');   
    }

    public function getAllRejectedEventsOutsider(Request $request, String $id)
    {
        $user_id = $id;
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('outside_events','outside_events.event_id','events.id')
                        ->leftjoin('venues','events.venue_id','venues.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->where('events.status','REJECTED')
                        ->where('events.user_id',$user_id)
                        ->select('events.status',
                                'events.event_name',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.type',
                                'venues.name as venueName',
                                'outside_events.updated_at as rejected_at',
                                'events.remarks_business_manager as reason',
                                'events.id')
                        ->get();
        return response()->json($pending);
    }

    ///// rejected event for Business Manager
    public function rejectedEventsBusinessManager()
    {
        return view('bm.myRejected');   
    }

    public function getAllRejectedEventsBusinessManager(String $id)
    {
        $user_id = $id;
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('outside_events','outside_events.event_id','events.id')
                        ->leftjoin('venues','events.venue_id','venues.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->where('events.status','REJECTED')
                        ->where('events.rejected_by',$user_id)
                        ->select('events.status',
                                'events.event_name',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.type',
                                'venues.name as venueName',
                                'events.updated_at as rejected_at',
                                'events.remarks_business_manager as reason',
                                'events.id')
                        ->get();
        return response()->json($pending);
    }

    ///// APPROVED event for outsider

    public function approvedEventsOutsider()
    {
        return view('outsider.myApproved');   
    }

    public function getAllApprovedEventsOutsider(Request $request, String $id)
    {
        $user_id = $id;
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('outside_events','outside_events.event_id','events.id')
                        ->leftjoin('venues','events.venue_id','venues.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->where('events.status','APPROVED')
                        ->where('events.user_id',$user_id)
                        ->select('events.status',
                                'events.event_name',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.type',
                                'venues.name as venueName',
                                'events.id')
                        ->get();
        return response()->json($pending);
    }


    ///// APPROVED event for BusinessManager

    public function approvedEventsBusinessManager()
    {
        return view('bm.myApproved');   
    }

    public function getAllApprovedEventsBusinessManager()
    {
        $pending = OutsideEvent::leftJoin('events as e1', 'e1.id', 'outside_events.event_id')
                                ->leftJoin('users', 'users.id', 'e1.user_id')
                                ->leftJoin('outside_events as oe', 'oe.event_id', 'e1.id')
                                ->leftJoin('venues', 'e1.venue_id', 'venues.id')
                                ->orderBy('e1.status')
                                ->orderByDesc('e1.id')
                                ->where('e1.status', 'APPROVED')
                                ->select('e1.status',
                                    'e1.event_name',
                                    'e1.start_date',
                                    'e1.end_date',
                                    'e1.start_time',
                                    'e1.end_time',
                                    'e1.type',
                                    'venues.name as venueName',
                                    'e1.id')
                                ->get();
        // dd($pending);
        return response()->json($pending);
    }



}
