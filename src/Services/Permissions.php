<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Permissions
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function get(int $id)
    {
        return $this->http->get("/api/v2/datasets/{$id}/permissions/");
    }

    public function update(int $id, array $payload)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/permissions/", $payload);
    }

    public function makePublic(int $id)
    {
        return $this->update($id, ['is_published' => true]);
    }

    public function makePrivate(int $id)
    {
        return $this->update($id, ['is_published' => false]);
    }
}
