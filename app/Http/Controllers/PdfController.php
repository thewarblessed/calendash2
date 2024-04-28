<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DB;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function userCountTable()
    {
        $rolesCount = DB::table('users')
                        ->select('role', DB::raw('count(*) as count'))
                        ->groupBy('role')
                        ->get();

        $users = DB::table('users')->orderBy('id')->get();

        $html = view('reports.userCount', compact('rolesCount','users'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('user_report.pdf');
        // $pdf->save(public_path('uploads/reports/userCountTable.pdf'));

        // return response()->download(public_path('uploads/reports/userCountTable.pdf'));
    }

    // public function userCountTable()
    // {
    //     $rolesCount = DB::table('users')
    //                     ->select('role', DB::raw('count(*) as count'))
    //                     ->groupBy('role')
    //                     ->get();

    //     $users = DB::table('users')->orderBy('id')->get();

    //     $html = view('reports.userCount', compact('rolesCount','users'))->render();
    //     $pdf = PDF::loadHTML($html);
    //     return $pdf->download('user_report.pdf');
    //     // $pdf->save(public_path('uploads/reports/userCountTable.pdf'));

    //     // return response()->download(public_path('uploads/reports/userCountTable.pdf'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
