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
            'department' => 'QA/Accreditation'
        ]);
        Department::create([
            'department' => 'Directors Office/Planning Office'
        ]);
        Department::create([
            'department' => 'ADAA/DH/SH/SC'
        ]);
        Department::create([
            'department' => 'ADRE/Industry Based Program'
        ]);
        Department::create([
            'department' => 'ADAF/HR/IDO/Maint/Aux/Proc/Supply'
        ]);
        Department::create([
            'department' => 'OSA/Registrar/Medical/LRC/USG'
        ]);
        Department::create([
            'department' => 'Accounting/Budget/Cashier'
        ]);
        Department::create([
            'department' => 'Records'
        ]);
        Department::create([
            'department' => 'Faculty'
        ]);
    }
}
