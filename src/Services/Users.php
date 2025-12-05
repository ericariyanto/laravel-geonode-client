<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Users
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $params = [])
    {
        return $this->http->get('/api/v2/users/', $params);
    }

    public function show(int $id, array $params = [])
    {
        return $this->http->get("/api/v2/users/{$id}/", $params);
    }

    public function search(string $query)
    {
        return $this->http->get('/api/v2/users/', ['search' => $query]);
    }
}
