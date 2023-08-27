<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Modules\User\App\Models\User;
use Spatie\Permission\Models\Permission;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'user']);
        // Permission::create(['name' => 'show users']);
        // Permission::create(['name' => 'create']);
        // Permission::create(['name' => 'edit']);
        // Permission::create(['name' => 'delete']);
        

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
