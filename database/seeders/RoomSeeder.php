<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Room::create([
            'name' => 'IT BLDG - RM 101',
            'description' => 'No Foods allowed',
            'capacity' => 50,
            'image' => 'room.jpg'
        ]);
        Room::create([
            'name' => 'IT BLDG - RM 102',
            'description' => 'No Foods Allowed',
            'capacity' => 50,
            'image' => 'room.jpg'
        ]);
        Room::create([
            'name' => 'IT BLDG - RM 103',
            'description' => 'No Foods Allowed',
            'capacity' => 50,
            'image' => 'room.jpg'
        ]);
    }
}
