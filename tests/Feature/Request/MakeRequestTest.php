<?php

use Illuminate\Support\Facades\Http;

it('can make a http request', function () {
    $response = Http::get('https://api.mercadolibre.com/classified_locations/countries/VE');

    expect($response->ok())
        ->toBeTrue()
        ->and($response->json())
        ->toBeArray()
        ->and($response->json()['name'])
        ->toBe('Venezuela');
});
