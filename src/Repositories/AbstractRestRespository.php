<?php
namespace App\Repositories;

use App\ExternalClients\RestClient;
use App\Services\ResponseHandler;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractRestRespository
{
    protected $restClient;
    protected $getTokenRepository;
    
    public function __construct(RestClient $restClient, GetTokenRepository $getTokenRepository)
    {
        $this->restClient = $restClient;
        $this->getTokenRepository = $getTokenRepository;
    }

    protected function getEndpoint(string $path) : string
    {
        /** TODO: Set this in config file */
        $protocol = 'https';
        $domain = 'api.spotify.com';

        $endpoint = sprintf('%s://%s%s', $protocol, $domain, $path);

        return $endpoint;
    }

    protected function setAuthorizationHeader(&$options) {
        $token = ($this->getTokenRepository)();
        $authHeader = ['Authorization' => 'Bearer ' . $token];
        $options['headers'] = ($options['headers'] ?? []) + $authHeader;
    }
}