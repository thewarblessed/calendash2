<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Prof;
use App\Models\Staff;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Section;
use App\Models\PendingUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Mail\RejectAccountNotify;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('laravel-examples.users-management', compact('users'));
    }

    public function viewCompleteProfile()
    {
        $organizations = Organization::pluck('organization', 'id');

        $departments = Department::pluck('department', 'id');

        $sections = Section::pluck('section', 'id');

        return view('completeProfile', compact('organizations','departments','sections'));
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
            $students = Student::leftjoin('organizations','organizations.id','students.organization_id')
                                ->leftjoin('departments','departments.id','students.department_id')
                                ->leftjoin('sections','sections.id','students.section_id')
                                ->where('user_id',$id)->first();
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
        // dd($request->user_role);
        if ($request->user_role === 'student')
        {
            $pendingUsers = new PendingUser();
            $pendingUsers->user_id = $request->user_id;
            $pendingUsers->tupID =  $request->tupID;
            $pendingUsers->firstname =  $request->firstname;
            $pendingUsers->lastname =  $request->lastname;
            $pendingUsers->organization_id =  $request->organization_id_user;
            $pendingUsers->department_id =  $request->department_id_user;
            $pendingUsers->section_id =  $request->section_id_user;
            $pendingUsers->role = $request->user_role;
            // dd($pendingUsers);
            $files = $request->file('image');
            $pendingUsers->image = 'images/'.time().'-'.$files->getClientOriginalName();
            $pendingUsers->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            return response()->json(["data" => $pendingUsers, "status" => 200]);
        }
        elseif ($request->user_role === 'professor')
        {
            $pendingUsers = new PendingUser();
            $pendingUsers->user_id = $request->user_id;
            $pendingUsers->tupID =  $request->tupID;
            $pendingUsers->firstname =  $request->firstname;
            $pendingUsers->lastname =  $request->lastname;
            $pendingUsers->organization_id =  null;
            $pendingUsers->department_id =  14;
            $pendingUsers->role = 'professor';
            // dd($pendingUsers);
            $files = $request->file('image');
            $pendingUsers->image = 'images/'.time().'-'.$files->getClientOriginalName();
            $pendingUsers->save();



            // $pendingUsers->
            // $user = User::where('id',$request->user_id)->first();
            // $user->role = 'professor';
            // $user->update();

            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            return response()->json(["data" => $pendingUsers, "status" => 200]);
        }
        elseif ($request->user_role === 'staff'){

            $pendingUsers = new PendingUser();
            $pendingUsers->user_id = $request->user_id;
            $pendingUsers->tupID =  $request->tupID;
            $pendingUsers->firstname =  $request->firstname;
            $pendingUsers->lastname =  $request->lastname;
            $pendingUsers->department_id =  $request->department_id_staff;
            $pendingUsers->role = 'staff';
            // dd($pendingUsers);
            $files = $request->file('image');
            $pendingUsers->image = 'images/'.time().'-'.$files->getClientOriginalName();
            $pendingUsers->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            return response()->json(["data" => $pendingUsers, "status" => 200]);
        }
        else{
            $pendingUsers = new PendingUser();
            $pendingUsers->user_id = $request->user_id;
            $pendingUsers->firstname =  $request->firstname;
            $pendingUsers->lastname =  $request->lastname;
            $pendingUsers->tupID =  0;
            $pendingUsers->role = 'outsider';
            // dd($pendingUsers);
            $files = $request->file('validIDimage');
            $pendingUsers->image = 'images/'.time().'-'.$files->getClientOriginalName();
            // dd($pendingUsers);
            $pendingUsers->save();
            Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            return response()->json(["data" => $pendingUsers, "status" => 200]);
        }
        
        
    }

    public function pendingUsers(Request $request)
    {
        // $pendingUsers = PendingUser::all();  
        $pendingUsers = PendingUser::leftJoin('users', 'pending_users.user_id', 'users.id')
                                    ->leftJoin('organizations', 'pending_users.organization_id', 'organizations.id')
                                    ->leftJoin('departments', 'pending_users.department_id', 'departments.id')
                                    ->leftJoin('sections', 'pending_users.section_id', 'sections.id')
                                    ->select('pending_users.user_id','pending_users.tupID','pending_users.lastname','pending_users.firstname','organizations.organization','departments.department','sections.section','pending_users.role','users.email_verified_at','users.email')
                                    ->where('pending_users.role', '!=', 'outsider')
                                    ->orderByDesc('pending_users.id')
                                    ->paginate(10);
                                    
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
        if ($user->role === 'student'){
            $student = new Student();
            $student->tupID = $user->tupID;
            $student->lastname = $user->lastname;
            $student->firstname = $user->firstname;
            $student->department_id = $user->department_id;
            $student->organization_id = $user->organization_id;
            $student->section_id = $user->section_id;
            $student->user_id = $user->user_id;
            // $student->role = 'student';
            $student->save();

            $forUser->email_verified_at = now(); // update
            $forUser->role = $user->role;
            $forUser->update();
            return response()->json(["user" => $user, 
                                    // "student" => $student, 
                                    "status" => 200]);
        }
        elseif($user->role === 'professor'){
            $professor = new Prof();
            $professor->tupID = $user->tupID;
            $professor->lastname = $user->lastname;
            $professor->firstname = $user->firstname;
            $professor->department_id = $user->department_id;
            $professor->organization_id = $user->organization_id;
            $professor->user_id = $user->user_id;
            // $student->role = 'student';
            $professor->save();

            $forUser->email_verified_at = now(); // update
            $forUser->role = $user->role;
            $forUser->update();
            return response()->json(["user" => $user, 
                                    // "student" => $student, 
                                    "status" => 200]);
        }
        elseif($user->role === 'staff'){
            $staff = new Staff();
            $staff->tupID = $user->tupID;
            $staff->lastname = $user->lastname;
            $staff->firstname = $user->firstname;
            $staff->department_id = $user->department_id;
            $staff->organization_id = $user->organization_id;
            $staff->user_id = $user->user_id;
            // $student->role = 'student';
            $staff->save();

            $forUser->email_verified_at = now(); // update
            $forUser->role = $user->role;
            $forUser->update();
            return response()->json(["user" => $user, 
                                    // "student" => $student, 
                                    "status" => 200]);
        }
        else{

            $forUser->email_verified_at = now(); // update
            $forUser->role = $user->role;
            $forUser->update();
            return response()->json(["user" => $user, 
                                    // "student" => $student, 
                                    "status" => 200]);
        }
    }

    public function editRole(Request $request, String $id)
    {
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
                    $student->department_id = $pendingUser->department_id;
                    $student->organization_id = $pendingUser->organization_id;
                    $student->section_id = $pendingUser->section_id;
                    $student->user_id = $user->id;
                    $student->save();
                    break;
                case 'professor':
                    $professor = new Prof();
                    // Set professor attributes
                    $professor->tupID = $tupID;
                    $professor->lastname = $pendingUser->lastname;
                    $professor->firstname = $pendingUser->firstname;
                    $professor->department_id = $pendingUser->department_id;
                    $professor->role = 'professor';
                    $professor->user_id = $user->id;
                    $professor->save();
                    break;
                case 'staff':
                    $staff = new Staff();
                    // Set staff attributes
                    $staff->tupID = $tupID;
                    $staff->lastname = $pendingUser->lastname;
                    $staff->firstname = $pendingUser->firstname;
                    $staff->department_id = $pendingUser->department_id;
                    $staff->role = 'staff';
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
        $user = User::leftJoin('pending_users', 'pending_users.user_id', 'users.id')
                    ->leftJoin('organizations', 'pending_users.organization_id', 'organizations.id')
                    ->leftJoin('departments', 'pending_users.department_id', 'departments.id')
                    ->leftJoin('sections', 'pending_users.section_id', 'sections.id')
                    ->where('users.id', $id)
                    ->first();
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
    public function rejectAccount(Request $request, String $id)
    {
        $user = User::leftJoin('pending_users', 'pending_users.user_id', 'users.id')
                    ->leftJoin('organizations', 'pending_users.organization_id', 'organizations.id')
                    ->leftJoin('departments', 'pending_users.department_id', 'departments.id')
                    ->leftJoin('sections', 'pending_users.section_id', 'sections.id')
                    ->where('users.id', $id)
                    ->first();
        // dd($user);
        $pendingUser = PendingUser::where('user_id', $id);
        $pendingUser->delete();

        $data = [
            "subject" => "Calendash Rejected Request",
            "body" => "Hello {$user->name}!,\n\nWe regret to inform you that your account has been declined."
            ];
        Mail::to($user->email)->send(new RejectAccountNotify($data));
        
        
        return response()->json(["user" => $user, "status" => 200]);
        
    }
}
