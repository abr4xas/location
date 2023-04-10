<?php

namespace Abr4xas\Location\Commands;

use Abr4xas\Location\Models\City;
use Abr4xas\Location\Models\Neighborhood;
use Abr4xas\Location\Traits\MakeRequestTrait;
use Illuminate\Console\Command;

class NeighborhoodsCommand extends Command
{
    use MakeRequestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meli:neighborhoods {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import neighborhoods from a specific city';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /** Execute the console command. */
    public function handle(): int
    {
        $token = $this->argument('token');

        if (! $token) {
            $this->error('You need to provide a token');

            return self::FAILURE;
        }

        $cities = City::pluck('code', 'id');
        $this->getOutput()->progressStart(count($cities));
        foreach ($cities as $id => $code) {
            $neighborhoodsResponse = $this->makeRequest($token, 'https://api.mercadolibre.com/classified_locations/cities/'.$code);
            $neighborhoods = $neighborhoodsResponse->json();

            if (! empty($neighborhoods['neighborhoods'])) {
                foreach ($neighborhoods['neighborhoods'] as $key) {
                    Neighborhood::updateOrCreate([
                        'code' => $key['id'],
                    ], [
                        'name' => $key['name'],
                        'code' => $key['id'],
                        'latitude' => $neighborhoods['geo_information']['location']['latitude'],
                        'longitude' => $neighborhoods['geo_information']['location']['longitude'],
                        'city_id' => $id,
                        'slug' => str()->slug($key['name']),
                    ]);
                }

                $this->getOutput()->progressAdvance();
            }
            $this->info('');
            $this->info("Al parecer, el código [{$code}] no tiene barrios ¯\_(ツ)_/¯");
        }

        $this->info('');
        $this->getOutput()->progressFinish();

        return self::SUCCESS;
    }
}
