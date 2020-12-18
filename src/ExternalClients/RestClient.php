<?php
namespace App\ExternalClients;

use GuzzleHttp\Client;

class RestClient {
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function call(string $method, string $endpoint, array $options) : Array
    {
        try{
            $rawResponse = $this->client->request($method, $endpoint, $options);
            $body = json_decode(trim($rawResponse->getBody()->getContents()), true);
        } catch (\GuzzleHttp\Exception\ClientException $e)  {
            if ($e->getResponse()) {
                $body = json_decode(trim($e->getResponse()->getBody()->getContents()));
            } else {
                throw new \Exception('external api error', 500);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new \Exception('external api error', 500);
        } catch (\Exception $e) {
            throw new \Exception('external api error', 500);
        }

        return $body;
    }

    public function get(string $endpoint, array $options) : Array
    {
        return $this->call(self::GET_METHOD, $endpoint, $options);
    }

    public function post(string $endpoint, array $options) : Array
    {
        return $this->call(self::POST_METHOD, $endpoint, $options);
    }
}