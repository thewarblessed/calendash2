<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomplishment;
use App\Models\Event;
use App\Models\Documentation;
use DB;

class AccomplishmentController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'APPROVED')->orderBy('id')->get();

        return view('accomplishment', compact('events'));
    }

   public function getMyApprovedEvents(String $id)
    {
        $user_id = $id;
        $eventIds = Event::where('status', 'APPROVED')
                        ->where('user_id', $user_id)
                        ->distinct('events.id')
                        ->pluck('events.id');
                        $events = [];
                        foreach ($eventIds as $eventId) {
                            $event = Event::leftJoin('venues', 'venues.id', 'events.venue_id')
                                ->leftJoin('rooms', 'rooms.id', 'events.room_id')
                                ->leftJoin('organizations', 'organizations.id', 'events.target_org')
                                ->leftJoin('departments', 'departments.id', 'events.target_dept')
                                ->leftJoin('accomplishmentreports', 'events.id', 'accomplishmentreports.event_id')
                                ->leftJoin('documentations','accomplishmentreports.id','documentations.accomplishmentreports_id')
                                ->select('organizations.organization',
                                    'departments.department',
                                    'events.status',
                                    'events.event_name',
                                    'events.start_date',
                                    'events.end_date',
                                    'events.start_time',
                                    'events.end_time',
                                    'events.type',
                                    'events.event_letter',
                                    'accomplishmentreports.letter',
                                    'documentations.image',
                                    'accomplishmentreports.edit',
                                    'accomplishmentreports.created_at',
                                    'documentations.updated_at',
                                    DB::raw('CASE
                                                        WHEN rooms.name IS NULL THEN venues.name
                                                        ELSE rooms.name END AS venueName'),
                                    'events.id')
                                ->where('events.id', $eventId)
                                ->first();
                        
                            if ($event) {
                                $events[] = $event;
                            }
                        }

        return response()->json($events);
    }


    public function create()
    {
        return view('accomplishment');  
    }   
    
    public function storeAccomplishment(Request $request, String $id)
    {
        $request->validate([
            'images.*' => 'nullable|image|max:15360', // Max size: 15MB (15360 KB)
            'pdf' => 'nullable|mimes:pdf|max:5120',   // Max size: 5MB (5120 KB)
        ]);
    
        // Check if an accomplishment report with the given event_id exists
        $existingAccomplishment = Accomplishment::where('event_id', $id)->first();
    
        // Upload PDF
        if ($request->hasFile('pdf')) {
            $pdfName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs('public/pdfs', $pdfName);
    
            if ($existingAccomplishment) {
                // Update the existing accomplishment report with the new PDF file
                $existingAccomplishment->update([
                    'letter' => 'pdfs/' . $pdfName
                ]);
            } else {
                // Create a new accomplishment report
                $newAccomplishment = Accomplishment::create([
                    'event_id' => $id,
                    'letter' => 'pdfs/' . $pdfName,
                    'edit' => 3,
                    'created_at' => now()
                ]);
    
                // Save the ID of the newly created accomplishment report
                $lastid = $newAccomplishment->id;
            }
        }
    
        // If no accomplishment report exists and no new one was created, return an error
        if (!$existingAccomplishment && !isset($lastid)) {
            return response()->json(['error' => 'No accomplishment report found for the given event ID.'], 404);
        }
    
        // Upload images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
    
            // Use the ID of the existing or newly created accomplishment report
            $lastid = $existingAccomplishment ? $existingAccomplishment->id : $lastid;
    
            foreach ($files as $file) {
                $this->documentation_img_upload($file);
                $upload = [
                    'image' => time() . '_' . $file->getClientOriginalName(),
                    'accomplishmentreports_id' => $lastid,
                ];
                DB::table('documentations')->insert($upload);
            }
            // dd($files);
        }
    
        return response()->json(['Message' => 'Successfully!']);
    }

    public function updateAccomplishment(Request $request, String $id)
    {
        $existingAccomplishment = Accomplishment::where('event_id', $id)->first();
        // dd($existingAccomplishment);
        $lastEdit = $existingAccomplishment->edit;
        // dd($lastEdit);
        
        // Upload PDF
        if ($request->hasFile('pdf')) {
            $pdfName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs('public/pdfs', $pdfName);
    
            if ($existingAccomplishment) {
                // Update the existing accomplishment report with the new PDF file
                $newEdit = $lastEdit - 1;
                $existingAccomplishment->update([
                    'letter' => 'pdfs/' . $pdfName,
                    'edit' => $newEdit,
                    'updated_at' => now()
                ]);
            } else {
                // Create a new accomplishment report
                $newAccomplishment = Accomplishment::create([
                    'event_id' => $id,
                    'letter' => 'pdfs/' . $pdfName,
                    'edit' => 3
                ]);
    
                // Save the ID of the newly created accomplishment report
                $lastid = $newAccomplishment->id;
            }
        }
    
        // If no accomplishment report exists and no new one was created, return an error
        if (!$existingAccomplishment && !isset($lastid)) {
            return response()->json(['error' => 'No accomplishment report found for the given event ID.'], 404);
        }

        // if ($lastid) {
        //     // Delete existing documentations with the same accomplishment report ID
        //     Documentation::where('accomplishmentreports_id', $lastid)->delete();
        // }
    
        // Upload images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            // dd($files);
            // Use the ID of the existing or newly created accomplishment report
            $lastid = $existingAccomplishment ? $existingAccomplishment->id : $lastid;
            
            Documentation::where('accomplishmentreports_id', $lastid)->delete();

            // Insert new documentation records
            foreach ($files as $file) {
                // Upload the image (assuming the method returns the image name or path)
                $imageName = $this->documentation_img_upload($file);
                
                // Prepare the data to be inserted
                $upload = [
                    'image' => $imageName ?? time() . '_' . $file->getClientOriginalName(), // Use $imageName if available
                    'accomplishmentreports_id' => $lastid, // Ensure this matches your database column name
                    'updated_at' => now()
                ];
                
                // Insert the new documentation record into the database
                DB::table('documentations')->insert($upload);
            }
        }
    
        return response()->json(['Message' => 'Successfully!']);
        
    }

    public function documentation_img_upload($file)
    {
        $destinationPath = public_path().'/images/documentation'; 
        $original_filename = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $original_filename);
    }
}
