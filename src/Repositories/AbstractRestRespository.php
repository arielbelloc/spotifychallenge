<?php
namespace App\Repositories;

use App\ExternalClients\RestClient;
use App\Services\ResponseHandler;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractRestRespository
{
    protected $restClient;
    
    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
    }

    protected function getEndpoint(string $path) : string
    {
        /** TODO: Set this in config file */
        $protocol = 'https';
        $domain = 'api.spotify.com';

        $endpoint = sprintf('%s://%s%s', $protocol, $domain, $path);

        return $endpoint;
    }
}