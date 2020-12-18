<?php
namespace App\ExternalClients;

use GuzzleHttp\Client;

class RestClient {
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $endpoint, array $options) : Array
    {
        return [];
    }

    public function post(string $endpoint, array $options) : Array
    {
        return [];
    }
}