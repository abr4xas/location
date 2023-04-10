<?php

namespace Abr4xas\Location\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait MakeRequestTrait
{
    /** makeRequest */
    public function makeRequest(string $token, string $url): Response
    {
        return Http::withToken($token)->get($url);
    }
}
