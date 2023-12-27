<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::create([
            'name' => 'nahed',
            'email' => 'nahed@gmail.com',
            'password' => bcrypt('123456'),
            'Status' => 'مفعل',
            'admin'=>'1'
        ]);
        $user = User::create([
            'name' => 'Test User',
             'email' => 'test@yahoo.com',
            'password' => bcrypt('123456'),
            'Status' => 'مفعل',
            'admin'=>'0'
        ]);




    }
}
