<?php
namespace Tests\src\Reposotories;

use App\Entities\ArtistEntity;
use App\ExternalClients\RestClient;
use App\Repositories\FindFirstArtistByNameRepository;
use App\Repositories\GetTokenRepository;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\Argument;

class FindFirstArtistByNameRepositoryTest extends PHPUnit_TestCase {
    public function testFindFirstArtistByNameSuccess()
    {
        $mockResponse = '{
            "artists": {
                "items": [
                    {
                        "id": "1MuQ2m2tg7naeRGAOxYZer"
                    }
                ],
                "limit": 10,
                "next": null,
                "offset": 0,
                "previous": null,
                "total": 1
            }
        }';

        $restClient = $this->prophesize(RestClient::class);
        $restClient->get(Argument::any(), Argument::any())->willReturn(json_decode($mockResponse, true));

        $getTokenRepository = $this->createPartialMock(GetTokenRepository::class, [
            '__invoke',
        ]);

        $getTokenRepository
            ->method('__invoke')
            ->willReturn('BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE');

        $findArtistByNameRepository = new FindFirstArtistByNameRepository($restClient->reveal(), $getTokenRepository);

        $artist =  $findArtistByNameRepository('Luis Alberto Spinetta');
        $this->assertInstanceOf(ArtistEntity::class, $artist);
        $this->assertEquals('1MuQ2m2tg7naeRGAOxYZer', $artist->getId());
    }

    public function testEndpointSuccess()
    {
        $mockResponse = '{
            "artists": {
                "items": [
                    {
                        "id": "1MuQ2m2tg7naeRGAOxYZer"
                    }
                ]
            }
        }';

        $restClient = $this->prophesize(RestClient::class);
        $restClient->get('https://api.spotify.com/v1/search', Argument::any())->willReturn(json_decode($mockResponse, true));

        $getTokenRepository = $this->createPartialMock(GetTokenRepository::class, [
            '__invoke',
        ]);

        $getTokenRepository
            ->method('__invoke')
            ->willReturn('BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE');

        $findArtistByNameRepository = new FindFirstArtistByNameRepository($restClient->reveal(), $getTokenRepository);

        $artist =  $findArtistByNameRepository('Luis Alberto Spinetta');
        $this->assertInstanceOf(ArtistEntity::class, $artist);
        $this->assertEquals('1MuQ2m2tg7naeRGAOxYZer', $artist->getId());
    }

    public function testRequestOptionsSuccess()
    {
        $mockResponse = '{
            "artists": {
                "items": [
                    {
                        "id": "1MuQ2m2tg7naeRGAOxYZer"
                    }
                ]
            }
        }';

        $restClient = $this->prophesize(RestClient::class);

        $mockToken = 'BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE';
        
        /** TODO: Do this mocking a config file */
        $options = [
            'query' => [
                'q' => 'Luis Alberto Spinetta',
                'type' => 'artist',
                'limit' => '10',
                'offset' => '0',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $mockToken
            ]
        ];

        $restClient->get(Argument::any(), $options)->willReturn(json_decode($mockResponse, true));

        $getTokenRepository = $this->createPartialMock(GetTokenRepository::class, [
            '__invoke',
        ]);

        $getTokenRepository
            ->method('__invoke')
            ->willReturn($mockToken);

        $findArtistByNameRepository = new FindFirstArtistByNameRepository($restClient->reveal(), $getTokenRepository);

        $artist =  $findArtistByNameRepository('Luis Alberto Spinetta');
        $this->assertInstanceOf(ArtistEntity::class, $artist);
        $this->assertEquals('1MuQ2m2tg7naeRGAOxYZer', $artist->getId());
    }
}