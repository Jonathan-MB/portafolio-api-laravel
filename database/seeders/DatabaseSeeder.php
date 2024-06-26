<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // llamada a seeders

        $this->call(RolSeeder::class);
        $this->call(VisibilitySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NoteSeeder::class);

    }
}
