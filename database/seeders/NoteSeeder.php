<?php

namespace Database\Seeders;

use App\Models\Note;
use Database\Factories\NoteFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class NoteSeeder extends Seeder
{
    public function run(): void
    {

        // creacion de notas por factory

        Note::factory(15)->create();
    }
}
