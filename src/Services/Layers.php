<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Layers
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $filters = [])
    {
        return $this->http->get('/api/v2/layers/', $filters);
    }

    public function show(string $name)
    {
        return $this->http->get("/api/v2/layers/{$name}/");
    }
}
