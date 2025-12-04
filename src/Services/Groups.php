<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Groups
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list()
    {
        return $this->http->get('/api/v2/groups/');
    }

    public function show(int $id)
    {
        return $this->http->get("/api/v2/groups/{$id}/");
    }

    public function create(array $payload)
    {
        return $this->http->post('/api/v2/groups/', $payload);
    }

    public function update(int $id, array $payload)
    {
        return $this->http->patch("/api/v2/groups/{$id}/", $payload);
    }

    public function delete(int $id)
    {
        return $this->http->delete("/api/v2/groups/{$id}/");
    }

    public function assignDataset(int $datasetId, string $group)
    {
        return $this->http->patch("/api/v2/datasets/{$datasetId}/", ['group' => $group]);
    }

    public function removeDatasetGroup(int $datasetId)
    {
        return $this->http->patch("/api/v2/datasets/{$datasetId}/", ['group' => null]);
    }
}
