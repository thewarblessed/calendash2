<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Official;
use Illuminate\Support\Facades\Hash;

class OfficialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $department = null;

            if ($user->role === 'department_head') {
                $department = 'EAAD';
            }
            elseif($user->role === 'org_adviser'){
                $department = 'MTICS';
            }
            

            Official::create([
                'user_id' => $user->id,
                'esign' => 'esign.jpg',
                'department' => $department,
                'hash' => Hash::make('passcode'),
            ]);
        }
    }
}
