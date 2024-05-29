<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RefreshDatabase extends Command
{
    protected $signature = 'refresh:database';

    protected $descripion = 'Actualizar base de datos eliminando todas las tablas, ejecutando migraciones , seeders y factories';

    public function handle()
    {
        try {

            // Desactiva restriccion foreign key 
            if (config('database.default') == 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            }


            $tables = DB::connection()->getSchemaBuilder()->getTables();

            // Elimina todas las tablas de base de datos
            foreach ($tables as $table) {
                DB::statement("DROP TABLE {$table['name']} CASCADE");
            }


            // Ejecutar migraciones
            Artisan::call('migrate');

            // Ejecutar seeders / factories
            Artisan::call('db:seed');


            // Reactiva restricciones foreign key
            if (config('database.default') == 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            }

            // Log de éxito
            Log::info('Database refreshed exitosamente.');
            $this->info('Database refreshed exitosamente.');


        } catch (\Exception $ex) {
            // Log de error
            Log::error('Error refreshing database: ' . $ex->getMessage());
            $this->error('Error refreshing database: ' . $ex->getMessage());
        }
    }
}
