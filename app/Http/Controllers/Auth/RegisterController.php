<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.signup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $role = $request->roleSelect;
        // dd($role);
        if($role === "Student")
        {
            // dd("Student ako");
            $request->validate([

                'firstname' => 'required|min:3|max:255',
                'lastname' => 'required|min:3|max:255',
                'tupId' => 'required|max:7',
                'course' => 'required|min:3|max:255',
                'section' => 'required|min:3|max:255',
                'dept' => 'required|min:3|max:255',
                'organization' => 'required|min:3|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:7|max:255',
            ], [
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
                'tupId.required' => 'TUP ID is invalid',
                'course.required' => 'Course is required',
                'section.required' => 'Section is required',
                'dept.required' => 'Department is required',
                'organization.required' => 'Organization is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]);
                
            $user = User::create([
                'name' => $request->firstname .' '.$request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student'
            ]);

            $lastid = DB::getPdo()->lastInsertId();

            $student = Student::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'tupId' => 'TUPT-'.''.$request->tupId,
                'course' => $request->course, 
                'yearLevel' => $request->yearLevel,
                'department' => $request->dept,
                'studOrg' => $request->organization,
                'section' => $request->section,
                'role' => $request->orgRole,
                'user_id' => $lastid
            ]);
            
            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }
        elseif ($role === "Professor") {
            $request->validate([

                'firstname' => 'required|min:3|max:255',
                'lastname' => 'required|min:3|max:255',
                'tupId' => 'required|max:7',
                'dept' => 'required|min:3|max:255',
                'organization' => 'required|min:3|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:7|max:255',
            ], [
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
                'tupId.required' => 'TUP ID is invalid',
                'dept.required' => 'Department is required',
                'organization.required' => 'Organization is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]);
                
            $user = User::create([
                'name' => $request->firstname .' '.$request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'professor'
            ]);

            $lastid = DB::getPdo()->lastInsertId();

            $prof = Prof::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'tupId' => 'TUPT-'.''.$request->tupId,
                'department' => $request->dept,
                'organization' => $request->organization,
                'role' => $request->orgRole,
                'user_id' => $lastid
            ]);
            
            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }
        elseif ($role === "Admin/Staff"){
            $request->validate([

                'firstname' => 'required|min:3|max:255',
                'lastname' => 'required|min:3|max:255',
                'tupId' => 'required|max:7',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:7|max:255',
            ], [
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
                'tupId.required' => 'TUP ID is invalid',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]);
                
            $user = User::create([
                'name' => $request->firstname .' '.$request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'staff'
            ]);

            $lastid = DB::getPdo()->lastInsertId();

            $staff = Staff::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'tupId' => 'TUPT-'.''.$request->tupId,
                'department' => 'Admin/Staff',
                'role' => 'unfinished',
                'user_id' => $lastid
            ]);
            
            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }

        
    }

}
