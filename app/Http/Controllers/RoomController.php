<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = Room::All();
        return view('admin.room.index',compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rooms = new Room();
        $rooms->name = $request->roomName;
        $rooms->description = $request->roomDesc;
        $rooms->capacity = $request->roomCapacity;
        // $venues->image =

        $files = $request->file('image');
        $rooms->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $rooms->save();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        // Redirect::to('/admin/event');
        // return Redirect::to('/admin/event');
        return response()->json(["success" => "Venue Created Successfully.", "Rooms" => $rooms, "status" => 200]);
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
        $rooms = Room::find($id);
        return response()->json(["rooms" => $rooms, "status" => 200]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $rooms = Room::find($id);
        // dd($request->all());
        $rooms->name = $request->roomEditName;
        $rooms->description = $request->roomEditDesc;
        $rooms->capacity = $request->roomEditCapacity;
        
        
        $files = $request->file('roomEditImage');
        $rooms->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $rooms->update();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        return response()->json(["success" => "Room Updated Successfully.", "Rooms" => $rooms, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $rooms = Room::findOrFail($id);
        $rooms->delete();

        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }
}
