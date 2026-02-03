<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Exceptions\GeoNodeException;
use EricAriyanto\LaravelGeoNodeClient\Http\HttpClientGeoServer;

class Styles
{
    protected HttpClientGeoServer $http;

    public function __construct(HttpClientGeoServer $http)
    {
        $this->http = $http;
    }

    /**
     * List styles
     */
    public function list(array $query = [], string $workspace = 'geonode')
    {
        $list = $this->http->get("/workspaces/{$workspace}/styles", $query);
        return $list['styles']['style'] ?? [];
    }

    /**
     * Get style metadata
     */
    public function show(string $style, array $params = [], string $workspace = 'geonode')
    {
        $data = $this->http->get("/workspaces/{$workspace}/styles/{$style}", $params);
        return $data['style'] ?? [];
    }

    public function update(string $style, mixed $payload, $params = [], string $workspace = 'geonode')
    {
        $params['headers']['contentType'] ??= 'application/vnd.ogc.sld+xml';
        $result = $this->http->put("/workspaces/{$workspace}/styles/{$style}",$payload, $params);

        return $result;
    }

    public function create(int $id, mixed $payload, $params = [], string $workspace = 'geonode')
    {
        $params['headers']['contentType'] ??= 'application/vnd.ogc.sld+xml';
        $result = $this->http->post("/workspaces/{$workspace}/styles",$payload, $params);

        return $result;
    }

    public function delete(string $style, string $workspace = 'geonode')
    {
        return $this->http->delete("/workspaces/{$workspace}/styles/{$style}");
    }

    // /**
    //  * Get raw SLD (as string) - GeoNode may expose a specific endpoint for SLD; fallback to 'sld' field if available
    //  */
    // public function getSld(string $name)
    // {
    //     $resp = $this->show($name);

    //     // If response contains 'sld' or 'sld_body' return it
    //     if (is_array($resp) && (isset($resp['sld']) || isset($resp['sld_body']))) {
    //         return $resp['sld'] ?? $resp['sld_body'];
    //     }

    //     // Try fetch raw endpoint
    //     try {
    //         $raw = $this->http->get("/api/v2/styles/{$name}/raw/");

    //         return is_array($raw) ? ($raw['sld'] ?? json_encode($raw)) : $raw;
    //     } catch (GeoNodeException $e) {
    //         throw new GeoNodeException("Unable to fetch SLD for style {$name}: ".$e->getMessage());
    //     }
    // }

    // /**
    //  * Upload or update a style by name. If $replace is true, PATCH; otherwise try POST.
    //  * $sldContent should be raw SLD/XML string.
    //  */
    // public function upload(string $name, string $sldContent, bool $replace = true)
    // {
    //     // GeoNode style endpoints may accept multipart or direct body
    //     $payload = [
    //         'name' => $name,
    //         'sld' => $sldContent,
    //     ];

    //     if ($replace) {
    //         return $this->http->patch("/api/v2/styles/{$name}/", $payload);
    //     }

    //     return $this->http->post('/api/v2/styles/', $payload);
    // }

    // /**
    //  * Sync style to a layer: associate style name to layer resource
    //  */
    // public function assignToLayer(string $layerName, string $styleName)
    // {
    //     // GeoNode layer update usually via layers endpoint
    //     return $this->http->patch("/api/v2/layers/{$layerName}/", [
    //         'style' => $styleName,
    //     ]);
    // }

    // /**
    //  * Helper: copy style content from GeoNode into GeoServer via GeoNode/GeoServer integration endpoints if available
    //  */
    // public function syncToGeoServer(string $styleName)
    // {
    //     // Some GeoNode instances expose an endpoint to sync style to GeoServer
    //     try {
    //         return $this->http->post("/api/v2/styles/{$styleName}/sync/");
    //     } catch (GeoNodeException $e) {
    //         // If not available, return error
    //         throw new GeoNodeException("Sync to GeoServer failed for style {$styleName}: ".$e->getMessage());
    //     }
    // }
}
