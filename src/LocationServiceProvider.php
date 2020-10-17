<?php

namespace Abr4xas\Location;

use Illuminate\Support\ServiceProvider;
use Abr4xas\Location\Commands\CitiesCommand;
use Abr4xas\Location\Commands\LocationCommand;
use Abr4xas\Location\Commands\NeighborhoodsCommand;

class LocationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../models' => base_path('app/Models'),
        ], 'models');

        if ($this->app->runningInConsole()) {
            $migrationsFileName = [
                '2020_10_17_000001_create_states_table.php',
                '2020_10_17_000002_create_cities_table.php',
                '2020_10_17_000003_create_neighborhoods_table.php',
            ];

            foreach ($migrationsFileName as $migration) {
                if (! $this->migrationFileExists($migration)) {
                    $this->publishes([
                        __DIR__ . "/../database/migrations/{$migration}.stub" => database_path('migrations/' . $migration),
                    ], 'migrations');
                }
            }

            $this->commands([
                LocationCommand::class,
                CitiesCommand::class,
                NeighborhoodsCommand::class
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
