<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoomSeeder::class,
            VenueSeeder::class,
            OrganizationSeeder::class,
            DepartmentSeeder::class,
            // SectionSeeder::class,
            UserSeeder::class,
            OfficialSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
