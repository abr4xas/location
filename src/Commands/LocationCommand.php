<?php

namespace Abr4xas\Location\Commands;

use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class LocationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:states-from {country=AR}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import states from a specific country';

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
        $country = $this->argument('country');
        $statesResponse = $this->makeRequest("https://api.mercadolibre.com/classified_locations/countries/{$country}");

        $states = $statesResponse->json();

        if (! empty($states)) {
            $this->getOutput()->progressStart(count($states));
            foreach ($states['states'] as $key) {
                State::updateOrCreate([
                    'code' => $key['id'],
                ], [
                    'name' => $key['name'],
                    'code' => $key['id'],
                    'slug' => \Illuminate\Support\Str::slug($key['name']),
                ]);

                $this->getOutput()->progressAdvance();
            }

            $this->getOutput()->progressFinish();
        }
    }

    public function makeRequest($url)
    {
        return Http::get($url);
    }
}
