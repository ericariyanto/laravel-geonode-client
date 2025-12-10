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

    public function list(array $params = [])
    {
        return $this->http->get('/api/v2/layers/', $params);
    }

    public function show(string $name, array $params = [])
    {
        return $this->http->get("/api/v2/layers/{$name}/", $params);
    }
}
