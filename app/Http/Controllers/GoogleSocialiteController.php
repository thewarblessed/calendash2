<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\Models\User;

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
     
            if($finduser){
     
                Auth::login($finduser);
                // dd($finduser);
                
                if ($finduser->email_verified_at === null)
                {
                    return redirect('/completeProfile');
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
                    'password' => encrypt('my-google')
                ]);
                
                Auth::login($newUser);
     
                return redirect('/completeProfile');
            }
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
