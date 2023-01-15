<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        /*
        $password = bcrypt('password');

        User::factory()->create([
            'first_name' => 'Micael',
            'last_name' => 'Micael',
            'email' => 'micael@test.com',
            'password' => $password
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => $password,
            'role' => true
        ]);

        User::factory()->count(10)->create(['password' => $password]);
        */
    }
}
