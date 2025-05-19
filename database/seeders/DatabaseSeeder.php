<?php

namespace Database\Seeders;

use App\Models\Blog;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Commend;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RoleAndPremissonSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(RoleAndPremissonSeeder::class);

        // User::factory(10)->create();

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'phone' =>  '070619131',
        //     'password' => Hash::make('admin'),
        // ])->assignRole('admin');

        // User::create([
        //     'name' => 'editor',
        //     'email' => 'editor@editor.com',
        //     'phone' =>  '070619131',
        //     'password' => Hash::make('editor'),
        // ])->assignRole('editor');   

        // Blog::factory(100)->create();


        // Commend::factory(5)->create();

        Comment::factory(100)->create();
    }
}
