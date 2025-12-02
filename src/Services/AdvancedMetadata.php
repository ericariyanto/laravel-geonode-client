<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class AdvancedMetadata
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Update bounding box (bbox) for a dataset.
     * $bbox = [minx, miny, maxx, maxy]
     */
    public function updateBbox(int $id, array $bbox)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'bbox' => $bbox,
        ]);
    }

    /**
     * Update temporal extent. Accepts ISO 8601 strings or arrays.
     * $temporal = ['start' => 'YYYY-MM-DD', 'end' => 'YYYY-MM-DD']
     */
    public function updateTemporal(int $id, array $temporal)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'temporal_extent' => $temporal,
        ]);
    }

    /**
     * Update license information
     */
    public function updateLicense(int $id, array $license)
    {
        // license example: ['id' => 'cc-by', 'url' => 'https://creativecommons.org/licenses/by/4.0/']
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'license' => $license,
        ]);
    }

    /**
     * Update contact metadata
     */
    public function updateContact(int $id, array $contact)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'contact' => $contact,
        ]);
    }

    /**
     * Update attribution / citation
     */
    public function updateAttribution(int $id, array $attrib)
    {
        return $this->http->patch("/api/v2/datasets/{$id}/", [
            'attribution' => $attrib,
        ]);
    }

    /**
     * Helper: fully update a set of advanced metadata in single call
     */
    public function updateAll(int $id, array $data)
    {
        // Accept keys: bbox, temporal_extent, license, contact, attribution, categories
        return $this->http->patch("/api/v2/datasets/{$id}/", $data);
    }
}
