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


    public function assignDataset(int $datasetId, string $group)
    {
        return $this->http->patch("/api/v2/datasets/{$datasetId}/", ["group" => $group]);
    }


    public function removeDatasetGroup(int $datasetId)
    {
        return $this->http->patch("/api/v2/datasets/{$datasetId}/", ["group" => null]);
    }
}