<?php
namespace Tests\src\Reposotories;

use App\ExternalClients\RestClient;
use App\Repositories\GetTokenRepository;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\Argument;

class GetTokenRepositoryTest extends PHPUnit_TestCase {
    public function testGetTokenSuccess()
    {
        $mockResponse = '{
            "access_token": "BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE",
            "token_type": "Bearer",
            "expires_in": 3600,
            "scope": ""
        }';

        $restClient = $this->prophesize(RestClient::class);
        $restClient->post(Argument::any(), Argument::any())->willReturn(json_decode($mockResponse, true));

        $getTokenRepository = new GetTokenRepository($restClient->reveal());

        $this->assertEquals(
            'BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE',
            $getTokenRepository('6qqNVTkY8uBg9cP3Jd7DAH')
        );
    }
}