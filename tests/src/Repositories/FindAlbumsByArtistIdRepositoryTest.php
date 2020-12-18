<?php
namespace Tests\src\Reposotories;

use App\ExternalClients\RestClient;
use App\Repositories\FindAlbumsByArtistIdRepository;
use App\Repositories\GetTokenRepository;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\Argument;

class FindAlbumsByArtistIdRepositoryTest extends PHPUnit_TestCase {
    public function testFindArtistByNameSuccess()
    {
        $serviceResponse = '{
            "href": "https://api.spotify.com/v1/artists/6qqNVTkY8uBg9cP3Jd7DAH/albums?offset=0&limit=50&include_groups=album",
            "items": [
                {
                    "images": [
                        {
                            "height": 640,
                            "url": "https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce",
                            "width": 640
                        },
                        {
                            "height": 300,
                            "url": "https://i.scdn.co/image/ab67616d00001e0250a3147b4edd7701a876c6ce",
                            "width": 300
                        },
                        {
                            "height": 64,
                            "url": "https://i.scdn.co/image/ab67616d0000485150a3147b4edd7701a876c6ce",
                            "width": 64
                        }
                    ],
                    "name": "WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?",
                    "release_date": "2019-03-29",
                    "total_tracks": 14
                }
            ],
            "limit": 50,
            "next": null,
            "offset": 0,
            "previous": null,
            "total": 1
        }';

        $restClient = $this->prophesize(RestClient::class);
        $restClient->get(Argument::any(), Argument::any())->willReturn(json_decode($serviceResponse, true));

        $getTokenRepository = $this->createPartialMock(GetTokenRepository::class, [
            '__invoke',
        ]);

        $getTokenRepository
            ->method('__invoke')
            ->willReturn('BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE');

        $findAlbumsByArtistIdRepository = new FindAlbumsByArtistIdRepository($restClient->reveal(), $getTokenRepository);

        $mockResponse = [
            [
                'name' => 'WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?',
                'released' => '2019-03-29',
                'tracks' => 14,
                'cover' => [
                    'height' => 640,
                    'url' => 'https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce',
                    'width' => 640
                ],
            ]
        ];

        $this->assertEquals($mockResponse, $findAlbumsByArtistIdRepository('6qqNVTkY8uBg9cP3Jd7DAH'));
    }

    public function testFindArtistByNameWithRecursivitySuccess()
    {
        $serviceResponseFirstCall = '{
            "href": "https://api.spotify.com/v1/artists/6qqNVTkY8uBg9cP3Jd7DAH/albums?offset=0&limit=50&include_groups=album",
            "items": [
                {
                    "images": [
                        {
                            "height": 640,
                            "url": "https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce",
                            "width": 640
                        },
                        {
                            "height": 300,
                            "url": "https://i.scdn.co/image/ab67616d00001e0250a3147b4edd7701a876c6ce",
                            "width": 300
                        },
                        {
                            "height": 64,
                            "url": "https://i.scdn.co/image/ab67616d0000485150a3147b4edd7701a876c6ce",
                            "width": 64
                        }
                    ],
                    "name": "WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?",
                    "release_date": "2019-03-29",
                    "total_tracks": 14
                }
            ],
            "limit": 50,
            "next": "https://api.spotify.com/v1/search?query=Beatles&type=artist&offset=90&limit=1",
            "offset": 0,
            "previous": null,
            "total": 1
        }';

        $serviceResponseSecondCall = '{
            "href": "https://api.spotify.com/v1/artists/6qqNVTkY8uBg9cP3Jd7DAH/albums?offset=0&limit=50&include_groups=album",
            "items": [
                {
                    "images": [
                        {
                            "height": 640,
                            "url": "https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce",
                            "width": 640
                        },
                        {
                            "height": 300,
                            "url": "https://i.scdn.co/image/ab67616d00001e0250a3147b4edd7701a876c6ce",
                            "width": 300
                        },
                        {
                            "height": 64,
                            "url": "https://i.scdn.co/image/ab67616d0000485150a3147b4edd7701a876c6ce",
                            "width": 64
                        }
                    ],
                    "name": "WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?",
                    "release_date": "2019-03-29",
                    "total_tracks": 14
                }
            ],
            "limit": 50,
            "next": null,
            "offset": 0,
            "previous": null,
            "total": 1
        }';

        $restClient = $this->prophesize(RestClient::class);
        $restClient->get(Argument::any(), Argument::any())->willReturn(
            json_decode($serviceResponseFirstCall, true),
            json_decode($serviceResponseSecondCall, true),
        );

        $getTokenRepository = $this->createPartialMock(GetTokenRepository::class, [
            '__invoke',
        ]);

        $getTokenRepository
            ->method('__invoke')
            ->willReturn('BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE');

        $findAlbumsByArtistIdRepository = new FindAlbumsByArtistIdRepository($restClient->reveal(), $getTokenRepository);

        $mockResponse = [
            [
                'name' => 'WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?',
                'released' => '2019-03-29',
                'tracks' => 14,
                'cover' => [
                    'height' => 640,
                    'url' => 'https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce',
                    'width' => 640
                ],
            ],
            [
                'name' => 'WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?',
                'released' => '2019-03-29',
                'tracks' => 14,
                'cover' => [
                    'height' => 640,
                    'url' => 'https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce',
                    'width' => 640
                ],
            ]
        ];

        $this->assertEquals($mockResponse, $findAlbumsByArtistIdRepository('6qqNVTkY8uBg9cP3Jd7DAH'));
    }

    public function testEndpointSuccess()
    {
        $serviceResponse = '{
            "items": [
                {
                    "images": [
                        {
                            "height": 640,
                            "url": "https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce",
                            "width": 640
                        }
                    ],
                    "name": "WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?",
                    "release_date": "2019-03-29",
                    "total_tracks": 14
                }
            ],
            "limit": 50,
            "next": null
        }';

        $restClient = $this->prophesize(RestClient::class);

        /** TODO: Do this mocking a config file */
        $restClient->get('https://api.spotify.com/v1/artists/6qqNVTkY8uBg9cP3Jd7DAH/albums', Argument::any())->willReturn(json_decode($serviceResponse, true));

        $getTokenRepository = $this->createPartialMock(GetTokenRepository::class, [
            '__invoke',
        ]);

        $getTokenRepository
            ->method('__invoke')
            ->willReturn('BQBHvl2tVOM-WarEF3jr2iGOgv7neugpIQD6Ho8vQ4dsRKu_vo8pI3mcbwg1yblgwfO73Z5YMH5HmYPabCE');

        $findAlbumsByArtistIdRepository = new FindAlbumsByArtistIdRepository($restClient->reveal(), $getTokenRepository);

        $mockResponse = [
            [
                'name' => 'WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?',
                'released' => '2019-03-29',
                'tracks' => 14,
                'cover' => [
                    'height' => 640,
                    'url' => 'https://i.scdn.co/image/ab67616d0000b27350a3147b4edd7701a876c6ce',
                    'width' => 640
                ],
            ]
        ];

        $this->assertEquals($mockResponse, $findAlbumsByArtistIdRepository('6qqNVTkY8uBg9cP3Jd7DAH'));       
    }
}