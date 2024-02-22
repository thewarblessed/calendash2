<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;
use App\Models\PendingUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    
    public function completeProfile(Request $request)
    {
        $pendingUsers = new PendingUser();
        $pendingUsers->user_id = $request->user_id;
        $pendingUsers->tupID =  $request->tupID;
        $pendingUsers->firstname =  $request->firstname;
        $pendingUsers->lastname =  $request->lastname;
        $pendingUsers->organization =  $request->organization;
        $pendingUsers->department =  $request->department;
        $pendingUsers->role = "student";
        // dd($pendingUsers);
        $files = $request->file('image');
        $pendingUsers->image = 'images/'.time().'-'.$files->getClientOriginalName();
        $pendingUsers->save();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        return response()->json(["data" => $pendingUsers, "status" => 200]);
        
    }

    public function pendingUsers(Request $request)
    {
        // $pendingUsers = PendingUser::all();  
        $pendingUsers = PendingUser::join('users', 'pending_users.user_id','users.id')->get();
        return view('admin.user.pendingUsers', compact('pendingUsers'));
        
    }

    public function confirmPendingUsers(Request $request, String $id)
    {
        // $pendingUsers = PendingUser::join('users', 'pending_users.user_id','users.id')->get();
        // $user = User::find($id);
        $user = User::join('pending_users', 'pending_users.user_id','users.id')->where('users.id', $id)->first();
        // $pendingUser = PendingUser::
        $forUser = User::where('id', $id)->first();

        // dd($user->id);
        $student = new Student();
        $student->tupID = $user->tupID;
        $student->lastname = $user->lastname;
        $student->firstname = $user->firstname;
        $student->department = $user->department;
        $student->studOrg = $user->organization;
        $student->user_id = $user->user_id;
        // $student->role = 'student';
        $student->save();

        $forUser->email_verified_at = now();
        $forUser->save();
        return response()->json(["user" => $user, 
                                // "student" => $student, 
                                "status" => 200]);
        
    }

    public function editRole(Request $request, String $id)
    {
        // $user = User::where('id', $id)->first();
        // $pendingUser = PendingUser::where('user_id', $id)->first();
        // // dd($user);
        // $role = $request->role;
   
        // if ($role === 'student')
        // {
        //     // $student = Student::findOrFail($user->id);
        //     // dd($student);
        //     $student = new Student();
        //     $student->tupID = $pendingUser->tupID;
        //     $student->lastname = $pendingUser->lastname;
        //     $student->firstname = $pendingUser->firstname;
        //     $student->department = $pendingUser->department;
        //     $student->studOrg = $pendingUser->organization;
        //     $student->user_id = $user->id;
        //     $student->save();

        //     $user->role = 'student';
        //     $user->save();

        //     return response()->json(["user" => $user, "student" => $student, "status" => 200]);
        // }
        // elseif ($role === 'professor')
        // {
        //     $prof = new Prof();
        //     $prof->tupID = $user->tupID;
        //     $prof->lastname = $user->lastname;
        //     $prof->firstname = $user->firstname;
        //     $prof->department = $user->department;
        //     $prof->organization = $user->organization;
        //     $prof->user_id = $user->id;
        //     $prof->role = 'member';
        //     $prof->save();


        //     $user->role = 'professor';
        //     $user->save();
        //     return response()->json(["user" => $user, "prof" => $prof, "status" => 200]);
        // }
        // elseif ($role === 'staff')
        // {
        //     $staff = new Staff();
        //     $staff->tupID = $user->tupID;
        //     $staff->lastname = $user->lastname;
        //     $staff->firstname = $user->firstname;
        //     $staff->department = $user->department;
        //     $staff->user_id = $user->id;
        //     $staff->role = 'member';
        //     $staff->save();


        //     $user->role = 'staff';
        //     $user->save();
        //     return response()->json(["user" => $user, "staff" => $staff, "status" => 200]);
        // }
        $newRole = $request->role;
        $user = User::findOrFail($id);
        $pendingUser = PendingUser::where('user_id', $user->id)->first();
        $tupID = $pendingUser->tupID;
        // dd($tupID);
        // Get the current role
        $currentRole = $user->role;

        if ($newRole !== $currentRole) {
            // Delete the user's record from the current table based on the current role
            switch ($currentRole) {
                case 'student':
                    $user->student()->delete();
                    break;
                case 'professor':
                    $user->prof()->delete();
                    break;
                case 'staff':
                    $user->staff()->delete();
                    break;
                // Add more cases for other roles if needed
            }

            // Create a new record in the new table based on the new role
            switch ($newRole) {
                case 'student':
                    $student = new Student();
                    // Set student attributes
                    $student->tupID = $tupID;
                    $student->lastname = $pendingUser->lastname;
                    $student->firstname = $pendingUser->firstname;
                    $student->department = $pendingUser->department;
                    $student->studOrg = $pendingUser->organization;
                    $student->user_id = $user->id;
                    $student->save();
                    break;
                case 'professor':
                    $professor = new Prof();
                    // Set professor attributes
                    $professor->tupID = $tupID;
                    $professor->lastname = $pendingUser->lastname;
                    $professor->firstname = $pendingUser->firstname;
                    $professor->department = $pendingUser->department;
                    $professor->organization = $pendingUser->organization;
                    $professor->role = 'member';
                    $professor->user_id = $user->id;
                    $professor->save();
                    break;
                case 'staff':
                    $staff = new Staff();
                    // Set staff attributes
                    $staff->tupID = $tupID;
                    $staff->lastname = $pendingUser->lastname;
                    $staff->firstname = $pendingUser->firstname;
                    $staff->department = $pendingUser->department;
                    $staff->role = 'member';
                    $staff->user_id = $user->id;
                    $staff->save();
                    break;
                // Add more cases for other roles if needed
            }

            // Update the user's role in the users table
            $user->role = $newRole;
            $user->save();
        }

        return response()->json(["user" => $user, "status" => 200]);
        
    }
    public function getUser(Request $request, String $id)
    {
        // $pendingUsers = PendingUser::join('users', 'pending_users.user_id','users.id')->get();
        // $user = User::find($id);
        $user = User::join('pending_users', 'pending_users.user_id','users.id')->where('users.id', $id)->first();
        // dd($user);
        
        // $student = new Student();
        // $student->tupID = $user->tupID;
        // $student->lastname = $user->lastname;
        // $student->firstname = $user->firstname;
        // $student->department = $user->department;
        // $student->studOrg = $user->organization;
        // $student->user_id = $user->id;
        // // $student->role = 'student';
        // $student->save();

        // $user->email_verified_at = now();
        // $user->save();
        return response()->json(["user" => $user, "status" => 200]);
        
    }
}
