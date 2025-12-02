<?php
namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;
use EricAriyanto\LaravelGeoNodeClient\Exceptions\GeoNodeException;

class Styles
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List styles
     */
    public function list(array $filters = [])
    {
        return $this->http->get('/api/v2/styles/', $filters);
    }

    /**
     * Get style metadata
     */
    public function show(string $name)
    {
        return $this->http->get("/api/v2/styles/{$name}/");
    }

    /**
     * Get raw SLD (as string) - GeoNode may expose a specific endpoint for SLD; fallback to 'sld' field if available
     */
    public function getSld(string $name)
    {
        $resp = $this->show($name);

        // If response contains 'sld' or 'sld_body' return it
        if (is_array($resp) && (isset($resp['sld']) || isset($resp['sld_body']))) {
            return $resp['sld'] ?? $resp['sld_body'];
        }

        // Try fetch raw endpoint
        try {
            $raw = $this->http->get("/api/v2/styles/{$name}/raw/");
            return is_array($raw) ? ($raw['sld'] ?? json_encode($raw)) : $raw;
        } catch (GeoNodeException $e) {
            throw new GeoNodeException("Unable to fetch SLD for style {$name}: " . $e->getMessage());
        }
    }

    /**
     * Upload or update a style by name. If $replace is true, PATCH; otherwise try POST.
     * $sldContent should be raw SLD/XML string.
     */
    public function upload(string $name, string $sldContent, bool $replace = true)
    {
        // GeoNode style endpoints may accept multipart or direct body
        $payload = [
            'name' => $name,
            'sld' => $sldContent,
        ];

        if ($replace) {
            return $this->http->patch("/api/v2/styles/{$name}/", $payload);
        }

        return $this->http->post('/api/v2/styles/', $payload);
    }

    /**
     * Sync style to a layer: associate style name to layer resource
     */
    public function assignToLayer(string $layerName, string $styleName)
    {
        // GeoNode layer update usually via layers endpoint
        return $this->http->patch("/api/v2/layers/{$layerName}/", [
            'style' => $styleName,
        ]);
    }

    /**
     * Helper: copy style content from GeoNode into GeoServer via GeoNode/GeoServer integration endpoints if available
     */
    public function syncToGeoServer(string $styleName)
    {
        // Some GeoNode instances expose an endpoint to sync style to GeoServer
        try {
            return $this->http->post("/api/v2/styles/{$styleName}/sync/");
        } catch (GeoNodeException $e) {
            // If not available, return error
            throw new GeoNodeException("Sync to GeoServer failed for style {$styleName}: " . $e->getMessage());
        }
    }
}