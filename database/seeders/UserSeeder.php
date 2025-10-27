<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        $users = User::factory()->count(5)->create();

        foreach ($users as $user) {
            $user->assignRole('Demandeur');
        }

        $techs = $users->random(2);

        foreach ($techs as $tech) {
            $tech->syncRoles(['Technicien']);
        }
    }
}
