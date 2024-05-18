<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DB;
use setasign\Fpdi\Fpdi;
use FPDF;

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

    public function  TotalNumberOfEventsPerOrganization()
    {

        $eventsCount = DB::table('events')
                    ->whereNotNull('target_dept')
                    ->whereNotNull('target_org')
                    ->leftjoin('organizations', 'organizations.id', 'events.target_org')
                    ->selectRaw('organizations.organization as organization_name, count(*) as total')
                    ->groupBy('organizations.organization')
                    ->where('events.status','APPROVED')
                    ->get();

        $pdfPath = public_path('pdf/template_header.pdf');

        // Initialize FPDI
        $pdf = new Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file
        $pdf->setSourceFile($pdfPath);
        
        // Import the first page of the PDF
        $tplId = $pdf->importPage(1);
    
        // Use the imported page as the template
        $pdf->useTemplate($tplId);
    
        // Add your data to the PDF
        $pdf->SetFont('Arial', '', 12);


        $pdf->SetY(40);
        // Set table header
        $pdf->Cell(0, 10, 'Total Events per Organization', 0, 1, 'C',); // New line after text
        $pdf->Ln(5); 
        // Set table columns
        $pdf->Cell(95, 10, 'Organization', 1);
        $pdf->Cell(95, 10, 'Total Events', 1);
        $pdf->Ln(); // New line

        // Populate the table with data
        foreach($eventsCount as $event) {
            $pdf->Cell(95, 10, $event->organization_name, 1);
            $pdf->Cell(95, 10, $event->total, 1);
            $pdf->Ln(); // New line
        }
        // Add date at the bottom of the page
        $pdf->SetY(0); // Set position at 15 units from the bottom
        $pdf->SetFont('Arial', 'I', 8); // Italic font, size 8
        $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s'), 0, 0, ''); // Centered text
        // Output or save the modified PDF
        return $pdf->Output(); 


    }

    public function NumberOfEventsPerOrganizationPerVenue()
    {

        $organizationVenueEvents = DB::table('events')
                                        ->leftJoin('organizations', 'organizations.id', '=', 'events.target_org')
                                        ->leftJoin('venues', 'venues.id', '=', 'events.venue_id')
                                        ->selectRaw('organizations.organization AS organization_name, venues.name AS venue_name, COUNT(*) AS total_events')
                                        ->whereNotNull('events.target_dept')
                                        ->whereNotNull('events.target_org')
                                        ->whereNull('events.room_id') // Ensure room_id is null to exclude room events
                                        ->where('events.status', 'APPROVED') // Ensure the status is 'APPROVED'
                                        ->groupBy('organizations.organization', 'venues.name')
                                        ->get();
                                        // dd($organizationVenueEvents);

        $pdfPath = public_path('pdf/template_header.pdf');

        // Initialize FPDI
        $pdf = new Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file
        $pdf->setSourceFile($pdfPath);
        
        // Import the first page of the PDF
        $tplId = $pdf->importPage(1);
    
        // Use the imported page as the template
        $pdf->useTemplate($tplId);
    
        // Add your data to the PDF
        $pdf->SetFont('Arial', '', 12);


        $pdf->SetY(40);
        // Set table header
        $pdf->Cell(0, 10, 'Number of Events per Organization', 0, 1, 'C',); // New line after text
        $pdf->Ln(5); 
        // Set table columns
        $pdf->Cell(45, 10, 'Organization', 1);
        foreach($organizationVenueEvents as $event) {
            $pdf->Cell(45, 10, $event->venue_name, 1);
        }
        // $pdf->Cell(65, 10, 'Total Events', 1);
        $pdf->Ln(); // New line

        // Populate the table with data
        foreach($organizationVenueEvents as $event) {
            $pdf->Cell(45, 10, $event->organization_name, 1);
            // $pdf->Cell(45, 10, $event->venue_name, 1);
            $pdf->Cell(45, 10, $event->total_events, 1);
            $pdf->Ln(); // New line
        }
        // Add date at the bottom of the page
        $pdf->SetY(0); // Set position at 15 units from the bottom
        $pdf->SetFont('Arial', 'I', 8); // Italic font, size 8
        $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s'), 0, 0, ''); // Centered text
        // Output or save the modified PDF
        return $pdf->Output(); 


    }

    public function TotalEventsPerVenue()
    {

        $venues = DB::table('events')
                    ->leftJoin('organizations', 'organizations.id', 'events.target_org')
                    ->leftJoin('venues', 'venues.id', 'events.venue_id')
                    ->selectRaw('venues.name AS venue_name, COUNT(*) AS total_events')
                    ->whereNull('events.room_id')
                    ->groupBy('venues.name')
                    ->get();
        

        $pdfPath = public_path('pdf/template_header.pdf');

        // Initialize FPDI
        $pdf = new Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file
        $pdf->setSourceFile($pdfPath);
        
        // Import the first page of the PDF
        $tplId = $pdf->importPage(1);
    
        // Use the imported page as the template
        $pdf->useTemplate($tplId);
    
        // Add your data to the PDF
        $pdf->SetFont('Arial', '', 12);


        $pdf->SetY(40);
        // Set table header
        $pdf->Cell(0, 10, 'Total Events per Venue', 0, 1, 'C',); // New line after text
        $pdf->Ln(5); 
        // Set table columns
        $pdf->Cell(95, 10, 'Venue', 1);
        $pdf->Cell(95, 10, 'Total Events', 1);
        $pdf->Ln(); // New line

        // Populate the table with data
        foreach($venues as $venue) {
            $pdf->Cell(95, 10, $venue->venue_name, 1);
            $pdf->Cell(95, 10, $venue->total_events, 1);
            $pdf->Ln(); // New line
        }
        // Add date at the bottom of the page
        $pdf->SetY(0); // Set position at 15 units from the bottom
        $pdf->SetFont('Arial', 'I', 8); // Italic font, size 8
        $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s'), 0, 0, ''); // Centered text
        // Output or save the modified PDF
        return $pdf->Output(); 


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
