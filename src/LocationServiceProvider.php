<?php

namespace Abr4xas\Location;

use Abr4xas\Location\Commands\CitiesCommand;
use Abr4xas\Location\Commands\NeighborhoodsCommand;
use Abr4xas\Location\Commands\StatesCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LocationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('location')
            ->hasMigrations([
                'create_states_table',
                'create_cities_table',
                'create_neighborhoods_table',
            ])
            ->hasCommands([
                StatesCommand::class,
                CitiesCommand::class,
                NeighborhoodsCommand::class,
            ]);
    }
}
