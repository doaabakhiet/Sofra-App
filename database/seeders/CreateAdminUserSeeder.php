<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'bosy',
            'email' => 'bosy@me.com',
            'password' => bcrypt('123456')
            ]);
            $role = Role::create(['name' => 'User']);
            $permissions = Permission::pluck('id','id')->first();
            $role->syncPermissions($permissions);
            $user->assignRole([$role->id]);
    }
}
