<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Models\Official;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;
use App\Models\Room;
use View;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
// use Auth;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ROLE BASED TABLE
        //IF IT HALL OR NOT
        // $event
        // $pending = 
        // $events = Event::with('venues');
        // dd($pending);
        
        $user_role = Auth::user()->role;
        $user_id = Auth::user()->id;
        // dd($user_id);
        $official = Official::where('user_id',$user_id)->first();
        $org_id = $official->organization_id;
        $dept_id = $official->department_id;
        $section_id = $official->section_id;
        // dd($org_id);
        if($user_role === "org_adviser")
        {
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                            ->leftjoin('organizations','organizations.id','events.target_org')
                            ->leftjoin('departments','departments.id','events.target_dept')
                            ->leftjoin('rooms','rooms.id','events.room_id')
                            ->orderBy('events.status')
                            ->where('events.target_org', $org_id)
                            ->where('events.status','PENDING')
                            ->whereNull('org_adviser')
                            ->select('organizations.organization',
                                    'departments.department',
                                    'events.status',
                                    'events.event_name',
                                    'events.start_date',
                                    'events.end_date',
                                    'events.start_time',
                                    'events.end_time',
                                    'events.type',
                                    \DB::raw('CASE
                                                WHEN rooms.name IS NULL THEN venues.name
                                                ELSE rooms.name
                                            END AS venueName'),
                                    'events.id')
                            ->get();
            // dd($pending);
            $PenEvents = Event::orderBy('id')->whereNull('org_adviser')->get();
            // dd($PenEvents);
            return View::make('officials.secHead.request', compact('pending'));
        }   
        elseif($user_role === "section_head")
        {
            // dd($section_id)
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->leftjoin('organizations','organizations.id','events.target_org')
                        ->leftjoin('departments','departments.id','events.target_dept')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->whereNotNull('org_adviser')
                        ->whereNull('sect_head')
                        ->whereNull('room_id')
                        ->where('events.status','PENDING')
                        ->where('students.section_id', $section_id)
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
                                        'events.id')
                        ->get();
                    // dd($pending)l
            // $pending = Venue::join('events','events.venue_id','venues.id')->orderBy('events.status')->orderByDesc('events.id')->get();
            // $pending = Event::orderBy('id')->get();
            // $pending = Event::orderBy('id')->whereNotNull('org_adviser')->get();
            // dd($PenEvents);
            return View::make('officials.secHead.request', compact('pending'));
        }     
        elseif($user_role === "department_head")
        {
            // $pending = Venue::join('events','events.venue_id','venues.id')->orderBy('events.status')->orderByDesc('events.id')->get();
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                            ->leftjoin('users','users.id','events.user_id')
                            ->leftjoin('students','students.user_id','users.id')
                            ->leftjoin('organizations','organizations.id','events.target_org')
                            ->leftjoin('departments','departments.id','events.target_dept')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->whereNotNull('sect_head')
                            ->whereNull('dept_head')
                            ->where('events.status','PENDING')
                            ->where('events.target_dept',$dept_id)
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
                                        'events.id')
                            ->get();
            
            // $pending = Event::orderBy('id')->get();
            // $pending = Event::orderBy('id')->whereNotNull('sect_head')->get();
            return View::make('officials.secHead.request', compact('pending'));
        }
        elseif ($user_role === "osa")
        {
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                            ->leftjoin('users','users.id','events.user_id')
                            ->leftjoin('organizations','organizations.id','events.target_org')
                            ->leftjoin('departments','departments.id','events.target_dept')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->whereNotNull('dept_head')
                            ->whereNull('osa')
                            ->where('events.status','PENDING')
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
                                        'events.id')
                            ->get();
            // dd($pending);
            return View::make('officials.secHead.request', compact('pending'));
        }
        elseif ($user_role === "adaa")
        {
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                            ->leftjoin('users','users.id','events.user_id')
                            ->leftjoin('organizations','organizations.id','events.target_org')
                            ->leftjoin('departments','departments.id','events.target_dept')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->whereNotNull('osa')
                            ->whereNull('adaa')
                            ->where('events.status','PENDING')
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
                                        'events.id')
                            ->get();
            return View::make('officials.secHead.request', compact('pending'));
        }
        elseif ($user_role === "atty")
        {
            // $pendings = Event::leftjoin('venues','events.venue_id','venues.id')
            //                 ->leftjoin('users','users.id','events.user_id')
            //                 ->leftjoin('organizations','organizations.id','events.target_org')
            //                 ->leftjoin('departments','departments.id','events.target_dept')
            //                 ->orderBy('events.status')
            //                 ->orderByDesc('events.id')
            //                 ->whereNull('atty')
            //                 ->where('venues.name', 'IT Auditorium') 
            //                 ->whereNotNull('adaa')  
            //                 ->where('events.status','PENDING')
            //                 ->select('organizations.organization',
            //                             'departments.department',
            //                             'events.status',
            //                             'events.event_name',
            //                             'events.start_date',
            //                             'events.end_date',
            //                             'events.start_time',
            //                             'events.end_time',
            //                             'events.type',
            //                             'venues.name as venueName',
            //                             'events.id')
            //                 ->get();

            // $pending = Event::leftjoin('venues','events.venue_id','venues.id')
            //                 ->leftjoin('users','users.id','events.user_id')
            //                 ->leftjoin('organizations','organizations.id','events.target_org')
            //                 ->leftjoin('departments','departments.id','events.target_dept')
            //                 ->whereNull('atty')
            //                 ->whereNotNull('adaa')
            //                 // ->where('venues.name', 'IT Auditorium') 
            //                 ->where('events.status','PENDING')
            //                 ->where('users.role','professor')
            //                 ->select('organizations.organization',
            //                             'departments.department',
            //                             'events.status',
            //                             'events.event_name',
            //                             'events.start_date',
            //                             'events.end_date',
            //                             'events.start_time',
            //                             'events.end_time',
            //                             'events.type',
            //                             'venues.name as venueName',
            //                             'events.id')
            //                 ->get();
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                            ->leftjoin('users','users.id','events.user_id')
                            ->leftjoin('organizations','organizations.id','events.target_org')
                            ->leftjoin('departments','departments.id','events.target_dept')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->whereNull('atty')
                            ->whereNotNull('adaa')
                            ->where('events.status','PENDING')
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                        $query->where('users.role', 'professor');
                                })
                                ->orWhere(function ($query) {
                                        $query->where('venues.name', 'IT Auditorium');
                                });
                            })
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
                                        'events.id')
                            ->get();
            // $pending = Event::orderBy('id')->whereNotNull('adaa', null);
            return View::make('officials.secHead.request', compact('pending'));
        }
        elseif ($user_role === "campus_director")
        {
            // hindi dapat lalabas yung sa IT FUNCTION HALL na venue.
            $pending = Event::join('venues', 'venues.id', 'events.venue_id')
                            ->leftjoin('users','users.id','events.user_id')
                            ->leftjoin('organizations','organizations.id','events.target_org')
                            ->leftjoin('departments','departments.id','events.target_dept')
                            ->orderBy('events.id')
                            ->where('venues.name', '!=', 'IT Auditorium')
                            ->whereNotNull('adaa')
                            
                            ->whereNull('campus_director')
                            ->where('events.status','PENDING')
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
                                        'events.id')
                            ->get();
            return View::make('officials.secHead.request', compact('pending'));
        }
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
    public function store(Request $request, string $id)
    {
        // dd($request->);
        // GALING FRONTEND
        // $date = now();
        // $events = Event::find($id);
        // dd($date);
        // dd($request->all());
        $password = $request->input('key1');
        $user_id = $request->input('key2');
        $user = User::find($user_id);
        $role = $user->role;
        // dd($role);
        $event_id = $id;
        $event = Event::where('id',$event_id)->first();
        $requester = User::where('id',$event->user_id)->first();
        $requester_role = $requester->role;

        $eventType = Event::leftjoin('venues', 'events.venue_id', '=', 'venues.id')
                    ->leftJoin('rooms', 'events.room_id', '=', 'rooms.id')
                    ->where('events.id', $event_id)
                    ->select('venues.name as venue_name', 'rooms.name as room_name',
                        \DB::raw('CASE
                                    WHEN rooms.id IS NOT NULL THEN "Room"
                                    ELSE "Venue"
                                END AS event_type')
                    )
                    ->first();
        // dd($eventTy/pe->event_type);
        
        $place = $eventType->event_type;


        if ($requester_role === 'student')
        {
            $hashedPassword = Hash::make($password);
            $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
            $hashOfOfficial = $hashedPasswordFromDatabase->hash;

            if ($place === "Room")
            {
                $room = Room::join('events', 'rooms.id', 'events.room_id')->where('events.id', $event_id)->select('rooms.name')->first();
                if($role === 'org_adviser')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->org_adviser = $officials->hash;
                        $events->approved_org_adviser_at = now();
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
            
                }
            }
            else
            {
                $angEvent = Venue::join('events', 'venues.id', 'events.venue_id')->where('events.id', $event_id)->select('venues.name')->first();
                // dd($angEvent);
                $venue = $angEvent->name;
                if($venue === 'IT Auditorium')
                {
                    if($role === 'org_adviser')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->org_adviser = $officials->hash;
                                $events->approved_org_adviser_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                    
                        }
                    elseif($role === 'section_head')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->sect_head = $officials->hash;
                                $events->approved_sec_head_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                    
                        }
                    elseif($role === 'department_head')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->dept_head = $officials->hash;
                                $events->approved_dept_head_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                    elseif($role === 'osa')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->osa = $officials->hash;
                                $events->approved_osa_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                    elseif($role === 'adaa')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->adaa = $officials->hash;
                                $events->approved_adaa_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                    elseif($role === 'atty')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->atty = $officials->hash;
                                $events->approved_atty_at = now();
                                $events->status = "APPROVED";
                                $events->color = "#31B4F2";
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                }
                else
                {
                    if($role === 'org_adviser')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->org_adviser = $officials->hash;
                                $events->approved_org_adviser_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                    
                        }
                    elseif($role === 'section_head')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->sect_head = $officials->hash;
                                $events->approved_sec_head_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                    
                        }
                    elseif($role === 'department_head')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->dept_head = $officials->hash;
                                $events->approved_dept_head_at = now();
                                $events->updated_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                    elseif($role === 'osa')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->osa = $officials->hash;
                                $events->approved_osa_at = now();
                                $events->updated_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                    elseif($role === 'adaa')
                        {
                            // $userRequesterRole = 
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->adaa = $officials->hash;
                                $events->approved_adaa_at = now();
                                $events->updated_at = now();
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                    elseif($role === 'campus_director')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->campus_director = $officials->hash;
                                $events->approved_campus_director_at = now();
                                $events->updated_at = now();
                                $events->status = "APPROVED";
                                $events->color = "#31B4F2";
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                }


            }
        }
        elseif ($requester_role === 'professor')
        {
            $hashedPassword = Hash::make($password);
            $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
            $hashOfOfficial = $hashedPasswordFromDatabase->hash;

            if ($place === "Room")
            {
                $room = Room::join('events', 'rooms.id', 'events.room_id')->where('events.id', $event_id)->select('rooms.name')->first();
                if($role === 'section_head')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->sect_head = $officials->hash;
                        $events->approved_sec_head_at = now();
                        $events->status = "APPROVED";
                        $events->color = "#31B4F2";
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
            
                }
            }
            else
            {
                if($role === 'atty')
                    {
                        // $userRequesterRole = 
                        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                            // Passwords match, proceed with authentication logic
                            // echo "Password Match";
                            $users = User::find($user_id);
                            $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                            $events = Event::find($event_id);
                            $events->atty = $officials->hash;
                            $events->approved_atty_at = now();
                            $events->updated_at = now();
                            $events->save();
                            return response()->json(["message" => 'Request handled successfully']);
                            // return response()->json(['message' => 'Request handled successfully']);
                        } else {
                            // Passwords do not match, handle invalid password
                            // echo "Password Does Not Match";
                            return response()->json(['error' => 'Invalid passcode'], 422);
                        }
                    }
                elseif($role === 'campus_director')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->campus_director = $officials->hash;
                                $events->approved_campus_director_at = now();
                                $events->updated_at = now();
                                $events->status = "APPROVED";
                                $events->color = "#31B4F2";
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                


            }
        }
        elseif ($requester_role === 'staff')
        {
            $hashedPassword = Hash::make($password);
            $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
            $hashOfOfficial = $hashedPasswordFromDatabase->hash;

            if ($place === "Room")
            {
                $room = Room::join('events', 'rooms.id', 'events.room_id')->where('events.id', $event_id)->select('rooms.name')->first();
                if($role === 'section_head')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->sect_head = $officials->hash;
                        $events->approved_sec_head_at = now();
                        $events->status = "APPROVED";
                        $events->color = "#31B4F2";
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
            
                }
            }
            else
            {
                if($role === 'adaa')
                    {
                        // $userRequesterRole = 
                        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                            // Passwords match, proceed with authentication logic
                            // echo "Password Match";
                            $users = User::find($user_id);
                            $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                            $events = Event::find($event_id);
                            $events->adaa = $officials->hash;
                            $events->approved_adaa_at = now();
                            $events->updated_at = now();
                            $events->save();
                            return response()->json(["message" => 'Request handled successfully']);
                            // return response()->json(['message' => 'Request handled successfully']);
                        } else {
                            // Passwords do not match, handle invalid password
                            // echo "Password Does Not Match";
                            return response()->json(['error' => 'Invalid passcode'], 422);
                        }
                    }
                elseif($role === 'campus_director')
                        {
                            if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                                // Passwords match, proceed with authentication logic
                                // echo "Password Match";
                                $users = User::find($user_id);
                                $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                                $events = Event::find($event_id);
                                $events->campus_director = $officials->hash;
                                $events->approved_campus_director_at = now();
                                $events->updated_at = now();
                                $events->status = "APPROVED";
                                $events->color = "#31B4F2";
                                $events->save();
                                return response()->json(["message" => 'Request handled successfully']);
                                // return response()->json(['message' => 'Request handled successfully']);
                            } else {
                                // Passwords do not match, handle invalid password
                                // echo "Password Does Not Match";
                                return response()->json(['error' => 'Invalid passcode'], 422);
                            }
                        }
                


            }
        }
        
        
        
        
        // return response()->json(["events" => $events]);
    }

    public function reject(Request $request, string $id)
    {
        $password = $request->input('key1');
        $user_id = $request->input('key2');
        $reason = $request->input('key3');
        $user = User::find($user_id);
        $role = $user->role;
        // dd($role);
        $event_id = $id;
        
        $angEvent = Venue::join('events', 'venues.id', 'events.venue_id')->where('events.id', $event_id)->select('venues.name')->first();
        $venue = $angEvent->name;

        $hashedPassword = Hash::make($password);
        $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
        $hashOfOfficial = $hashedPasswordFromDatabase->hash;

            if($role === 'org_adviser')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_org_adviser = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->update();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
            
                }
            elseif($role === 'section_head')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_sec_head = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
            
                }
            elseif($role === 'department_head')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_dept_head = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
                }
            elseif($role === 'osa')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_osa = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
                }
            elseif($role === 'adaa')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_adaa = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
                }
            elseif($role === 'campus_director')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_campus_director = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
                }
            elseif($role === 'atty')
                {
                    if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
                        // Passwords match, proceed with authentication logic
                        // echo "Password Match";
                        $users = User::find($user_id);
                        $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
                        $events = Event::find($event_id);
                        $events->remarks_atty = $reason;
                        $events->rejected_by = $user_id;
                        $events->status = 'REJECTED';
                        $events->updated_at = now(); // DATE OF REJECTION
                        $events->save();
                        return response()->json(["message" => 'Request handled successfully']);
                        // return response()->json(['message' => 'Request handled successfully']);
                    } else {
                        // Passwords do not match, handle invalid password
                        // echo "Password Does Not Match";
                        return response()->json(['error' => 'Invalid passcode'], 422);
                    }
                }
        
    
    }

    public function myRejectRequest()
    {
        $user_id = Auth::user()->id;
        return view('officials.secHead.myNewReject', ['user_id' => $user_id]);
    }

    public function getMyRejectRequest(String $id)
    {
        // dd($user_id);
        $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                            ->orderBy('events.id')
                            ->where('rejected_by', $id)
                            ->whereNull('events.room_id')
                            ->select('events.event_name',
                            'events.type',
                            'events.start_date',
                            'events.end_date',
                            'events.start_time',
                            'events.end_time',
                            'events.status',
                            'events.updated_at',
                            'venues.name',
                            'events.remarks_org_adviser',
                            'events.remarks_sec_head',
                            'events.remarks_dept_head',
                            'events.remarks_osa',
                            'events.remarks_adaa',
                            'events.remarks_atty',
                            'events.remarks_campus_director',)
                            ->get();
        // dd($events);
        return response()->json($myRejectList);
    }

    public function myApprovedRequest()
    {
        return view('officials.secHead.myApproved');
    }

    public function getMyApprovedRequest(String $id)
    {
        $official = Official::where('user_id',$id)->first();
        $user_role = $official->role;
        $org_id = $official->organization_id;
        $dept_id = $official->department_id;
        $section_id = $official->section_id;
    
        // dd($org_id);
        if($user_role === "org_adviser")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->leftjoin('rooms','rooms.id','events.room_id')
                                ->whereNotNull('org_adviser')
                                ->where('events.target_org',$org_id)
                                ->select('organizations.organization',
                                        'departments.department',
                                        'events.status',
                                        'events.event_name',
                                        'events.start_date',
                                        'events.end_date',
                                        'events.start_time',
                                        'events.end_time',
                                        'events.type',
                                        \DB::raw('CASE
                                                    WHEN rooms.name IS NULL THEN venues.name
                                                    ELSE rooms.name
                                                END AS venueName'),
                                        'events.id')
                                ->orderBy('events.id')
                                ->get();
            return response()->json($myRejectList);
        }   
        elseif($user_role === "section_head")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('users','events.user_id','users.id')
                                ->leftjoin('students','students.user_id','users.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->leftjoin('rooms','rooms.id','events.room_id')
                                ->orderBy('events.id')
                                ->whereNotNull('org_adviser')
                                ->whereNotNull('sect_head')
                                ->whereNull('events.room_id')
                                ->where('students.section_id',$section_id)
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
                                        'events.id')
                                ->get();
            return response()->json($myRejectList);
        }     
        elseif($user_role === "department_head")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->orderBy('events.id')
                                ->whereNotNull('org_adviser')
                                ->whereNotNull('sect_head')
                                ->whereNotNull('dept_head')
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
                                        'events.id')
                                ->get();
            return response()->json($myRejectList);
        }
        elseif ($user_role === "osa")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->orderBy('events.id')
                                ->whereNotNull('org_adviser')
                                ->whereNotNull('sect_head')
                                ->whereNotNull('dept_head')
                                ->whereNotNull('osa')
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
                                        'events.id')
                                ->get();
            return response()->json($myRejectList);
        }
        elseif ($user_role === "adaa")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                // ->whereNotNull('org_adviser')
                                // ->whereNotNull('sect_head')
                                // ->whereNotNull('dept_head')
                                // ->whereNotNull('osa')
                                ->whereNotNull('adaa')
                                ->where('adaa', '!=', 'notnull')
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
                                        'events.id')
                                ->orderBy('events.id')
                                ->get();
            return response()->json($myRejectList);
        }
        elseif ($user_role === "atty")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->orderBy('events.id')
                                // ->whereNotNull('org_adviser')
                                // ->whereNotNull('sect_head')
                                // ->whereNotNull('dept_head')
                                // ->whereNotNull('osa')
                                // ->whereNotNull('adaa')
                                ->whereNotNull('atty')
                                // ->where('venues.name', 'IT Auditorium')
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
                                        'events.id')
                                ->get();
            // dd($myRejectList);
            return response()->json($myRejectList);
        }
        elseif ($user_role === "campus_director")
        {
            $myRejectList = Event::leftjoin('venues','events.venue_id','venues.id')
                                ->leftjoin('organizations','organizations.id','events.target_org')
                                ->leftjoin('departments','departments.id','events.target_dept')
                                ->orderBy('events.id')
                                ->whereNotNull('campus_director')
                                // ->where('venues.name', '!=', 'IT Auditorium')
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
                                        'events.id')
                                ->get();
            return response()->json($myRejectList);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    public function checkStatus(Request $request, string $id)
    {
        // dd($id);
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
                    // $appSecDate = $events->approved_sec_head_at;
                    $message = 'Your Request is on Process';
                    return response()->json(["msg" => $message, "status" => 200]);
                }
                elseif ($orgAdviser !== null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                {
                    // $appSecDate = $events->approved_sec_head_at;
                    $approvalDates = [
                        $events->approved_org_adviser_at,
                    ];
                    
                    $approvalMessage = [
                        'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                    ];
                    $pendingMsg = 'Waiting for Approval of Section Head';
                    return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                }
                elseif ($orgAdviser !== null && $secHead !== null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                {
                    $approvalDates = [
                        $events->approved_org_adviser_at,
                        $events->approved_sec_head_at,
                    ];
                    
                    $approvalMessage = [
                        'APPROVED BY ORGANIZATION ADVISER',
                        'APPROVED BY SECTION HEAD OF IT',
                    ];

                    $pendingMsg = 'APPROVED';
                    return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                }
            }
            else
            {
                if($venues->name ==='IT Auditorium')
                {
                    if ($orgAdviser === null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                    {
                        // $appSecDate = $events->approved_sec_head_at;
                        $message = 'Your Request is on Process';
                        return response()->json(["msg" => $message, "status" => 200]);
                    }
                    elseif ($orgAdviser !== null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                    {
                        // $appSecDate = $events->approved_sec_head_at;
                        $approvalDates = [
                            $events->approved_org_adviser_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                        ];
                        $pendingMsg = 'Waiting for Approval of Section Head';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead === null && $osa === null && $adaa === null && $atty === null)
                    {
                        $approvalDates = [
                            $events->approved_org_adviser_at,
                            $events->approved_sec_head_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ORGANIZATION ADVISER',
                            'APPROVED BY SECTION HEAD',
                        ];

                        $pendingMsg = 'Waiting for Approval of Department Head';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa === null && $adaa === null && $atty === null) 
                    {
                        $approvalDates = [
                            $events->approved_org_adviser_at,
                            $events->approved_sec_head_at, 
                            $events->approved_dept_head_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ORGANIZATION ADVISER',
                            'APPROVED BY SECTION HEAD',
                            'APPROVED BY DEPARTMENT HEAD',
                        ];
                        $pendingMsg = 'Waiting for Approval OSA';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa === null && $atty === null) 
                    {
                        $approvalDates = [
                            $events->approved_org_adviser_at,
                            $events->approved_sec_head_at, 
                            $events->approved_dept_head_at,
                            $events->approved_osa_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ORGANIZATION ADVISER',
                            'APPROVED BY SECTION HEAD',
                            'APPROVED BY DEPARTMENT HEAD',
                            'APPROVED BY OSA',
                        ];
                        $pendingMsg = 'Waiting for Approval of ADAA';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $atty === null) 
                    {
                        $approvalDates = [
                            $events->approved_org_adviser_at,
                            $events->approved_sec_head_at, 
                            $events->approved_dept_head_at,
                            $events->approved_osa_at,
                            $events->approved_adaa_at,
                        ];
                    
                        $approvalMessage = [
                            'APPROVED BY ORGANIZATION ADVISER',
                            'APPROVED BY SECTION HEAD',
                            'APPROVED BY DEPARTMENT HEAD',
                            'APPROVED BY OSA',
                            'APPROVED BY ADAA',
                        ];
                        $pendingMsg = 'Waiting for approval of ATTY';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $atty !== null) 
                    {
                        $approvalDates = [
                            $events->approved_org_adviser_at,
                            $events->approved_sec_head_at, 
                            $events->approved_dept_head_at,
                            $events->approved_osa_at,
                            $events->approved_adaa_at,
                            $events->approved_atty_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ORGANIZATION ADVISER',
                            'APPROVED BY SECTION HEAD',
                            'APPROVED BY DEPARTMENT HEAD',
                            'APPROVED BY OSA',
                            'APPROVED BY ADAA',
                            'APPROVED BY ATTY',
                        ];
                        $pendingMsg = 'APPROVED';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                }
                else
                {
                    if ($events->status === 'PENDING' || $events->status ==='APPROVED') 
                    {
                        if ($orgAdviser === null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $cd === null)
                        {
                            $message = 'Your Request is on Process';
                            return response()->json(["msg" => $message, "status" => 200]);
                        }
                        elseif ($orgAdviser !== null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $cd === null)
                        {
                            $approvalDates = [
                                $events->approved_org_adviser_at,
                            ];
                            
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                            ];
                            $pendingMsg = 'Waiting for Approval of Section Head';
                            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead === null && $osa === null && $adaa === null && $cd === null)
                        {
                            $approvalDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at,
                            ];
                            
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD',
                            ];

                            $pendingMsg = 'Waiting for Approval of Department Head';
                            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa === null && $adaa === null && $cd === null) 
                        {
                            $approvalDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at, 
                                $events->approved_dept_head_at,
                            ];
                            
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD',
                                'APPROVED BY DEPARTMENT HEAD',
                            ];
                            $pendingMsg = 'Waiting for Approval OSA';
                            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa === null && $cd === null) 
                        {
                            $approvalDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at, 
                                $events->approved_dept_head_at,
                                $events->approved_osa_at,
                            ];
                            
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD',
                                'APPROVED BY DEPARTMENT HEAD',
                                'APPROVED BY OSA',
                            ];
                            $pendingMsg = 'Waiting for Approval of ADAA';
                            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $cd === null) 
                        {
                            $approvalDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at, 
                                $events->approved_dept_head_at,
                                $events->approved_osa_at,
                                $events->approved_adaa_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD',
                                'APPROVED BY DEPARTMENT HEAD',
                                'APPROVED BY OSA',
                                'APPROVED BY ADAA',
                            ];
                            $pendingMsg = 'Waiting for Approval of Campus Director';
                            return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        elseif ($orgAdviser !== null && $secHead !== null && $depHead !== null && $osa !== null && $adaa !== null && $cd !== null) 
                        {
                            $approvalDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at, 
                                $events->approved_dept_head_at,
                                $events->approved_osa_at,
                                $events->approved_adaa_at,
                                $events->approved_campus_director_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD',
                                'APPROVED BY DEPARTMENT HEAD',
                                'APPROVED BY OSA',
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
                        if ($events->remarks_org_adviser !== null)
                        {
                            $message = 'Your Request is Rejected By Organization Adviser';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'REJECTED BY ORGANIZATION ADVISER: ' . $rejectedBy->name. '<br>Reason: ' . $events->remarks_org_adviser,
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        else if($events->remarks_sec_head !== null){
                            $message = 'Your Request is Rejected By Section Head';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->approved_org_adviser_at,
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'REJECTED BY SECTION HEAD: ' . $rejectedBy->name . '<br>Reason: ' . $events->remarks_sec_head,
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        else if($events->remarks_dept_head !== null){
                            $message = 'Your Request is Rejected By Department Head';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at,
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD: ' . $sect_user->name,
                                'REJECTED BY DEPARTMENT HEAD: ' . $rejectedBy->name . '<br>Reason: ' . $events->remarks_dept_head,
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        else if($events->remarks_osa !== null){
                            $message = 'Your Request is Rejected By OSA';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at,
                                $events->approved_dept_head_at,
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD: ' . $sect_user->name,
                                'APPROVED BY DEPARTMENT HEAD: ' . $dept_user->name,
                                'REJECTED BY OSA' .'<br>Reason: '. $events->remarks_osa
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }   
                        else if($events->remarks_adaa !== null){
                            $message = 'Your Request is Rejected By ADAA';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at,
                                $events->approved_dept_head_at,
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD: ' . $sect_user->name,
                                'APPROVED BY DEPARTMENT HEAD: ' . $dept_user->name,
                                'APPROVED BY OSA',
                                'REJECTED BY ADAA' .'<br>Reason: '. $events->remarks_adaa
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        else if($events->remarks_atty !== null){
                            $message = 'Your Request is Rejected By ADAF';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at,
                                $events->approved_dept_head_at,
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD: ' . $sect_user->name,
                                'APPROVED BY DEPARTMENT HEAD: ' . $dept_user->name,
                                'APPROVED BY OSA',
                                'APPROVED BY ADAA',
                                'REJECTED BY ADAF' .'<br>Reason: '. $events->remarks_atty
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                        }
                        else if($events->remarks_campus_director !== null){
                            $message = 'Your Request is Rejected By Campus Director';
                            // return response()->json(["msg" => $message, "status" => 200]);
                            $rejectedDates = [
                                $events->approved_org_adviser_at,
                                $events->approved_sec_head_at,
                                $events->approved_dept_head_at,
                                $events->approved_osa_at,
                                $events->approved_adaa_at,
                                $events->updated_at,
                            ];
                        
                            $approvalMessage = [
                                'APPROVED BY ORGANIZATION ADVISER: ' . $official_user->name,
                                'APPROVED BY SECTION HEAD: ' . $sect_user->name,
                                'APPROVED BY DEPARTMENT HEAD: ' . $dept_user->name,
                                'APPROVED BY OSA',
                                'APPROVED BY ADAA',
                                'REJECTED BY CAMPUS DIRECTOR' .'<br>Reason: '. $events->remarks_campus_director
                            ];
                            $pendingMsg = 'REJECTED';
                            return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
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
                    if ($atty === null && $cd === null)
                    {
                        $message = 'Your Request is on Process';
                        return response()->json(["msg" => $message, "status" => 200]);
                    }
                    elseif ($atty !== null && $cd === null) 
                    {
                        $approvalDates = [
                            $events->approved_atty_at,
                        ];
                        
                        $approvalMessage = [
                            'APPROVED BY ADAF',
                        ];
                        $pendingMsg = 'Waiting for Approval of Campus Director';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                    elseif ($atty !== null && $cd !== null) 
                    {
                        $approvalDates = [
                            $events->approved_atty_at,
                            $events->approved_campus_director_at,
                        ];
                    
                        $approvalMessage = [
                            'APPROVED BY ADAF',
                            'APPROVED BY CAMPUS DIRECTOR',
                        ];
                        
                        $pendingMsg = 'APPROVED';
                        return response()->json(["dates" => $approvalDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                }
                else if($events->status === 'REJECTED')
                {
                    // dd($events->remarks_sec_head);
                    if ($events->remarks_atty !== null)
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
                    else if($events->remarks_campus_director !== null){
                        $message = 'Your Request is Rejected By Campus Director';
                        // return response()->json(["msg" => $message, "status" => 200]);
                        $rejectedDates = [
                            $events->approved_atty_at,
                            $events->updated_at,
                        ];
                    
                        $approvalMessage = [
                            'APPROVED BY ADAF ',
                            'REJECTED BY CAMPUS DIRECTOR ',
                        ];
                        $pendingMsg = 'REJECTED';
                        return response()->json(["dates" => $rejectedDates, "msg" => $approvalMessage, "pendingMsg" => $pendingMsg, "status" => 200]);
                    }
                }
            }
        }   
        elseif ($role === 'staff')
        {
            $adaa = $events->adaa;
            $cd = $events->campus_director;

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $events = Event::find($id);
    $venues = Venue::find($events->venue_id);
    $rooms = Room::find($events->room_id);
    $users = User::where('id',$events->user_id)->first();
    $orgAdviser = $events->org_adviser; 
    $secHead = $events->sect_head;
    $depHead = $events->dept_head;
    $osa = $events->osa;
    $adaa = $events->adaa;
    $atty = $events->atty;
    $cd = $events->campus_director;

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
    $place = $eventType->event_type;

    // dd($events->);
    // Initialize $Message with a default value
    $Message = 'No approval status available.';
    // dd($events->status);
    if ($events->status === 'PENDING' && $users->role === 'student')
    {
        if($orgAdviser === null && $secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null && $cd === null)
        {
            $Message = 'Waiting for approval of organization adviser';
        }
        elseif($secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null && $cd === null)
        {
            $Message = 'Waiting for approval of section head';
        }
        elseif ($depHead === null && $osa === null && $adaa === null && $atty === null && $cd === null)
        {
            $Message = 'Waiting for approval of department head';
        }
        elseif ($osa === null && $adaa === null && $atty === null && $cd === null)
        {
            $Message = 'Waiting for approval of OSA';
        }
        elseif ($adaa === null && $atty === null && $cd === null)
        {
            $Message = 'Waiting for approval of ADAA';
        }
        elseif ($atty === null && $venues->name === 'IT Auditorium')
        {
            // $approvedAdaaMsg = 'APPROVED BY ADAA';
            $Message = 'Waiting for approval of ATTY';
        }
        elseif ($cd === null && $venues->name !== 'IT Auditorium')
        {
            // $approvedAttyMsg = 'APPROVED BY ATTY';
            $Message = 'Waiting for approval of Campus Director';
        }
        else
        {
            $approvedCampDirectorDate = $events->approved_campus_director_at;
            $approvedCampDirectorMsg = 'APPROVED BY CAMPUS DIRECTOR';
            $Message = 'APPROVED';
            $events->status = "APPROVED";
            $events->save();
        }
    }
    else if ($events->status === 'PENDING' && $users->role === 'professor')
    {
        if ($atty === null && $cd === null)
        {
            // $approvedAdaaMsg = 'APPROVED BY ADAA';
            $Message = 'Waiting for approval of ATTY';
        }
        elseif ($cd === null)
        {
            // $approvedAttyMsg = 'APPROVED BY ATTY';
            $Message = 'Waiting for approval of Campus Director';
        }
        else
        {
            $approvedCampDirectorDate = $events->approved_campus_director_at;
            $approvedCampDirectorMsg = 'APPROVED BY CAMPUS DIRECTOR';
            $Message = 'APPROVED';
            $events->status = "APPROVED";
            $events->save();
        }
    }
    else if ($events->status === 'PENDING' && $users->role === 'staff')
    {
        if ($adaa === null && $cd === null)
        {
            // $approvedAdaaMsg = 'APPROVED BY ADAA';
            $Message = 'Waiting for approval of ADAA';
        }
        elseif ($cd === null)
        {
            // $approvedAttyMsg = 'APPROVED BY ATTY';
            $Message = 'Waiting for approval of Campus Director';
        }
        else
        {
            $approvedCampDirectorDate = $events->approved_campus_director_at;
            $approvedCampDirectorMsg = 'APPROVED BY CAMPUS DIRECTOR';
            $Message = 'APPROVED';
            $events->status = "APPROVED";
            $events->save();
        }
    }
    

    return response()->json(["events" => $events, "venues" => $venues, "rooms" => $rooms, "msg" => $Message, "typeOfPlace" => $place, 
                            // "approvedSecHeadDate" => $approvedSecHeadDate, "approvedSecHeadMsg" => $approvedSecHeadMsg,
                            // "approvedDeptHeadDate" => $approvedDeptHeadDate, "approvedDeptHeadMsg" => $approvedDeptHeadMsg,
                            // "approvedOsaDate" => $approvedOsaDate, "approvedOsaMsg" => $approvedOsaMsg,
                            // "approvedAdaaDate" => $approvedAdaaDate, "approvedAdaaMsg" => $approvedAdaaMsg,
                            // "approvedAttyDate" => $approvedAttyDate, "approvedAttyMsg" => $approvedAttyMsg,
                            // "approvedCampDirectorDate" => $approvedCampDirectorDate, "approvedCampDirectorMsg" => $approvedCampDirectorMsg,
                            "status" => 200]);
    
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
