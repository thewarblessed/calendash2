<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Models\Official;
use View;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
// use Auth;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $events = Event::orderBy('id')->whereNotNull('dept_head', null)->get();
        // dd($events);

        //ROLE BASED TABLE
        $user_role = Auth::user()->role;
        
        // $events = Event::orderBy('id')
        //                 ->where('sect_head', null)
        //                 ->where('dept_head', null)
        //                 ->where('osa', null)
        //                 ->where('atty', null)
        //                 ->where('adaa', null)
        //                 ->where('campus_director', null)
        //                 ->get();
        // dd($events);
        if($user_role === "section_head")
        {
            $events = Event::orderBy('id')->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }     
        elseif($user_role === "department_head")
        {
            $events = Event::orderBy('id')->whereNotNull('sect_head', null)->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "osa")
        {
            $events = Event::orderBy('id')->whereNotNull('dept_head', null)
                                        ->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "atty")
        {
            $events = Event::orderBy('id')->whereNotNull('osa', null)
                                        ->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "adaa")
        {
            $events = Event::orderBy('id')->whereNotNull('atty', null)->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
        }
        elseif ($user_role === "campus_director")
        {
            $events = Event::orderBy('id')->whereNotNull('adaa', null)->get();
            // return response()->json($events);
            return View::make('officials.secHead.request', compact('events'));
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
        
        
        $password = $request->input('key1');
        $user_id = 19;
        $user = User::find($user_id);
        $role = $user->role;
        // dd($role);
        $event_id = $id;

        $hashedPassword = Hash::make($password);
        $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->select('officials.hash')->first();
        $hashOfOfficial = $hashedPasswordFromDatabase->hash;
        // dd($hashedPassword);

        // if ($role->)
        
        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
            // Passwords match, proceed with authentication logic
            // echo "Password Match";
            $users = User::find($user_id);
            $officials = Official::join('users', 'users.id', 'officials.user_id')->where('users.id', $user_id)->first();
            $events = Event::find($event_id);
            $events->sect_head = $officials->hash;
            $events->save();
            return response()->json(["message" => 'Request handled successfully']);
            // return response()->json(['message' => 'Request handled successfully']);
        } else {
            // Passwords do not match, handle invalid password
            // echo "Password Does Not Match";
            return response()->json(['error' => 'Invalid passcode'], 422);
        }

        // return response()->json(["events" => $events]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    public function approveRequest(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        $passcode = $request->passcode;

        $user = User::where('email', $request->email)->first();
        $rememberMe = $request->rememberMe ? true : false;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $token = $user->createToken(time())->plainTextToken;
            
            return redirect('/dashboard');
            // return response()->json(["success" => "Login Successfully.", "user" => $user,"status" => 200]);
        }
        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $events = Event::find($id);
    $venues = Venue::find($events->venue_id);
    
    $secHead = $events->sect_head;
    $depHead = $events->dept_head;
    $osa = $events->osa;
    $adaa = $events->adaa;
    $atty = $events->atty;
    $cd = $events->campus_director;

    // Initialize $Message with a default value
    $Message = 'No approval status available.';

    if($secHead === null && $depHead === null && $osa === null && $adaa === null && $atty === null && $cd === null)
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
    elseif ($atty === null && $cd === null)
    {
        $Message = 'Waiting for approval of ATTY';
    }
    elseif ($cd === null)
    {
        $Message = 'Waiting for approval of Campus Director';
    }
    else
    {
        $Message = 'APPROVED';
        $events->status = "APPROVED";
        $events->save();
     }

    return response()->json(["events" => $events, "venues" => $venues, "msg" => $Message, "status" => 200]);
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
