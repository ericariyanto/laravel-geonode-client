<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Categories
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $params = [])
    {
        $result = $this->http->get('/api/v2/categories/', $params);
        $result['data'] = $result['categories'] ?? [];
        if ( !empty($result['categories']) ) {
            unset($result['categories']);
        }

        return $result;
    }

    public function show(int $id, array $params = [])
    {
        $result = $this->http->get("/api/v2/categories/{$id}/", $params);

        return $result['categories'] ?? null;
    }

}
