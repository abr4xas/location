<?php

namespace Abr4xas\Location\Commands;

use App\Models\City;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cities';

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
        $states = State::pluck('code', 'id');

        $this->getOutput()->progressStart(count($states));
        foreach ($states as $id => $code) {
            $cityResponse = $this->makeRequest('https://api.mercadolibre.com/classified_locations/states/' . $code);
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
                    'slug' => \Illuminate\Support\Str::slug($key['name']),
                ]);
            }
            $this->getOutput()->progressAdvance();
        }

        $this->getOutput()->progressFinish();
    }

    public function makeRequest($url)
    {
        return Http::get($url);
    }
}
