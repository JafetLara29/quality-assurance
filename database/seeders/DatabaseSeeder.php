<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        User::factory()->create([
            'name' => 'Administrator',
            'password' => Hash::make('system_admin@+'),
            'email' => 'jafetlara29.11.2000@gmail.com',
            'type' => 'Admin',
        ]);
    }
}
