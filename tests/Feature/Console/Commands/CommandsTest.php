<?php

use Abr4xas\Location\Commands\CitiesCommand;
use Abr4xas\Location\Commands\NeighborhoodsCommand;
use Abr4xas\Location\Commands\StatesCommand;
use function Pest\Laravel\artisan;
use Symfony\Component\Console\Exception\RuntimeException;

it('can\'t run StatesCommand without params', function () {
    artisan(StatesCommand::class);
})->throws(RuntimeException::class);

it('can import country data', function () {
    artisan(StatesCommand::class, [
        'country' => 'AR',
        'token' => 'AR',
    ])
    ->expectsConfirmation('Do you wish to continue?', false)
    ->expectsOutput('Ok...')
    ->assertExitCode(0);
});

it('can\'t run StatesCommand without token', function () {
    artisan(StatesCommand::class, [
        'country' => 'AR',
    ])
        ->assertExitCode(1);
})->throws(RuntimeException::class, 'Not enough arguments (missing: "token")');

it('can\'t run CitiesCommand without token', function () {
    artisan(CitiesCommand::class);
})->throws(RuntimeException::class, 'Not enough arguments (missing: "token")');

it('can\'t run NeighborhoodsCommand without token', function () {
    artisan(NeighborhoodsCommand::class);
})->throws(RuntimeException::class, 'Not enough arguments (missing: "token")');
