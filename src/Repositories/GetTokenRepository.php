<?php
namespace App\Repositories;

use App\ExternalClients\RestClient;

class GetTokenRepository
{
    private $restClient;
    private $accessToken;
    
    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
    }

    public function __invoke() : string
    {
        if (is_null($this->accessToken)) 
        {
            /** TODO: Use a config file */
            $authToken = 'OWRjZWU2ODU0ODhjNDM3NzgwNzZhZWFkNmZiZTk5OTQ6ZjQwNzNiODcwN2UyNGQxYTkzYzFkMjA4YzhmYzM3Y2E=';
            $endpoint = $this->getEndpoint('/api/token');
            $options = [
                'headers' => [
                    'Authorization' => 'Basic ' . $authToken,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json'
                ],
                'form_params' => ['grant_type' => 'client_credentials']
            ];

            $response = $this->restClient->post($endpoint, $options);

            $this->accessToken = $response['access_token'];
        }

        return $this->accessToken;
    }

    protected function getEndpoint(string $path) : string
    {
        /** TODO: Do this with a config file */
        $protocol = 'https';
        $domain = 'accounts.spotify.com';

        $endpoint = sprintf('%s://%s%s', $protocol, $domain, $path);

        return $endpoint;
    }
}