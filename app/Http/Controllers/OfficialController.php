<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\User;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Section;
use View;
use DB;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $officials = Official::orderBy('id')->get();
        // $organizations = Organization::pluck('organization', 'id');

        // $departments = Department::pluck('department', 'id');

        $officials = User::join('officials', 'users.id', 'officials.user_id')
                            ->where('officials.department_id', null)
                            ->where('officials.organization_id', null)
                            ->where('officials.section_id', null)
                            ->orderBy('officials.id')->get();
                            // dd($officials);
        // $withUser = User::orderBy('id')->select('')->get();
        // dd($officials);
        // return response()->json($venues);
        // dd([0],$officials->hash);
        return View::make('admin.official.index', compact('officials'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $organizations = Organization::pluck('organization', 'id');

        $departments = Department::pluck('department', 'id');
        // $organizations = Organization::pluck('organization', 'id');
        // dd($org->organization);
        return view('admin.official.create', compact('organizations','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //ADD OFFICIALS
        $user = User::create([
            'name' => $request->firstname .' '.$request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'role' => $request->official_role
        ]);

        $lastid = DB::getPdo()->lastInsertId();

        if ($request->official_role === 'org_adviser')
        {
            $officials = new Official();
            $officials->user_id = $lastid;
            $officials->hash = Hash::make($request->passcode);
            $officials->organization_id = $request->organization_id;
            $officials->role = 'org_adviser';
            $files = $request->file('image');
            $officials->esign = 'images/'.time().'-'.$files->getClientOriginalName();
            $officials->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
            // dd($officials);

            return response()->json(["user" => $user, "officials" => $officials, "status" => 200]);
        }
        elseif($request->official_role === 'department_head')
        {
            $officials = new Official();
            $officials->user_id = $lastid;
            $officials->hash = Hash::make($request->passcode);
            $officials->department_id = $request->department_id;
            $officials->role = 'department_head';
            $files = $request->file('image');
            $officials->esign = 'images/'.time().'-'.$files->getClientOriginalName();
            $officials->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
            // dd($officials);

            return response()->json(["user" => $user, "officials" => $officials, "status" => 200]);
        }
        else
        {
            $officials = new Official();
            $officials->user_id = $lastid;
            $officials->hash = Hash::make($request->passcode);
            $files = $request->file('image');
            $officials->role = $request->official_role;
            $officials->esign = 'images/'.time().'-'.$files->getClientOriginalName();
            $officials->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
            // dd($officials);

            return response()->json(["user" => $user, "officials" => $officials, "status" => 200]);
        }
        
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
        $userID = $request->officialEditId;
        $officials = Official::where('user_id',$userID)->first();
        // dd($officials);
        $user = User::where('id',$officials->user_id)->first();
        // dd($user);
        // dd($officials->name);
        $role = $officials->role;   

        if($role ==='org_adviser')
        {
            $officials->organization_id = $request->organization_id;
            $user->name = $request->officialEditName;
            $user->email = $request->officialEditEmail;

            $officials->update();
            $user->update();
            return response()->json(["success" => "Official Updated Successfully.", "officials" => $officials, "status" => 200]);
        }
        elseif($role ==='department_head')
        {
            $officials->department_id = $request->department_id;
            $user->name = $request->officialEditName;
            $user->email = $request->officialEditEmail;

            $officials->update();
            $user->update();
            return response()->json(["success" => "Official Updated Successfully.", "officials" => $officials, "status" => 200]);
        }
        else
        {
            // $officials->department_id = $request->department_id;
            $user->name = $request->officialEditName;
            $user->email = $request->officialEditEmail;

            $user->update();
            return response()->json(["success" => "Official Updated Successfully.", "officials" => $officials, "status" => 200]);
        }
        // dd($request->all());
        
        
        // $files = $request->file('venueEditImage');
        // $venues->image = 'images/'.time().'-'.$files->getClientOriginalName();
        // $venues->update();
        // Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        // return response()->json(["success" => "Venue Updated Successfully.", "Venues" => $venues, "status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAllOrgAdviser()
    {
        //
        $orgAdvisers = Official::join('users', 'users.id','officials.user_id')
                                ->where('users.role','org_adviser')
                                ->get();
        return response()->json(["orgAdvisers" => $orgAdvisers, "status" => 200]);
    }

    public function getAllSectionHead()
    {
        //
        $orgAdvisers = Official::join('users', 'users.id','officials.user_id')
                                ->where('users.role','section_head')
                                ->get();
        return response()->json(["orgAdvisers" => $orgAdvisers, "status" => 200]);
    }

    public function getAllDepartmentHead()
    {
        //
        $orgAdvisers = Official::join('users', 'users.id','officials.user_id')
                                ->where('users.role','department_head')
                                ->get();
        return response()->json(["orgAdvisers" => $orgAdvisers, "status" => 200]);
    }
}
