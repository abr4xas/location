<?php
namespace Abr4xas\Location\Tests\Feature\Commands;

use Abr4xas\Location\Commands\LocationCommand;
use Abr4xas\Location\Tests\TestCase;

class LocationCommandTest extends TestCase
{
    /** @test */
    public function test_if_can_import_country_data()
    {
        $this->artisan(LocationCommand::class)
            ->expectsQuestion('What is your country code?', 'AR')
            ->expectsConfirmation('Do you wish to continue?', false)
            ->expectsOutput('Ok...')
            ->assertExitCode(0);
    }
}
