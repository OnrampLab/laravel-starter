<?php

namespace OnrampLab\Pixnet\Api;

use Exception;
class Article
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(array $query) {
        $url = $this->client->getEndPoint('blog/articles/search');

        $payload = [
            'query' => $query,
        ];

        $response = $this->client->request('GET', $url, $payload);

        $result = $this->parseResultFromResponse($response);

        return $result;
    }

    protected function parseResultFromResponse($response): array
    {
        $body = json_decode($response->getBody(), true);

        return $body;
    }
}
