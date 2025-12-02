<?php

namespace EricAriyanto\LaravelGeoNodeClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EricAriyanto\LaravelGeoNodeClient\LaravelGeoNodeClient
 */
class LaravelGeoNodeClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \EricAriyanto\LaravelGeoNodeClient\LaravelGeoNodeClient::class;
    }
}
