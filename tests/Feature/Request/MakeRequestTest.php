<?php
namespace Abr4xas\Location\Tests\Feature\Request;

use Abr4xas\Location\Tests\TestCase;
use Illuminate\Support\Facades\Http;


class MakeRequestTest extends TestCase
{
    public const COUNTRY_VE = 'https://api.mercadolibre.com/classified_locations/countries/VE';

    public function test_it_can_make_request()
    {
        $response = Http::get(self::COUNTRY_VE);
        $this->assertIsBool($response->ok());
    }
}
