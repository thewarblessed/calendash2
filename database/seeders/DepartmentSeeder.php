<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'department' => 'BASD - BACHELOR OF ARTS AND SCIENCE DEPARTMENT'
        ]);
        Department::create([
            'department' => 'CAAD - CIVIL AND ALLIED DEPARTMENT'
        ]);
        Department::create([
            'department' => 'EAAD - ELECTRICAL AND ALLIED DEPARTMENT'
        ]);
        Department::create([
            'department' => 'MAAD - MECHANICAL AND ALLIED DEPARTMENT'
        ]);
        Department::create([
            'department' => 'BENG - TEMPORARY'
        ]);
        Department::create([
            'department' => 'Clinic'
        ]);
        Department::create([
            'department' => 'Registrar'
        ]);
        Department::create([
            'department' => 'Library'
        ]);
        Department::create([
            'department' => 'Accounting'
        ]);
        Department::create([
            'department' => 'Faculty'
        ]);
    }
}
