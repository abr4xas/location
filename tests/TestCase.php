<?php

namespace Abr4xas\Location\Tests;

use Abr4xas\Location\LocationServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Abr4xas\\Location\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LocationServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);


        include_once __DIR__.'/../database/migrations/2020_10_17_000001_create_states_table.php.stub';
        include_once __DIR__.'/../database/migrations/2020_10_17_000002_create_cities_table.php.stub';
        include_once __DIR__.'/../database/migrations/2020_10_17_000003_create_neighborhoods_table.php.stub';
        (new \CreateStatesTable())->up();
        (new \CreateCitiesTable())->up();
        (new \CreateNeighborhoodsTable())->up();
    }
}
