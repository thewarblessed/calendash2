<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Section;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;
use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $role = $user->role;

        if ($role === 'student'){
            $student = Student::where('user_id', $user->id)->first();
            $organizations = Organization::all();
            $departments = Department::all();
            $sections = Section::orderBy('section', 'ASC')->get();

            return view('laravel-examples.user-profile', compact('user', 'organizations', 'departments', 'sections', 'role'));
        }
        else if ($role === 'professor'){
            $student = Prof::where('user_id', $user->id)->first();
            $departments = Department::all();
            return view('laravel-examples.user-profile', compact('user', 'student', 'role'));
        }
        else if ($role === 'staff'){
            $student = Staff::where('user_id', $user->id)->first();
            $departments = Department::all();
            return view('laravel-examples.user-profile', compact('user', 'departments', 'role', 'student'));
        }
        else{
            $student = User::where('id', $user->id)->first();
            return view('laravel-examples.user-profile', compact('user', 'student', 'role'));
        }   
        
    }

    public function update(Request $request)
    {
        
        $user = User::find(Auth::id());
        $student = Student::where('user_id', $user->id)->first();
        $prof = Prof::where('user_id', $user->id)->first();
        $staff = Staff::where('user_id', $user->id)->first();

        $role = $user->role;

        if ($role === 'student'){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            // dd($student);
            $student->update([
                'department_id' => $request->department_id,
                'organization_id' => $request->organization_id,
                'section_id' => $request->section_id,
            ]);
            return back()->with('success', 'Profile updated successfully.');
        }
        elseif ($role === 'professor'){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            // dd($student);
            return back()->with('success', 'Profile updated successfully.');
        }
        elseif ($role === 'staff'){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            // dd($student);
            $staff->update([
                'department_id' => $request->department_id_staff,
            ]);
            // dd($request->department_id_staff);
            return back()->with('success', 'Profile updated successfully.');
        }
        else{
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return back()->with('success', 'Profile updated successfully.');
        }
        
    }

    public function myProfile()
    {
        $user = User::find(Auth::id());
        $role = $user->role;
        // dd($role);
        

        if ($role === 'student'){
            $student = Student::leftjoin('sections','sections.id','students.section_id')
                                ->leftjoin('organizations','organizations.id','students.organization_id')
                                ->leftjoin('departments','departments.id','students.department_id')
                                ->where('user_id', $user->id)
                                ->first();
                                // dd($student);
            return view('profile.myProfile', compact('user', 'student', 'role'));
        }
        elseif ($role === 'professor'){
            $student = Prof::where('user_id', $user->id)->first();
            // dd($student);
            return view('profile.myProfile', compact('user', 'student', 'role'));
        }
        elseif ($role === 'staff'){
            $student = Staff::leftjoin('departments','departments.id','staffs.department_id')
                                ->where('user_id', $user->id)
                                ->first();
            // dd($student);
            return view('profile.myProfile', compact('user', 'student', 'role'));
        }
        else{
            $student = Student::where('user_id', $user->id)->first();
            return view('profile.myProfile', compact('user', 'student', 'role'));
        }
        // dd(Auth::id());
        

        
    }

    public function changePasscodeView()
    {
        $user = User::find(Auth::id());
        $role = $user->role;
        // dd($role);
        
        return view('officials.secHead.changePasscode', compact('user', 'role'));
        // if ($role === 'student'){
        //     $student = Student::leftjoin('sections','sections.id','students.section_id')
        //                         ->leftjoin('organizations','organizations.id','students.organization_id')
        //                         ->leftjoin('departments','departments.id','students.department_id')
        //                         ->where('user_id', $user->id)
        //                         ->first();
        //                         // dd($student);
        //     return view('profile.myProfile', compact('user', 'student', 'role'));
        // }
        // elseif ($role === 'professor'){
        //     $student = Prof::where('user_id', $user->id)->first();
        //     // dd($student);
        //     return view('profile.myProfile', compact('user', 'student', 'role'));
        // }
        // elseif ($role === 'staff'){
        //     $student = Staff::leftjoin('departments','departments.id','staffs.department_id')
        //                         ->where('user_id', $user->id)
        //                         ->first();
        //     // dd($student);
        //     return view('profile.myProfile', compact('user', 'student', 'role'));
        // }
        // else{
        //     $student = Student::where('user_id', $user->id)->first();
        //     return view('profile.myProfile', compact('user', 'student', 'role'));
        // }
        // dd(Auth::id());
        

        
    }

    public function checkPasscode(Request $request)
    {
        $user_id = $request->user_id;

        // Assuming $password is the new passcode input
        $password = $request->input('currentPasscode');
        $hashedPasswordFromDatabase = Official::join('users', 'users.id', 'officials.user_id')
                                                ->where('users.id', $user_id)
                                                ->select('officials.hash')
                                                ->first();  

        if ($hashedPasswordFromDatabase && Hash::check($password, $hashedPasswordFromDatabase->hash)) {
            return response()->json(["message" => 'Passcode matched!'], 200);
        } else {
            return response()->json(["message" => 'Passcode does not match your current passcode'], 200);
        }
    }

    public function updatePasscode(Request $request)
    {
        $passcode = $request->input('passcode');
        $user_id = $request->input('user_id');

        $official = Official::where('user_id', $user_id)->first();
        if ($official) {
            $official->hash = Hash::make($passcode);
            $official->save(); // Save the updated hash
            return response()->json(["message" => 'Passcode updated!'], 200);
        } else {
            return response()->json(['error' => 'Official not found'], 404);
        }
    }
}
