<?php

namespace Abr4xas\Location\Commands;

use Illuminate\Console\Command;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class NeighborhoodsCommand extends Command
{
    use \Abr4xas\Location\Traits\MakeRequestTrait;

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

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $cities = \Abr4xas\Location\Models\City::pluck('code', 'id');

        $token = $this->argument('token');

        $this->getOutput()->progressStart(count($cities));
        foreach ($cities as $id => $code) {
            $neighborhoodsResponse = $this->makeRequest($token, 'https://api.mercadolibre.com/classified_locations/cities/' . $code);
            $neighborhoods = $neighborhoodsResponse->json();

            if (! empty($neighborhoods['neighborhoods'])) {
                foreach ($neighborhoods['neighborhoods'] as $key) {
                    \Abr4xas\Location\Models\Neighborhood::updateOrCreate([
                        'code' => $key['id'],
                    ], [
                        'name' => $key['name'],
                        'code' => $key['id'],
                        'latitude' => $neighborhoods['geo_information']['location']['latitude'],
                        'longitude' => $neighborhoods['geo_information']['location']['longitude'],
                        'city_id' => $id,
                        'slug' => \Illuminate\Support\Str::slug($key['name']),
                    ]);
                }

                $this->getOutput()->progressAdvance();
            }
            $this->info('');
            $this->info("Al parecer, el código [{$code}] no tiene barrios ¯\_(ツ)_/¯");
        }

        $this->info('');
        $this->getOutput()->progressFinish();
    }
}
