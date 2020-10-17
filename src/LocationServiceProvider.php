<?php

namespace Abr4xas\Location;

use Abr4xas\Location\Commands\LocationCommand;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../models' => base_path('app/Models'),
        ], 'models');

        if ($this->app->runningInConsole()) {
            $migrationsFileName = [
                'create_states_table.php',
                'create_cities_table.php',
                'create_neighborhoods_table.php',
            ];

            foreach ($migrationsFileName as $migration) {
                if (! $this->migrationFileExists($migration)) {
                    $this->publishes([
                        __DIR__ . "/../database/migrations/{$migration}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migration),
                    ], 'migrations');
                }
            }

            $this->commands([
                LocationCommand::class,
            ]);
        }
    }

    public function register()
    {
        //
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
