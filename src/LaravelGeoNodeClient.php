<?php

namespace EricAriyanto\LaravelGeoNodeClient;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class LaravelGeoNodeClient
{
    protected HttpClient $http;

    public function __construct(array $config = [])
    {
        $this->http = new HttpClient($config ?: config('geonode-client') ?: []);
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

    public function groups(): Services\Groups
    {
        return new Services\Groups($this->http);
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
        return new Services\Styles($this->http);
    }
}
