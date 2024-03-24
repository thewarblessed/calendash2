<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\Section;
use App\Models\User;
use DB;

class SectionHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Section::pluck('section', 'id');
        $officials = User::join('officials', 'users.id', 'officials.user_id')
                            ->leftjoin('departments','departments.id','officials.department_id')
                            ->leftjoin('sections','sections.id','officials.section_id')
                            ->leftjoin('organizations','organizations.id','officials.organization_id')
                            ->select('officials.id','departments.department','organizations.organization','sections.section','users.role','users.name','users.email')
                            ->orderBy('officials.id')
                            ->where('users.role','section_head')
                            ->get();
        return view('admin.sectionHead.index', compact('sections','officials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sections = Section::pluck('section', 'id');
        return view('admin.sectionHead.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = User::create([
            'name' => $request->firstname .' '.$request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'role' => 'section_head'
        ]);

        $lastid = DB::getPdo()->lastInsertId();

        $officials = new Official();
        $officials->user_id = $lastid;
        $officials->hash = Hash::make($request->passcode);
        $officials->section_id = $request->section_id;
        $officials->role = 'section_head';
        $officials->save();
        
        // dd($officials);

        return response()->json(["user" => $user, "officials" => $officials, "status" => 200]);
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
        $officials = Official::join('users','users.id','officials.user_id')->where('officials.id',$id)->first();
        // dd($officials);
        return response()->json(["officials" => $officials, "status" => 200]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $userID = $request->sectionHeadEditId;
        $officials = Official::where('id',$userID)->first();
        // dd($officials);
        $user = User::where('id',$officials->user_id)->first();

        $officials->section_id = $request->section_id;
        $user->name = $request->sectionHeadEditName;
        $user->email = $request->sectionHeadEditEmail;

        $officials->update();
        $user->update();
        return response()->json(["success" => "Official Updated Successfully.", "officials" => $officials, "users" => $user, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
