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
        // $admin = Role::create(['name' => 'admin']);
        $admin = Role::findByName('admin');
        // $editor =  Role::create(['name' => 'editor']);
        // $conference = Role::create(['name' => 'conference']);
        // Permission::create(['name' => 'editor']);
        // Permission::create(['name' => 'admin']);
        // Permission::create(['name' => 'conference']);
        $admin->givePermissionTo(Permission::all());
        // $editor->givePermissionTo('editor');
        // $conference->givePermissionTo('conference');
    }
}
