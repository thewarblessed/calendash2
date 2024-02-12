<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\User;
use View;
use DB;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $officials = Official::orderBy('id')->get();
        $officials = Official::join('users', 'users.id', 'officials.user_id')->orderBy('officials.id')->get();
        // $withUser = User::orderBy('id')->select('')->get();
        // dd($officials);
        // return response()->json($venues);
        // dd([0],$officials->hash);
        return View::make('admin.user.index', compact('officials'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //ADD OFFICIALS
        $user = User::create([
            'name' => $request->firstname .' '.$request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->official_role
        ]);

        $lastid = DB::getPdo()->lastInsertId();

        $officials = new Official();
        $officials->user_id = $lastid;
        $officials->hash = Hash::make($request->passcode);
        
        $files = $request->file('image');
        $officials->esign = 'images/'.time().'-'.$files->getClientOriginalName();
        $officials->save();
        Storage::put('public/images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
