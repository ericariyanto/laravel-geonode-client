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
        return $this->http->get('/api/v2/datasets/', $filters);
    }


    public function show(int $id)
    {
        return $this->http->get("/api/v2/datasets/{$id}/");
    }


    public function create(array $payload)
    {
        return $this->http->post('/api/v2/datasets/', $payload);
    }


    public function update(int $id, array $payload)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", $payload);
    }


    public function delete(int $id)
    {
        return $this->http->delete("/api/v2/datasets/{$id}/");
    }


    public function uploadFile(string $filePath, array $extra = [])
    {
        return $this->http->upload('/api/v2/datasets/upload/', 'base_file', $filePath, $extra);
    }
}