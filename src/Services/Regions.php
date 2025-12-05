<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Regions
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $params = [])
    {
        $result = $this->http->get('/api/v2/regions/', $params);
        $result['data'] = $result['regions'] ?? [];
        if ( !empty($result['regions']) ) {
            unset($result['regions']);
        }

        return $result;
    }

    public function show(int $id, array $params = [])
    {
        $result = $this->http->get("/api/v2/regions/{$id}/", $params);

        return $result['regions'] ?? null;
    }

}
