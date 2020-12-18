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
            /** TODO: Do this with a config file */
            $endpoint = $this->getEndpoint('/api/token');
            $response = $this->restClient->post($endpoint, []);

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