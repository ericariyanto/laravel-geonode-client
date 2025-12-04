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
        $result = $this->http->get('/api/v2/groups/');
        $result['data'] = $result['group_profiles'] ?? [];

        return $result;
    }

    public function show(int $id)
    {
        $result = $this->http->get("/api/v2/groups/{$id}/");
        return $result['group_profile'] ?? null;
    }

    public function create(array $payload)
    {
        $result = $this->http->post('/api/v2/groups/', [
            'group_profile' => $payload
        ]);
        return $result['group_profile'] ?? null;
    }

    public function update(int $id, array $payload)
    {
        $result = $this->http->patch("/api/v2/groups/{$id}/", [
            'group_profile' => $payload
        ]);
        return $result['group_profile'] ?? null;
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
