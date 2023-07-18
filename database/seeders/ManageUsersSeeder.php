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
        ManageUsers::factory()->hasAddresses(3)->count(5)->create();
    }
}
