<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Metadata
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function updateTags(int $id, array $tags)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'keywords' => $tags,
        ]);
    }

    public function updateRegions(int $id, array $regions)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'regions' => $regions,
        ]);
    }

    public function updateGroup(int $id, string $group)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'group' => $group,
        ]);
    }
}
