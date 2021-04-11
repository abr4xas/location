<?php

namespace Abr4xas\Location\Commands;

use Illuminate\Console\Command;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class LocationCommand extends Command
{
    use \Abr4xas\Location\Traits\MakeRequestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meli:states-from {country} {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import states from a specific country using their ISO Alpha-2 code';

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
        $token = $this->argument('token');

        if ($this->confirm('Do you wish to continue?', true)) {
            $statesResponse = $this->makeRequest($token, 'https://api.mercadolibre.com/classified_locations/countries/'. $country);

            $states = $statesResponse->json();

            if (! empty($states)) {
                $this->getOutput()->progressStart(count($states));
                foreach ($states['states'] as $key) {
                    \Abr4xas\Location\Models\State::updateOrCreate([
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

        $this->info('Ok...');
    }
}
