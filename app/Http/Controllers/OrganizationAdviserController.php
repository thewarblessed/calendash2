<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Official;
use App\Models\Organization;
use DB;

class OrganizationAdviserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $organizations = Organization::pluck('organization', 'id');
        $officials = User::join('officials', 'users.id', 'officials.user_id')
                            ->leftjoin('departments','departments.id','officials.department_id')
                            ->leftjoin('organizations','organizations.id','officials.organization_id')
                            ->select('officials.id','departments.department','organizations.organization','users.role','users.name','users.email')
                            ->orderBy('officials.id')
                            ->where('users.role','org_adviser')
                            ->get();
        return view('admin.orgAdviser.index', compact('organizations','officials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $organizations = Organization::pluck('organization', 'id');
        return view('admin.orgAdviser.create', compact('organizations'));
    }

    public function getAllOrganizations()
    {
        //
        $organizations = Organization::all();
        return response()->json($organizations);
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
            'role' => 'org_adviser'
        ]);

        $lastid = DB::getPdo()->lastInsertId();

        $officials = new Official();
        $officials->user_id = $lastid;
        $officials->hash = Hash::make($request->passcode);
        $officials->organization_id = $request->organization_id;
        $officials->role = 'org_adviser';
        
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
        $userID = $request->orgAdviserEditId;
        $officials = Official::where('id',$userID)->first();
        // dd($officials);
        $user = User::where('id',$officials->user_id)->first();

        $officials->organization_id = $request->organization_id;
        $user->name = $request->orgAdviserEditName;
        $user->email = $request->orgAdviserEditEmail;

        $officials->update();
        $user->update();
        return response()->json(["success" => "Official Updated Successfully.", "officials" => $officials, "users" => $user, "status" => 200]);
        // dd($user);
        // dd($officials->name);
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
}
