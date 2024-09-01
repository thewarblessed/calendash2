<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Event;
use App\Imports\ImportStudents;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceTemplateExport;
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
        $currentDateTime = now();
        // $events = Event::orderBy('id')
        //                 ->where('user_id', Auth::user()->id)
        //                 ->where('start_date', '<=', $currentDateTime)
        //                 ->where('end_date', '>=', $currentDateTime)
        //                 ->whereTime('start_time', '<=', $currentDateTime->format('H:i:s'))
        //                 ->whereTime('end_time', '>=', $currentDateTime->format('H:i:s'))
        //                 ->get();
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
        $attendance = Attendance::findOrFail($id);
        
        // Toggle attendance_time based on whether the checkbox is checked
        if ($attendance->attendance_time === null) {
            $attendance->attendance_time = now(); // Assign current time when checked
        } else {
            $attendance->attendance_time = null; // Reset to null when unchecked
        }
    
        $attendance->update();
        
        return response()->json(['attendance_time' => $attendance->attendance_time]); // Return updated attendance_time
    }
    
    
    
    /**
     * Remove the specified resource from storage.  
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportTemplate()
    {
        return Excel::download(new AttendanceTemplateExport, 'attendance_template.xlsx');
    }

    public function addParticipant(Request $request, String $id)
    {
        $event_id = $id;

        $newParticipant = Attendance::create([
            'event_id' => $event_id,
            'yearsection' => $request->attendanceYearAndSection,
            'lastname'=> $request->attendanceLastName,
            'firstname'=> $request->attendanceFirstName,
        ]);

        return response()->json($newParticipant);
        // return Excel::download(new AttendanceTemplateExport, 'attendance_template.xlsx');
    }
}
