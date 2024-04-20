<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Official;
use App\Models\Notification;
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
        
        if($user_role === "org_adviser")
        {
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
        }   
        elseif($user_role === "section_head")
        {
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
        }     
        elseif($user_role === "department_head")
        {
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
        }
        elseif ($user_role === "osa")
        {
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
        }
        elseif ($user_role === "adaa")
        {
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
        }
        elseif ($user_role === "atty")
        {
            // $pending = Event::orderBy('id')->whereNotNull('adaa', null);
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
        }
        elseif ($user_role === "campus_director")
        {
            // hindi dapat lalabas yung sa IT FUNCTION HALL na venue.
            $notif = Notification::leftjoin('users', 'users.id','notifications.from_user_id')
                                    ->where('to_user_id',$user_id)
                                    ->where('read', 0)
                                    ->select('notifications.id',
                                    'notifications.subject',
                                    'notifications.message',
                                    'users.name',
                                    'notifications.created_at',)
                                    ->get();
            return response()->json($notif);
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


    public function readNotif(String $id)
    {
        //

        $user_id = $id;
        // dd($user_id);
        $user = User::where('id',$id)->first();
        $user_role = $user->role;
        
        // dd($user_id);
        $official = Official::where('user_id',$user_id)->first();
        
        if($user_role === "org_adviser")
        {
            $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
        }   
        elseif($user_role === "section_head")
        {
           $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
        }     
        elseif($user_role === "department_head")
        {
            $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
        }
        elseif ($user_role === "osa")
        {
            $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
        }
        elseif ($user_role === "adaa")
        {
            $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
        }
        elseif ($user_role === "atty")
        {
            $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
        }
        elseif ($user_role === "campus_director")
        {
            $notif = Notification::where('to_user_id', $user_id)
                        ->where('read', 0)
                        ->update([
                            'read' => 1,
                            'read_at' => now()
                        ]);

            // dd($notif);
            return response()->json(["Notification successfully read!"]);
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
