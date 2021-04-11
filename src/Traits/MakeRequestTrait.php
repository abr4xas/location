<?php
namespace Abr4xas\Location\Traits;

trait MakeRequestTrait
{
    /**
     * makeRequest
     *
     * @param string $url
     * @return \Illuminate\Http\Client\Response
     */
    public function makeRequest(string $token, string $url)
    {
        return \Illuminate\Support\Facades\Http::withToken($token)->get($url);
    }
}
