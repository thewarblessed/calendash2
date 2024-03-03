<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Section::create([
            'section' => 'BGT Major in Architectural Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Chemical Technology'
        ]);
        Section::create([
            'section' => 'BS Environmental Science'
        ]);
        Section::create([
            'section' => 'BS Electrical Engineering'
        ]);
        Section::create([
            'section' => 'BET Major in Electrical Technology'
        ]);
        Section::create([
            'section' => 'BS Electronics Engineering'
        ]);
        Section::create([
            'section' => 'BET Major in Electronics Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Mechanical Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Automotive Technology'
        ]);
        Section::create([
            'section' => 'Bachelor of Technical Vocational Teacher Education'
        ]);
        Section::create([
            'section' => 'BS Information Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Instrumentation and Control Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Mechatronics Technology'
        ]);
        Section::create([
            'section' => 'BS Mechanical Engineering'
        ]);
        Section::create([
            'section' => 'BET Major in Heating, Ventilation, and Airconditioning/Refrigirator Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Electromechanical Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Non-Destructive Testing Technology'
        ]);
        Section::create([
            'section' => 'BET Major in Dies and Moulds Technology (concurrent)'
        ]);
    }
}
