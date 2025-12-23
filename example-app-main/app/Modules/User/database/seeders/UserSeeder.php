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
        $viewUsers = Permission::firstOrCreate(['name' => 'View Users', 'guard_name' => 'web']);
        $create = Permission::firstOrCreate(['name' => 'Create', 'guard_name' => 'web']);
        $edit = Permission::firstOrCreate(['name' => 'Edit', 'guard_name' => 'web']);
        $delete = Permission::firstOrCreate(['name' => 'Delete', 'guard_name' => 'web']);

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo([$viewUsers,$create,$edit,$delete]);
        Role::firstOrCreate(['name' => 'User']);
        

        $user = User::factory()->create([
            'username'=>'mjcoder',
            'email'=>'testj9369@gmail.com',
            'first_name'=>'test',
            'last_name'=>'j',
            'is_active'=>1,
            'is_admin'=>1,
            'password'=>bcrypt('$T1e2s3t4$')
        ]);
        $user->assignRole('Admin');
        $user->givePermissionTo([$viewUsers,$create,$edit,$delete]);

        User::factory()->hasAddresses(1)->count(5)->create();
    }
}
