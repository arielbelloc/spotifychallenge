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
        return 'BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE';
    }
}