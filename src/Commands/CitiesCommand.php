<?php

namespace Abr4xas\Location\Commands;

use Abr4xas\Location\Models\City;
use Abr4xas\Location\Models\State;
use Abr4xas\Location\Traits\MakeRequestTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CitiesCommand extends Command
{
    use MakeRequestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meli:cities {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cities from a specific state';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $token = $this->argument('token');

        if (! $token) {
            $this->error('You need to provide a token');

            return self::FAILURE;
        }

        $states = State::pluck('code', 'id');
        $this->getOutput()->progressStart(count($states));
        foreach ($states as $id => $code) {
            $cityResponse = $this->makeRequest($token, 'https://api.mercadolibre.com/classified_locations/states/'.$code);
            $cities = $cityResponse->json();

            foreach ($cities['cities'] as $key) {
                City::updateOrCreate([
                    'code' => $key['id'],
                ], [
                    'name' => $key['name'],
                    'code' => $key['id'],
                    'latitude' => $cities['geo_information']['location']['latitude'],
                    'longitude' => $cities['geo_information']['location']['longitude'],
                    'state_id' => $id,
                    'slug' => Str::slug($key['name']),
                ]);
            }
            $this->getOutput()->progressAdvance();
        }

        $this->getOutput()->progressFinish();

        return self::SUCCESS;
    }
}
