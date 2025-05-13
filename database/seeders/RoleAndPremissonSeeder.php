<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPremissonSeeder extends Seeder
{

    public function run(): void
    {
        $admin =   Role::create(['name' => 'admin']);
        $editor =  Role::create(['name' => 'editor']);
        Permission::create(['name' => 'editor']);
       Permission::create(['name' => 'admin']);

        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo('editor');

    }
}
