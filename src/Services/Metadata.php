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

    /**
     * Update multiple basic metadata fields at once.
     */
    public function update(int $id, array $data)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", $data);
    }

    public function updateTitle(int $id, string $title)
    {
        return $this->update($id, ['title' => $title]);
    }

    public function updateAbstract(int $id, string $abstract)
    {
        return $this->update($id, ['abstract' => $abstract]);
    }

    public function updatePurpose(int $id, string $purpose)
    {
        return $this->update($id, ['purpose' => $purpose]);
    }

    public function updateCategory(int $id, string $category)
    {
        return $this->update($id, ['category' => $category]);
    }

    public function updateKeywords(int $id, array $keywords)
    {
        return $this->update($id, ['keywords' => $keywords]);
    }

    public function updateRegions(int $id, array $regions)
    {
        return $this->update($id, ['regions' => $regions]);
    }

    public function updateGroup(int $id, ?string $group)
    {
        return $this->update($id, ['group' => $group]);
    }

    public function updateLicense(int $id, array $license)
    {
        return $this->update($id, ['license' => $license]);
    }
}
