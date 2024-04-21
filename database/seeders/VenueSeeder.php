<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Venue::create([
            'name' => 'Multipurpose Hall',
            'description' => 'Up to 200 participants',
            'capacity' => 200,
            'image' => 'venue.jpg'
        ]);
        Venue::create([
            'name' => 'Gymnasium',
            'description' => 'No Foods Allowed',
            'capacity' => 200,
            'image' => 'venue.jpg'
        ]);
        Venue::create([
            'name' => 'IT Auditorium',
            'description' => 'No Foods Allowed',
            'capacity' => 200,
            'image' => 'venue.jpg'
        ]);
        Venue::create([
            'name' => 'Outside Court',
            'description' => 'No Roof',
            'capacity' => 200,
            'image' => 'venue.jpg'
        ]);
        Venue::create([
            'name' => 'Continental',
            'description' => 'Up to 100 participants',
            'capacity' => 100,
            'image' => 'venue.jpg'
        ]);
        Venue::create([
            'name' => 'Professors Lounge',
            'description' => 'Up to 25 participants',
            'capacity' => 25,
            'image' => 'venue.jpg'
        ]);
    }
}
