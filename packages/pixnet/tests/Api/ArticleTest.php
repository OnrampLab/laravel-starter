<?php

namespace OnrampLab\Pixnet\Api;

use Tests\TestCase;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ArticleTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = Client::create();

        $this->leadInfo = [
            'auth_token' => 'test_token',
            // API metadata
            'list_id' => '3862',
            // API details
            'lead_id' => '2122933',
            'province' => 'Test',
            'first_name' => 'Anita',
            'last_name' => 'Wang',
            'phone_number' => '1234567890',
            'email' => 'test1234567890@test.com',
            'postal_code' => '90017',
            'city' => 'LA',
            'state' => 'CA',
            'address1' => 'test address',
            'comments' => 'Test Comment',
        ];

        $this->filters = [
            'format' => 'json',
            'type' => 'tag',
            'key' => '台東熱氣球',
        ];
    }

    public function test_search_success() {
        $data = [
            'success' => true,
            'data' => [
                'offset' => 0,
                'limit' => 10,
                'total' => 1,
                'entries' => [
                    [
                        'id' => 5,
                        'created_at' => '2015-01-29T14:09:57-0800',
                        'status' => 'CALLBK',
                        'phone_number' => "8181234561",
                    ],
                ],
            ],
        ];
        $httpClient = $this->getHttpClient(200, json_encode($data));

        // $this->client->setHttpClient($httpClient);

        $result = $this->client->article->search($this->filters);
        $articles = $result['articles'];

        $this->assertEquals(count($articles), 19);
    }

    private function getHttpClient($status, $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        return $client;
    }
}
