<?php
namespace App\Repositories;

use App\ExternalClients\RestClient;

class GetTokenRepository
{
    private $restClient;
    
    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
    }

    public function __invoke() : string
    {
        return 'OWRjZWU2ODU0ODhjNDM3NzgwNzZhZWFkNmZiZTk5OTQ6ZjQwNzNiODcwN2UyNGQxYTkzYzFkMjA4YzhmYzM3Y2E=';
    }
}