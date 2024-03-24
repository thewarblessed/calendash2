<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\Department;
use App\Models\User;
use DB;

class DepartmentHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $departments = Department::pluck('department', 'id');
        $officials = User::join('officials', 'users.id', 'officials.user_id')
                            ->leftjoin('departments','departments.id','officials.department_id')
                            ->leftjoin('sections','sections.id','officials.section_id')
                            ->leftjoin('organizations','organizations.id','officials.organization_id')
                            ->select('officials.id','departments.department','organizations.organization','sections.section','users.role','users.name','users.email')
                            ->orderBy('officials.id')
                            ->where('users.role','department_head')
                            ->get();
                            // dd($officials);
        return view('admin.deptHead.index', compact('departments','officials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $departments = Department::pluck('department', 'id');
        return view('admin.deptHead.create', compact('departments'));
    }

    public function getAllDepartments()
    {
        //
        $departments = Department::all();
        return response()->json($departments);
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
            'role' => 'department_head'
        ]);

        $lastid = DB::getPdo()->lastInsertId();

        $officials = new Official();
        $officials->user_id = $lastid;
        $officials->hash = Hash::make($request->passcode);
        $officials->department_id = $request->department_id;
        $officials->role = 'department_head';
        
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
        $userID = $request->departmentHeadEditId;
        $officials = Official::where('id',$userID)->first();
        // dd($officials);
        $user = User::where('id',$officials->user_id)->first();

        $officials->department_id = $request->department_id;
        $user->name = $request->departmentHeadEditName;
        $user->email = $request->departmentHeadEditEmail;

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
