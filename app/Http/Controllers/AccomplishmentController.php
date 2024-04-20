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
        $events = Event::leftJoin('venues', 'venues.id', 'events.venue_id')
            ->leftJoin('rooms', 'rooms.id', 'events.room_id')
            ->leftJoin('organizations', 'organizations.id', 'events.target_org')
            ->leftJoin('departments', 'departments.id', 'events.target_dept')
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
                DB::raw('CASE
                                    WHEN rooms.name IS NULL THEN venues.name
                                    ELSE rooms.name END AS venueName'),
                'events.id')
            ->where('status', 'APPROVED')
            ->where('events.user_id', $user_id)
            ->get();

        return response()->json($events);
    }

    public function create()
    {
        return view('accomplishment');  
    }   
    
    public function storeAccomplishment(Request $request, String $id)
    {
       
        $request->validate([
            // 'event_id' => 'required|string',
            'images.*' => 'nullable|image|max:2048', // Max size: 2MB
            'pdf' => 'nullable|mimes:pdf|max:2048', // PDF file
        ]);


         // Upload PDF
         if ($request->hasFile('pdf')) {
            $pdfName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs('public/pdfs', $pdfName);
            
            Accomplishment::create([
                'event_id' => $id,
                'letter' => 'pdf/'.$pdfName
            ]);
        }
        
         // Upload images
        $lastid = DB::getPdo()->lastInsertId();
        
        if ($request->hasFile('images')) {
            $files = $request->file('images');
    
            foreach ($files as $file) {
                $this->documentation_img_upload($file);
                $upload = [
                    'image' => time() . '_' . $file->getClientOriginalName(),
                    'accomplishmentreports_id' => $lastid,
                ];
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
