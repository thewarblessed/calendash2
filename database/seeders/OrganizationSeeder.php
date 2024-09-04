<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Organization::create([
            'org_name' => 'Association of Civil Engineering Students of TUP Taguig Campus',
            'organization' => 'ACES',
            'department_id' =>  2
        ]);
        Organization::create([
            'org_name' => 'Bachelor Science in Electrical Engineering Guild',
            'organization' => 'BSEEG',
            'department_id' =>  3
        ]);
        Organization::create([
            'org_name' => 'Dies and Moulds Makers Society',
            'organization' => 'DMMS',
            'department_id' =>  4
        ]);
        Organization::create([
            'org_name' => 'Green Chemistry Society',
            'organization' => 'GreeCS',
            'department_id' =>  2
        ]);
        Organization::create([
            'org_name' => 'Institute of Electronics Engineering Phils.',
            'organization' => 'IECEP',
            'department_id' =>  3
        ]);
        Organization::create([
            'org_name' => 'Junior Philippine Society of Mechanical Engineers',
            'organization' => 'JPSME',
            'department_id' =>  4
        ]);
        Organization::create([
            'org_name' => 'Junior Society of Heating Ventilating Air Conditioning Engineers',
            'organization' => 'JSHRAE-TUPT',
            'department_id' =>  4
        ]);
        Organization::create([
            'org_name' => 'Manila Technician Institute Computer Society',
            'organization' => 'MTICS',
            'department_id' =>  3
        ]);
        Organization::create([
            'org_name' => 'Mechanical Technologists and Leaders Society',
            'organization' => 'METALS',
            'department_id' =>  4
        ]);
        Organization::create([
            'org_name' => 'Mechatronics and Robotics Society of the Philippines Taguig Student Council',
            'organization' => 'MRSP-TSC',
            'department_id' =>  4
        ]);
        Organization::create([
            'org_name' => 'Technical Educators Society - TUP Taguig',
            'organization' => 'TEST-TUP Taguig',
            'department_id' =>  1
        ]);
        Organization::create([
            'org_name' => 'Techno-Arts of Graphics Technology Students',
            'organization' => 'TAAGTS',
            'department_id' =>  2
        ]);
        Organization::create([
            'org_name' => 'TUPT Society of Non Destructive Testing',
            'organization' => 'TUP-TSNT',
            'department_id' =>  2
        ]);
        Organization::create([
            'org_name' => 'DOST Scholars for Innovation and Technology',
            'organization' => 'D\'SAITECH',
            'department_id' =>  1
        ]);
        Organization::create([
            'org_name' => 'Peer Facilitators Group',
            'organization' => 'PFG',    
            'department_id' =>  1
        ]);
        Organization::create([
            'org_name' => 'Catholic Youth Movement',
            'organization' => 'CYM',
            'department_id' =>  1
        ]);
        Organization::create([
            'org_name' => 'Christian Brotherhood International',
            'organization' => 'CBI',
            'department_id' =>  1
        ]);
        Organization::create([
            'org_name' => 'Manila Technician Institute Christian Fellowship',
            'organization' => 'MTICF',
            'department_id' =>  1
        ]);
        Organization::create([
            'org_name' => 'TUPT PLUS Network',
            'organization' => 'PLUS',
            'department_id' =>  1
        ]);
    }
}
