<?php

namespace EricAriyanto\LaravelGeoNodeClient;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;
use EricAriyanto\LaravelGeoNodeClient\Http\HttpClientGeoServer;

class LaravelGeoNodeClient
{
    protected HttpClient $http;
    protected HttpClientGeoServer $httpGeoServer;

    public function __construct(array $config = [])
    {
        $this->http          = new HttpClient($config ?: config('laravel-geonode-client') ?: []);
        $this->httpGeoServer = new HttpClientGeoServer($config ?: config('laravel-geonode-client') ?: []);
    }

    public function http()
    {
        return $this->http;
    }

    public function httpGeoServer()
    {
        return $this->httpGeoServer;
    }

    public function datasets(): Services\Datasets
    {
        return new Services\Datasets($this->http);
    }

    public function layers(): Services\Layers
    {
        return new Services\Layers($this->http);
    }

    public function metadata(): Services\Metadata
    {
        return new Services\Metadata($this->http);
    }

    public function advancedMetadata(): Services\AdvancedMetadata
    {
        return new Services\AdvancedMetadata($this->http);
    }

    public function permissions(): Services\Permissions
    {
        return new Services\Permissions($this->http);
    }

    public function categories(): Services\Categories
    {
        return new Services\Categories($this->http);
    }

    public function regions(): Services\Regions
    {
        return new Services\Regions($this->http);
    }

    public function keywords(): Services\Keywords
    {
        return new Services\Keywords($this->http);
    }

    public function groups(): Services\Groups
    {
        return new Services\Groups($this->http);
    }

    public function resources(): Services\Resources
    {
        return new Services\Resources($this->http);
    }

    public function users(): Services\Users
    {
        return new Services\Users($this->http);
    }

    public function upload(): Services\Upload
    {
        return new Services\Upload($this->http);
    }

    public function styles(): Services\Styles
    {
        return new Services\Styles($this->httpGeoServer);
    }
}
