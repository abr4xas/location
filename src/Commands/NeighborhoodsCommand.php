<?php

namespace Abr4xas\Location\Commands;

use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NeighborhoodsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:neighborhoods';

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
        $cities = City::pluck('code', 'id');

        $this->getOutput()->progressStart(count($cities));
        foreach ($cities as $id => $code) {
            $neighborhoodsResponse = $this->makeRequest('https://api.mercadolibre.com/classified_locations/cities/' . $code);
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

    public function makeRequest($url)
    {
        return Http::get($url);
    }
}
