<?php

namespace Abr4xas\Location\Commands;

use Illuminate\Console\Command;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class CitiesCommand extends Command
{
    use \Abr4xas\Location\Traits\MakeRequestTrait;

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
     * @return void
     */
    public function handle()
    {
        $states = \Abr4xas\Location\Models\State::pluck('code', 'id');

        $token = $this->argument('token');

        $this->getOutput()->progressStart(count($states));
        foreach ($states as $id => $code) {
            $cityResponse = $this->makeRequest($token, 'https://api.mercadolibre.com/classified_locations/states/' . $code);
            $cities = $cityResponse->json();

            foreach ($cities['cities'] as $key) {
                \Abr4xas\Location\Models\City::updateOrCreate([
                    'code' => $key['id'],
                ], [
                    'name' => $key['name'],
                    'code' => $key['id'],
                    'latitude' => $cities['geo_information']['location']['latitude'],
                    'longitude' => $cities['geo_information']['location']['longitude'],
                    'state_id' => $id,
                    'slug' => \Illuminate\Support\Str::slug($key['name']),
                ]);
            }
            $this->getOutput()->progressAdvance();
        }

        $this->getOutput()->progressFinish();
    }
}
