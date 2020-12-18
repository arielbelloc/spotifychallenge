<?php
namespace Tests\src\Services;

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use App\Entities\ArtistEntity;
use App\Repositories\FindFirstArtistByNameRepository;
use App\Repositories\FindAlbumsByArtistIdRepository;
use App\Services\AlbumsListService;

class AlbumsListServiceTest extends PHPUnit_TestCase {
    public function testGetTestArtistAlbumsSuccess()
    {
        $mockResponse = [
            [
                "name" => "Album Name",
                "released" => "10-10-2010",
                "tracks" => 10,
                "cover" => [
                    "height" => 640,
                    "width" => 640,
                    "url" => "https://i.scdn.co/image/6c951f3f334e05ffa"
                ]
            ],
        ];

        $artistEntity = $this->prophesize(ArtistEntity::class);
        $artistEntity->getId()->willReturn('7BTNOkc344wl9rZ4mLUfGk');

        $findFirstArtistByNameRepository = $this->createPartialMock(FindFirstArtistByNameRepository::class, [
            '__invoke',
        ]);

        $findFirstArtistByNameRepository
            ->method('__invoke')
            ->willReturn($artistEntity->reveal());

        $findAlbumsByArtistIdRepository = $this->createPartialMock(FindAlbumsByArtistIdRepository::class, [
            '__invoke',
        ]);

        $findAlbumsByArtistIdRepository
            ->method('__invoke')
            ->willReturn($mockResponse);
        
        $albumsListClient = new AlbumsListService($findFirstArtistByNameRepository, $findAlbumsByArtistIdRepository);
        
        $this->assertEquals($mockResponse, $albumsListClient('TestArtist'));
    }
}