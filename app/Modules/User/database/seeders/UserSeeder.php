<?php

namespace Modules\User\Database\Seeders;

use App\Modules\User\App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username'=>'mjcoder',
            'email'=>'testj9369@gmail.com',
            'first_name'=>'test',
            'last_name'=>'j',
            'is_active'=>1,
            'is_admin'=>1,
            'password'=>bcrypt('$M1a2r3a4$')
        ]);

        User::factory()->hasAddresses(1)->count(5)->create();
    }
}
