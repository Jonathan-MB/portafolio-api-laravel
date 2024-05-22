<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisibilitySeeder extends Seeder
{

    public function run(): void
    {

        // insercion de visibilidades a base de datos

        $visibilities = [
            [
                'visibility_name' => 'Publico',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'visibility_name' => 'Privado',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ];

        DB::table('visibilities')->insert($visibilities);
    }
}
