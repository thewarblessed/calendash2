<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Organization Adviser',
            'email' => 'orgadviser@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'org_adviser'
        ]);
        User::create([
            'name' => 'Section Head',
            'email' => 'julius@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'section_head'
        ]);
        User::create([
            'name' => 'Department Head',
            'email' => 'raymund@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'department_head'
        ]);
        User::create([
            'name' => 'OSA',
            'email' => 'osa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'osa'
        ]);
        User::create([
            'name' => 'ADAA',
            'email' => 'glenn@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'adaa'
        ]);
        User::create([
            'name' => 'ADAF',
            'email' => 'adaf@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'atty'
        ]);
        User::create([
            'name' => 'Campus Director',
            'email' => 'cd@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'campus_director'
        ]);
        User::create([
            'name' => 'Business Manager',
            'email' => 'bm@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'business_manager'
        ]);
        User::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Professor',
            'email' => 'prof@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'professor'
        ]);
        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff'
        ]);
    }
}
