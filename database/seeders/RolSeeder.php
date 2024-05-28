<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // insercion de roles a base de datos

        $rols = [
            [
                'rol_name' => 'Master',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'rol_name' => 'Administrador',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'rol_name' => 'Usuario',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ];

        DB::table('rols')->insert($rols);
    }
}
