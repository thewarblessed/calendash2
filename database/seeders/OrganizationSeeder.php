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
            'organization' => 'ACES'
        ]);
        Organization::create([
            'org_name' => 'Bachelor Science in Electrical Engineering Guild',
            'organization' => 'BSEEG'
        ]);
        Organization::create([
            'org_name' => 'Dies and Moulds Makers Society',
            'organization' => 'DMMS'
        ]);
        Organization::create([
            'org_name' => 'Green Chemistry Society',
            'organization' => 'GreeCS'
        ]);
        Organization::create([
            'org_name' => 'Institute of Electronics Engineering Phils.',
            'organization' => 'IECEP'
        ]);
        Organization::create([
            'org_name' => 'Junior Philippine Society of Mechanical Engineers',
            'organization' => 'JPSME'
        ]);
        Organization::create([
            'org_name' => 'Junior Society of Heating Ventilating Air Conditioning Engineers',
            'organization' => 'JSHRAE-TUPT'
        ]);
        Organization::create([
            'org_name' => 'Manila Technician Institute Computer Society',
            'organization' => 'MTICS'
        ]);
        Organization::create([
            'org_name' => 'Mechanical Technologists and Leaders Society',
            'organization' => 'METALS'
        ]);
        Organization::create([
            'org_name' => 'Mechatronics and Robotics Society of the Philippines Taguig Student Council',
            'organization' => 'MRSP-TSC'
        ]);
        Organization::create([
            'org_name' => 'Technical Educators Society - TUP Taguig',
            'organization' => 'TEST-TUP Taguig'
        ]);
        Organization::create([
            'org_name' => 'Techno-Arts of Graphics Technology Students',
            'organization' => 'TAAGTS'
        ]);
        Organization::create([
            'org_name' => 'TUPT Society of Non Destructive Testing',
            'organization' => 'TUP-TSNT'
        ]);
        Organization::create([
            'org_name' => 'DOST Scholars for Innovation and Technology',
            'organization' => 'D\'SAITECH'
        ]);
        Organization::create([
            'org_name' => 'Peer Facilitators Group',
            'organization' => 'PFG'
        ]);
        Organization::create([
            'org_name' => 'Catholic Youth Movement',
            'organization' => 'CYM'
        ]);
        Organization::create([
            'org_name' => 'Christian Brotherhood International',
            'organization' => 'CBI'
        ]);
        Organization::create([
            'org_name' => 'Manila Technician Institute Christian Fellowship',
            'organization' => 'MTICF'
        ]);
        Organization::create([
            'org_name' => 'TUPT PLUS Network',
            'organization' => 'PLUS'
        ]);
    }
}
