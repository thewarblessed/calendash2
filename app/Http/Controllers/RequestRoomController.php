<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Models\Official;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;
use App\Models\Room;
use Mail;
use App\Mail\MailNotify;

class RequestRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('officials.secHead.myRequestRoom');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getAllPendingRequestRooms()
    {
        //
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        // ->leftjoin('professors','professors.user_id','users.id')
                        // ->leftjoin('staffs','staffs.user_id','users.id')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->whereNotNull('room_id')
                        ->whereNotNull('org_adviser')
                        ->where('events.status','PENDING')
                        // ->orWhere('org_adviser', 'notnull')
                        ->select('organizations.organization',
                                'departments.department',
                                'events.status',
                                'events.event_name',
                                'events.start_date',
                                'events.end_date',
                                'events.start_time',
                                'events.end_time',
                                'events.type',
                                'rooms.name as roomName',
                                'users.role',
                                'events.id')
                        ->get();
        return response()->json($pending);
    }

    public function getSinglePendingRequestRooms($id)
    {
        //
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        // ->whereNotNull('org_adviser')
                        ->whereNotNull('room_id')
                        ->where('events.id', $id)
                        ->select('organizations.organization',
                                        'departments.department',
                                        'events.description',
                                        'events.status',
                                        'events.participants',
                                        'events.event_name',
                                        'events.start_date',
                                        'events.end_date',
                                        'events.start_time',
                                        'events.end_time',
                                        'events.type',
                                        'rooms.name as roomName',
                                        'events.id')
                        ->first();
        return response()->json(["rooms" => $pending]);
    }

    public function approveRooms(Request $request, String $id)
    {
        //
        $password = $request->input('key1');
        $user_id = $request->input('key2');
        $user = User::find($user_id);
        $role = $user->role;
        // dd($role);
        $event_id = $id;
        

        // $secHead = Official::where('section_id',) 

        $hashedPassword = Hash::make($password);
        $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
        $hashOfOfficial = $hashedPasswordFromDatabase->hash;

        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
            // Passwords match, proceed with authentication logic
            // echo "Password Match";
            $users = User::find($user_id);
            $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
            $events = Event::find($event_id);
            $requester = User::where('id',$events->user_id)->first();
            $events->sect_head = $officials->hash;
            $events->approved_sec_head_at = now();
            $events->status = "APPROVED";
            $events->color = "#31B4F2";
            $events->update();
            $data = [
                "subject" => "Calendash Approved Request",
                "body" => "Hello {$requester->name}!, Your request has been officially approved by the Section Head of IT!"
            ];
            Mail::to($requester->email)->send(new MailNotify($data));
            return response()->json(["message" => 'Request handled successfully']);
            // return response()->json(['message' => 'Request handled successfully']);
        } else {
            // Passwords do not match, handle invalid password
            // echo "Password Does Not Match";
            return response()->json(['error' => 'Invalid passcode'], 422);
        }
    }

    public function rejectRooms(Request $request, String $id)
    {
        //
        $password = $request->input('key1');
        $user_id = $request->input('key2');
        $reason = $request->input('key3');
        $user = User::find($user_id);
        // $role = $user->role;
        // dd($role);
        $event_id = $id;

        $hashedPassword = Hash::make($password);
        $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
        $hashOfOfficial = $hashedPasswordFromDatabase->hash;
        
        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
            // Passwords match, proceed with authentication logic
            // echo "Password Match";
            $users = User::find($user_id);
            $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
            $events = Event::find($event_id);
            $requester = User::where('id',$events->user_id)->first();
            $events->remarks_sec_head = $reason;
            $events->rejected_by = $user_id;
            $events->status = 'REJECTED';
            $events->updated_at = now(); // DATE OF REJECTION
            $events->update();
            $data = [
                "subject" => "Calendash Rejected Request",
                "body" => "Hello {$requester->name}!,\n\nWe regret to inform you that your request has been declined. 
                            Your Organization Adviser has reviewed your request and has decided not to approve it at this time.\n\nReason of rejection: ''{$reason}''."
                ];
            Mail::to($requester->email)->send(new MailNotify($data));
            return response()->json(["message" => 'Request handled successfully']);
            // return response()->json(['message' => 'Request handled successfully']);
        } else {
            // Passwords do not match, handle invalid password
            // echo "Password Does Not Match";
            return response()->json(['error' => 'Invalid passcode'], 422);
        }
    }

    public function getAllApproveRooms()
    {
        //
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        // ->whereNotNull('org_adviser')
                        ->whereNotNull('room_id')
                        ->where('events.status','APPROVED')
                        ->select('organizations.organization',
                                        'departments.department',
                                        'events.status',
                                        'events.event_name',
                                        'events.start_date',
                                        'events.end_date',
                                        'events.start_time',
                                        'events.end_time',
                                        'events.type',
                                        'rooms.name as roomName',
                                        'events.id')
                        ->get();
        return response()->json($pending);
    }

    public function approvedRoomsView()
    {
        return view('officials.secHead.myApprovedRoom');
    }

    public function rejectedRoomsView()
    {
        return view('officials.secHead.myRejectedRoom');
    }

    public function getAllRejectedRooms()
    {
        //
        $pending = Event::leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->leftjoin('rooms','rooms.id','events.room_id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        // ->whereNotNull('org_adviser')
                        ->whereNotNull('room_id')
                        ->where('events.status','REJECTED')
                        ->select('organizations.organization',
                                        'departments.department',
                                        'events.status',
                                        'events.event_name',
                                        'events.start_date',
                                        'events.end_date',
                                        'events.start_time',
                                        'events.end_time',
                                        'events.type',
                                        'rooms.name as roomName',
                                        'events.id')
                        ->get();
        return response()->json($pending);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
