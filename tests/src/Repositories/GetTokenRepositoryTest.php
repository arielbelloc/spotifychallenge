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

    public function testEndpointSuccess()
    {
        $mockResponse = '{
            "access_token": "BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE"
        }';

        $restClient = $this->prophesize(RestClient::class);

        /** TODO: Do this mocking a config file */
        $restClient->post('https://accounts.spotify.com/api/token', Argument::any())->willReturn(json_decode($mockResponse, true));

        $getTokenRepository = new GetTokenRepository($restClient->reveal());

        $this->assertEquals(
            'BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE',
            $getTokenRepository('6qqNVTkY8uBg9cP3Jd7DAH')
        );
    }

    public function testRequestOptionsSuccess()
    {
        $mockResponse = '{
            "access_token": "BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE"
        }';

        $restClient = $this->prophesize(RestClient::class);

        /** TODO: Do this mocking a config file */
        $options = [
            'headers' => [
                'Authorization' => 'Basic OWRjZWU2ODU0ODhjNDM3NzgwNzZhZWFkNmZiZTk5OTQ6ZjQwNzNiODcwN2UyNGQxYTkzYzFkMjA4YzhmYzM3Y2E=',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ],
            'form_params' => ['grant_type' => 'client_credentials']
        ];
        $restClient->post(Argument::any(), $options)->willReturn(json_decode($mockResponse, true));

        $getTokenRepository = new GetTokenRepository($restClient->reveal());

        $this->assertEquals(
            'BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE',
            $getTokenRepository('6qqNVTkY8uBg9cP3Jd7DAH')
        );
    }
}