<?php

use App\Console\Commands\RefreshDatabase;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Ejecuta limpiza DB todos los dias a la 1 am Colombia

Schedule::command('refresh:database')->dailyAt('1:00');