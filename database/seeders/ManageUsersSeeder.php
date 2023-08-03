<?php

namespace Database\Seeders;

use App\Models\ManageUsers;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ManageUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ManageUsers::factory()->create([
            'username'=>'mjcoder',
            'email'=>'testj9369@gmail.com',
            'first_name'=>'test',
            'last_name'=>'j',
            'is_active'=>1,
            'is_admin'=>1,
            'password'=>bcrypt('$M1a2r3a4$')
        ]);

        ManageUsers::factory()->hasAddresses(3)->count(5)->create();
    }
}
