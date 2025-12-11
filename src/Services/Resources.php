<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Resources
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $params = [])
    {
        $result = $this->http->get('/api/v2/resources/', $params);
        $result['data'] = $result['resources'] ?? [];
        if ( !empty($result['resources']) ) {
            unset($result['resources']);
        }

        return $result;
    }

    public function show(int $id, array $params = [])
    {
        $result = $this->http->get("/api/v2/resources/{$id}/", $params);

        return $result['resource'] ?? null;
    }

    public function create(array $payload)
    {
        if ( !isset($payload['resource']) ) {
            $payload['resource'] = 1;
        }
        
        $result = $this->http->post('/api/v2/resources/', [
            'resource' => $payload,
        ]);

        return $result['resource'] ?? null;
    }

    public function update(int $id, array $payload)
    {
        if ( !isset($payload['resource']) ) {
            $payload['resource'] = 1;
        }

        $result = $this->http->patch("/api/v2/resources/{$id}/", [
            'resource' => $payload,
        ]);

        return $result['resource'] ?? null;
    }

    public function delete(int $id)
    {
        return $this->http->delete("/api/v2/resources/{$id}/");
    }

    public function assignDataset(int $datasetId, string $resource)
    {
        return $this->http->patch("/api/v2/datasets/{$datasetId}/", ['resource' => $resource]);
    }

    public function removeDatasetGroup(int $datasetId)
    {
        return $this->http->patch("/api/v2/datasets/{$datasetId}/", ['resource' => null]);
    }
}
