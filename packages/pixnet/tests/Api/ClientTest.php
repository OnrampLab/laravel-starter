<?php

namespace OnrampLab\Pixnet\Api;

use Tests\TestCase;

class ClientTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = Client::create('test');
    }

    public function test_properties()
    {
        $this->assertNotNull($this->client->lead);
    }

    public function test_getEndPoint()
    {
        $result = $this->client->getEndPoint();
        $expected = 'https://api.convoso.com/v1/';

        $this->assertEquals($result, $expected);
    }
}
