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

    protected function base()
    {
        $req = Http::timeout($this->config['timeout'] ?? 30)
            ->withHeaders($this->config['headers'] ?? [])
            ->baseUrl(rtrim($this->config['base_url'], '/'));

        if (($this->config['auth'] ?? 'basic') === 'token') {
            $req = $req->withToken($this->config['token']);
        } else {
            $req = $req->withBasicAuth($this->config['username'], $this->config['password']);
        }

        return $req;
    }

    protected function parse($resp)
    {
        if ($resp->clientError() || $resp->serverError()) {
            throw new GeoNodeException($resp->body());
        }

        return str_contains($resp->header('Content-Type'), 'json')
            ? $resp->json()
            : $resp->body();
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

    public function upload(string $uri, string $field, string $filePath, array $other = [])
    {
        if (! file_exists($filePath)) {
            throw new GeoNodeException("File $filePath does not exist");
        }

        $fileContent = fopen($filePath, 'r');

        $req = $this->base();
        foreach ($other as $k => $v) {
            $req = $req->attach($k, $v);
        }

        $resp = $req->attach($field, $fileContent, basename($filePath))->post($uri);

        if (is_resource($fileContent)) {
            fclose($fileContent);
        }

        return $this->parse($resp);
    }
}
