<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Keywords
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $params = [])
    {
        $result = $this->http->get('/api/v2/keywords/', $params);
        $result['data'] = $result['keywords'] ?? [];
        if ( !empty($result['keywords']) ) {
            unset($result['keywords']);
        }

        return $result;
    }

    public function show(int $id, array $params = [])
    {
        $result = $this->http->get("/api/v2/keywords/{$id}/", $params);

        return $result['keywords'] ?? null;
    }

}
