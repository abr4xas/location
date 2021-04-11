<?php
namespace Abr4xas\Location\Tests\Feature\Commands;

use Abr4xas\Location\Commands\LocationCommand;
use Abr4xas\Location\Tests\TestCase;
use Symfony\Component\Console\Exception\RuntimeException;

class LocationCommandTest extends TestCase
{
    /** @test */
    public function test_importing_without_arguments()
    {
        $this->expectException(RuntimeException::class);
        $this->artisan(LocationCommand::class);
    }

    /** @test */
    public function test_if_can_import_country_data()
    {
        $this->artisan(LocationCommand::class, [
                'country' => 'AR',
                'token' => 'AR',
            ])
            ->expectsConfirmation('Do you wish to continue?', false)
            ->expectsOutput('Ok...')
            ->assertExitCode(0);
    }
}
