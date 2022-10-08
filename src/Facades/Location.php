<?php

namespace Abr4xas\Location\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abr4xas\Location\Location
 */
class Location extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Abr4xas\Location\Location::class;
    }
}
