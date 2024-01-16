<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Tymon\JWTAuth\Facades\JWTAuth;
// use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.signin');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        $rememberMe = $request->rememberMe ? true : false;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $token = $user->createToken(time())->plainTextToken;
            
            return redirect('/dashboard');
            // return response()->json(["success" => "Login Successfully.", "user" => $user,"status" => 200]);
        }
        Auth::login();
        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    // public function LoginMobile(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');
    
    //     if (!Auth::attempt($credentials)) {
    //         return response()->json(["errors" => "Invalid credentials.", "status" => 200]);
    //     }
    
    //     $user = Auth::user();
    //     $token = JWTAuth::fromUser($user);
    
    //     return response()->json([
    //         "success" => "Login Successfully.",
    //         "user" => $user,
    //         "token" => $token,
    //         "status" => 200,
    //     ]);
    // }

    public function loginMobile(Request $request)
    {
        // dd($request->all());
        // $user = User::where('email', $request->email)->first();
        $credentials = $request->only('email', 'password');
        
         if (!Auth::attempt($credentials)){
            return response()->json(["errors" => "You entered invalid credentials.", "status" => 401]);
        }
        $password = bcrypt($request->password);
        
        Auth::attempt(['email' => $request->input('email'),'password' => $request->password]);
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        return response()->json(["success" => "Login Successfully.", "user" => $user, "password" => $password, "token" => $token, "status" => 200]);
    }

    public function logoutMobile(Request $request)
    {
        Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return response()->json(["success" => "Logged Out Successfully.", "status"=> 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/sign-in');
    }
}
