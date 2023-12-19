<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('laravel-examples.users-management', compact('users'));
    }

    public function getProfile($id)
    {
            // $student = DB::table('students')
            //     ->join('users', 'users.id', 'students.user_id')
            //     ->select('students.', 'users.')
            //     ->where('user_id', $id)
            //     ->first();
        $role = User::where('id', $id)->first();

        if ($role->role === "student")
        {
            $students = Student::where('user_id',$id)->first();
            $credentials = User::where('id', $id)->first();
            return response()->json(["data" => $students, "credentials" => $credentials]);
        }
        elseif($role->role === "professor")
        {
            $prof = Prof::where('user_id',$id)->first();
            $credentials = User::where('id', $id)->first();
            return response()->json(["data" => $prof, "credentials" => $credentials]);
        }
        else
        {
            $staff = Staff::where('user_id',$id)->first();
            $credentials = User::where('id', $id)->first();
            return response()->json(["data" => $staff, "credentials" => $credentials]);
        }
        
    }


}
