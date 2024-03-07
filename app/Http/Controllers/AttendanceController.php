<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Event;
use App\Imports\ImportStudents;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

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

    public function getStudentList()
    {
        //
        $studentList = Attendance::orderBy('id')->get();
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
