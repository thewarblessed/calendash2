<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use View;
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $events = Event::orderBy('id')->get();
        $da = Event::orderBy('id')->select('event_date')->get();
        // dd($events);
        dd($time);
        // $start_time = $events->start_time;
        // $end_time = $event->end_time;

        
        // return response()->json($events);
        return View::make('adaa.request', compact('events'));
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
