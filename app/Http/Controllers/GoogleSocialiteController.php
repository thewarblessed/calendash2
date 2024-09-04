<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use App\Models\PendingUser;
use Log;

class GoogleSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
    
            $user = Socialite::driver('google')->stateless()->user();
        
            $finduser = User::where('social_id', $user->id)->first();

            
            // $student = Student::where('')
            
            if($finduser){
     
                Auth::login($finduser);
                // dd($finduser);
                
                if ($finduser->email_verified_at === null)
                {
                    $pendingUser = PendingUser::where('user_id', $finduser->id)->first();
                    if ($pendingUser) {
                        return redirect('/dashboard')->with('pending', 'Your account is currently under review. We appreciate your patience and will provide further instructions soon.');
                    }
                    else{
                        return redirect('/completeProfile');
                    }
                    
                }
                else
                {
                    return redirect('/dashboard');
                }

     
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'role'=> 'student',
                    'social_type'=> 'google',
                    'penalties' => 0,
                    'password' => encrypt('my-google')
                ]);
                
                Auth::login($newUser);
     
                return redirect('/completeProfile');
            }
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function checkGoogleID(Request $request)
    {
        $google_id = $request->input('google_id');
        // Log::info($request);
        $user = User::where('social_id', $google_id)->first();
        
        if ($user) {
            // User with the provided Google ID exists
            return response()->json(['user' => $user,'message' => 'User exists'], 200);
        } else {
            // User with the provided Google ID does not exist
            return response()->json(['message' => 'User does not exist'], 404);
        }
        
    }

}
