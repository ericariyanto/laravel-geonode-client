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

    public function list(array $filters = [])
    {
        return $this->http->get('/api/v2/users/', $filters);
    }

    public function show(int $id)
    {
        return $this->http->get("/api/v2/users/{$id}/");
    }

    public function search(string $query)
    {
        return $this->http->get('/api/v2/users/', ['search' => $query]);
    }
}
