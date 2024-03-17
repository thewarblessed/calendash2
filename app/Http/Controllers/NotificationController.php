<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Official;
use App\Models\User;
use Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $id)
    {
        //

        $user_id = $id;
        // dd($user_id);
        $user = User::where('id',$id)->first();
        $user_role = $user->role;
        
        // dd($user_id);
        $official = Official::where('user_id',$user_id)->first();
    
        // $pending = Venue::join('events','events.venue_id','venues.id')
        //     ->orderBy('events.status')
        //     ->orderByDesc('events.id')
        //     ->where('events.target_org', $org_id)
        //     ->where('events.status','PENDING')
        //     ->get();

        // dd($pending);

        if($user_role === "org_adviser")
        {
            $org_id = $official->organization_id;
            $pending = Venue::leftjoin('events','events.venue_id','venues.id')
                            ->leftjoin('users','events.user_id','users.id')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->where('events.target_org', $org_id)
                            ->where('events.status','PENDING')
                            ->select('events.created_at','users.name')
                            ->get();
            // dd($pending);
            // $PenEvents = Event::orderBy('id')->whereNull('org_adviser')->get();
            // dd($PenEvents);
            return response()->json($pending);
        }   
        elseif($user_role === "section_head")
        {
            $section_id = $official->section_id;
            $pending = Event::leftjoin('venues','events.venue_id','venues.id')
                        ->leftjoin('users','users.id','events.user_id')
                        ->leftjoin('students','students.user_id','users.id')
                        ->orderBy('events.status')
                        ->orderByDesc('events.id')
                        ->whereNotNull('org_adviser')
                        ->where('students.section_id', $section_id)
                        ->get();
            // $pending = Venue::join('events','events.venue_id','venues.id')->orderBy('events.status')->orderByDesc('events.id')->get();
            // $pending = Event::orderBy('id')->get();
            // $pending = Event::orderBy('id')->whereNotNull('org_adviser')->get();
            // dd($PenEvents);
            return response()->json($pending);
        }     
        elseif($user_role === "department_head")
        {
            $dept_id = $official->department_id;
            // $pending = Venue::join('events','events.venue_id','venues.id')->orderBy('events.status')->orderByDesc('events.id')->get();
            $pending = Venue::leftjoin('events','events.venue_id','venues.id')
                            ->leftjoin('users','events.user_id','users.id')
                            ->orderBy('events.status')
                            ->orderByDesc('events.id')
                            ->where('events.target_dept', $dept_id)
                            ->where('events.status','PENDING')
                            ->select('events.created_at','users.name')
                            ->get();
            // $pending = Event::orderBy('id')->get();
            // $pending = Event::orderBy('id')->whereNotNull('sect_head')->get();
            return response()->json($pending);
        }
        elseif ($user_role === "osa")
        {
            $pending = Event::orderBy('id')->whereNotNull('dept_head')
                            // ->where('status', 'PENDING')
                            ->get();
            // dd($pending);
            return response()->json($pending);
        }
        elseif ($user_role === "adaa")
        {
            $pending = Event::orderBy('id')->whereNotNull('osa')->get();
            return response()->json($pending);
        }
        elseif ($user_role === "atty")
        {
            // $pending = Event::orderBy('id')->whereNotNull('adaa', null);
            $pending = Event::join('venues', 'venues.id', 'events.venue_id')
            ->orderBy('events.id')
            ->where('venues.name', 'IT Auditorium')
            ->whereNotNull('adaa')
            ->get();
            return response()->json($pending);
        }
        elseif ($user_role === "campus_director")
        {
            // hindi dapat lalabas yung sa IT FUNCTION HALL na venue.
            $pending = Event::join('venues', 'venues.id', 'events.venue_id')
            ->orderBy('events.id')
            ->where('venues.name', '!=', 'IT Auditorium')
            ->whereNotNull('adaa')
            ->get();
            return response()->json($pending);
        }
        elseif ($user_role === "student" || $user_role === "prof" || $user_role === "staff")
        {
            $pending = Event::where('user_id', $user_id)
                ->where('status', 'APPROVED')
                ->select('org_adviser', 'approved_org_adviser_at',
                        'sect_head', 'approved_sec_head_at',
                        'dept_head', 'approved_dept_head_at',
                        'osa', 'approved_osa_at',
                        'adaa', 'approved_adaa_at',
                        'atty', 'approved_atty_at',
                        'campus_director', 'approved_campus_director_at')
                ->first();
            // dd($pending);
            $messages = [];

            foreach ($pending->toArray() as $key => $value) {
                if (!is_null($value)) {
                    $column = ucfirst(str_replace('_', ' ', $key)); // Convert column name to human-readable format
                    $messages[] = $column . ' approved the request';
                }
            }

            if (empty($messages)) {
                $messages[] = 'No approvals found';
            }

            return response()->json(["msg" => $messages, "pending" => $pending, "user" => $user_role]);
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
