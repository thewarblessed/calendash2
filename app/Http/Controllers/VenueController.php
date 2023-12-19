<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Venue;
use Redirect;
use View;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $venues = Venue::orderBy('id')->get();
        // dd($venues);
        // return response()->json($venues);
        return View::make('admin.venue.index', compact('venues'));

    }

    public function indexUser()
    {
        //
        $venues = Venue::orderBy('id')->get();
        // return response()->json($venues);
        return View::make('venues.index', compact('venues'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.venue.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // dd($request->all());
        $venues = new Venue();
        $venues->name = $request->venueName;
        $venues->description = $request->venueDesc;
        $venues->capacity = $request->venueCapacity;
        // $venues->image =

        $files = $request->file('image');
        $venues->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $venues->save();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        // Redirect::to('/admin/event');
        // return Redirect::to('/admin/event');
        return response()->json(["success" => "Venue Created Successfully.", "Venues" => $venues, "status" => 200]);
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
        $venues = Venue::find($id);
        return response()->json(["Venues" => $venues, "status" => 200]);

        // return View::make('admin.venue.index', compact('venues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $venues = Venue::find($id);
        // dd($request->all());
        $venues->name = $request->venueEditName;
        $venues->description = $request->venueEditDesc;
        $venues->capacity = $request->venueEditCapacity;

        
        $files = $request->file('venueEditImage');
        $venues->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $venues->update();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        return response()->json(["success" => "Venue Updated Successfully.", "Venues" => $venues, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $venues = Venue::findOrFail($id);
        $venues->delete();

        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }

    ////// MOBILE BACKEND
    public function storeMobile(Request $request)
    {   
        // dd($request->all());
        $venues = new Venue();
        $venues->name = $request->venueName;
        $venues->description = $request->venueDesc;
        $venues->capacity = $request->venueCapacity;
        // $venues->image =

        // $files = $request->file('image')->getClientOriginalName();
        // $venues->image = $files;
        // $venues->save();
        // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        $files = $request->file('image');
        $venues->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $venues->save();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        // Redirect::to('/admin/event');
        // return Redirect::to('/admin/event');
        return response()->json(["success" => "Venue Created Successfully.", "Venues" => $venues, "status" => 200]);
    }

    public function indexMobile()
    {   
        $venues = Venue::orderBy('id')->get();
        // dd($venues);
        return response()->json($venues);
        // return View::make('admin.venue.index', compact('venues'));
    }

    public function destroyMobile(string $id)
    {
        $venues = Venue::findOrFail($id);
        $venues->delete();

        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }

    public function updateMobile(Request $request, string $id)
    {   
        $venues = Venue::find($id);
        // dd($venues->);
        $venues->name = $request->venueName;
        $venues->description = $request->venueDesc;
        $venues->capacity = $request->venueCapacity;

        // $files = $request->file('image');
        // $venues->image = 'images/'.time().'-'.$files->getClientOriginalName();
        // $venues->save();
        // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        // $venues->image = $request->image;

        $files = $request->file('image');
        // dd($files);
        $venues->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $venues->update();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        return response()->json(["success" => "Venue Updated Successfully.", "Venues" => $venues, "status" => 200]);
    }

}
