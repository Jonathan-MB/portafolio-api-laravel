<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // insercion de estados a base de datos

        $states = [
            [
                'state_name' => 'Pendiente',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'state_name' => 'Realizado',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ];



        DB::table('states')->insert($states);
    }
}
