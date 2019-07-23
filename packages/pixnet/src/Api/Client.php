<?php

namespace OnrampLab\Pixnet\Api;

use GuzzleHttp\Client as HttpClient;

class Client
{
    public $article;

    protected $httpClient;

    public static function create(HttpClient $httpClient = null): Client
    {
        // Find a default HTTP client if none provided
        if (null === $httpClient) {
            $httpClient = new HttpClient();
        }

        $client = new Client();
        $client->httpClient = $httpClient;
        $client->article = new Article($client);

        return $client;
    }

    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getEndPoint($action = ''): string
    {
        return "https://emma.pixnet.cc/$action";
    }

    public function request(string $method, string $url, array $payload = null, array $options = null)
    {
        return $this->httpClient->request($method, $url, $payload, $options);
    }
}
