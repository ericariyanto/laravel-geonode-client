<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Datasets
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function list(array $filters = [])
    {
        $result = $this->http->get('/api/v2/datasets/', $filters);
        $result['data'] = $result['datasets'] ?? [];
        if ( !empty($result['datasets']) ) {
            unset($result['datasets']);
        }
    }

    public function show(int $id)
    {
        $result = $this->http->get("/api/v2/datasets/{$id}/");
        return $result['dataset'] ?? null;
    }

    public function update(int $id, array $payload)
    {
        $result = $this->http->patch("/api/v2/datasets/{$id}/",$payload);

        return $result['dataset'] ?? null;
    }

    public function delete(int $id)
    {
        return $this->http->delete("/api/v2/datasets/{$id}/");
    }

    // public function uploadFile(string $filePath, array $extra = [])
    // {
    //     return $this->http->upload('/api/v2/datasets/upload/', 'base_file', $filePath, $extra);
    // }
}
