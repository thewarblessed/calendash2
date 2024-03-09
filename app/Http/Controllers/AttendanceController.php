<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Event;
use App\Imports\ImportStudents;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $events = Event::orderBy('id')->where('user_id', Auth::user()->id)->get();
        // dd($events);
        return view('attendance.index',compact('events'));
    }

    public function attendance(string $id)
    {
        //
        $event_id = $id;
        $events = Event::where('id',$id)->first();
        // dd($events);
        return view('attendance.attendance',compact('events','event_id'));
    }

    public function getStudentList(string $id)
    {
        //
        $studentList = Attendance::orderBy('id')->where('event_id', $id)->get();
        // dd($events);
        return response()->json($studentList);

    }

    public function import(Request $request) 
    {   
        $eventId = $request->student_event_id;
        Excel::import(new ImportStudents($eventId), request()->file('studentList'));
        return back();
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
    public function updateAttendance(Request $request, string $id)
    {
        // Log::info($request);
        // paload ako web pala check mo laravel log eco ctrl p ka dito sa vs code
        // Validate the request
        // $request->validate([
        //     'is_present' => 'required|boolean',
        // ]);
        // dd($request->all());
        // Find the attendance record
        $attendance = Attendance::findOrFail($id);
        
        // Update the attendance status
        if ($attendance->is_present === null)
        {
            $attendance->is_present = 1;
            $attendance->attendance_time = now();
        }
        else{
            $attendance->is_present = null;
            $attendance->attendance_time = null;
        }
        $attendance->update();
        
        // Update the attendance_time if the student is present
        // dd($attendance->is_present);
        
        // if ($attendance->is_present) {
        //     $attendance->attendance_time = now(); // Set the current timestamp
        // } else {
        //     $attendance->attendance_time = null; // Clear the attendance_time if the student is absent
        // }

        // Save the changes
       

        return response()->json(['message' => 'Attendance updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
