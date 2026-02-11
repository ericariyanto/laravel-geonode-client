<?php

namespace EricAriyanto\LaravelGeoNodeClient\Http;

use EricAriyanto\LaravelGeoNodeClient\Exceptions\GeoNodeException;
use Illuminate\Support\Facades\Http;

class HttpClient
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function base(array $params = [])
    {
        $headers = array_merge($this->config["headers"] ?? [], ($params['headers'] ?? []));
        $req = Http::timeout($this->config['timeout'] ?? 30)
                ->withHeaders($headers)
                ->baseUrl(rtrim($this->config['base_url'], '/'));

        if (($this->config['auth'] ?? 'basic') === 'token') {
            $req = $req->withToken($this->config['token']);
        } else {
            $req = $req->withBasicAuth($this->config['username'], $this->config['password']);
        }

        if ( !empty($params['withBody']) ) {
            $req = $req->withBody($params['withBody']['content'], $params['withBody']['contentType']);
        }

        return $req;
    }

    public function parse($resp)
    {
        if ($resp->successful()) {
            return $this->parseResponseBody($resp);
        }

        // If GeoNode returns JSON error, try decode it
        $json = null;

        try {
            $json = $resp->json();
        } catch (\Throwable $e) {
            // ignore
        }

        if (is_array($json)) {
            // JSON error payload
            throw new GeoNodeException(json_encode($json, JSON_PRETTY_PRINT));
        }

        // Fallback: return raw body (may be HTML error)
        throw new GeoNodeException($resp->body() ?: 'GeoNode API error: empty response');
    }

    /**
     * Safe JSON parser
     */
    protected function parseResponseBody($resp)
    {
        if (str_contains($resp->header('Content-Type'), 'json')) {
            return $resp->json();
        }

        $body = $resp->body();
        if ( empty($body) ) {
            return ['success' => true];
        }

        return $body;
    }

    public function get($uri, $q = [])
    {
        return $this->parse($this->base()->get($uri, $q));
    }

    public function post($uri, $d = [])
    {
        return $this->parse($this->base()->post($uri, $d));
    }

    public function patch($uri, $d = [])
    {
        return $this->parse($this->base()->patch($uri, $d));
    }

    public function delete($uri)
    {
        return $this->parse($this->base()->delete($uri));
    }

    public function upload(string $uri, array $attachments = [], array $payload = [])
    {
        $req          = $this->base();
        $fileContents = [];
        foreach($attachments as $key => $value) {
            if (! file_exists($value)) {
                throw new GeoNodeException("File {$value} does not exist");
            }

            $fileContents[$key] = fopen($value, 'r');
            $req = $req->attach($key, $fileContents[$key]);
        }

        $resp = $req->post($uri, $payload);

        foreach($attachments as $key => $value) {
            if (file_exists($value) && isset($fileContents[$key])) {
                if (is_resource($fileContents[$key])) {
                        fclose($fileContents[$key]);
                    }
            }
        }

        return $this->parse($resp);
    }

    // public function upload(string $uri, string $field, string $filePath, array $other = [])
    // {
    //     if (! file_exists($filePath)) {
    //         throw new GeoNodeException("File $filePath does not exist");
    //     }

    //     $fileContent = fopen($filePath, 'r');

    //     $req = $this->base();
    //     foreach ($other as $k => $v) {
    //         $req = $req->attach($k, $v);
    //     }

    //     $resp = $req->attach($field, $fileContent, basename($filePath))->post($uri);

    //     if (is_resource($fileContent)) {
    //         fclose($fileContent);
    //     }

    //     return $this->parse($resp);
    // }
}
