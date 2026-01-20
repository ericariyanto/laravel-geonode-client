<?php

namespace EricAriyanto\LaravelGeoNodeClient\Services;

use EricAriyanto\LaravelGeoNodeClient\Exceptions\GeoNodeException;
use EricAriyanto\LaravelGeoNodeClient\Http\HttpClient;

class Upload
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function process(array $payload, array $files = [])
    {
        return $this->http->upload('/api/v2/uploads/upload/', $files, $payload);
    }

    public function show(string $execId)
    {
        $result = $this->http->get("/api/v2/executionrequest/{$execId}/");
        return $result['request'] ?? [];
    }

    public function list(array $filters = [])
    {
        return $this->http->get("/api/v2/executionrequest", $filters);
    }

    // /* Auto detect file type */
    // protected function detect(string $path): string
    // {
    //     $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    //     return match ($ext) {
    //         'zip' => 'shapefile',
    //         'geojson' => 'geojson',
    //         'tif','tiff' => 'raster',
    //         'gpkg' => 'geopackage',
    //         default => throw new GeoNodeException("Unsupported file type: $ext"),
    //     };
    // }

    // /* Full upload with metadata */
    // public function upload(string $filePath, array $metadata = [])
    // {
    //     $type = $this->detect($filePath);

    //     $meta = array_merge([
    //         'charset' => 'UTF-8',
    //         'publish' => true,
    //         'permissions' => [
    //             'is_published' => true,
    //         ],
    //     ], $metadata);

    //     return $this->http->upload('/api/v2/datasets/upload/', 'base_file', $filePath, [
    //         'file_type' => $type,
    //         'metadata' => json_encode($meta),
    //     ]);
    // }

    // /* Async upload: returns task ID */
    // public function uploadAsync(string $filePath, array $metadata = [])
    // {
    //     $type = $this->detect($filePath);

    //     return $this->http->upload('/api/v2/uploads/async/', 'base_file', $filePath, [
    //         'file_type' => $type,
    //         'metadata' => json_encode($metadata),
    //     ]);
    // }

    // /* Polling task status */
    // public function checkTask(string $taskId)
    // {
    //     return $this->http->get("/api/v2/uploads/tasks/{$taskId}/");
    // }
}
