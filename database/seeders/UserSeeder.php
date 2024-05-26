<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // creacion de usuario predefinido

        $correoPredefinido = 'jmarin@ejemplo.com';

        if (!User::where('email', $correoPredefinido)->exists()) {

            DB::table('users')->insert([
                'name' => 'Jonathan',
                'email' => 'jmarin@ejemplo.com',
                'password' => Hash::make('123456'),
                'rol_id' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
        // creacion de usuarios en por factory

        User::factory(10)->create();
    }
}
