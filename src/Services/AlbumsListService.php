<?php
namespace App\Services;

use App\Repositories\FindAlbumsByArtistIdRepository;
use App\Repositories\FindFirstArtistByNameRepository;

class AlbumsListService {

    private $findFirstArtistByNameRepository;
    private $findAlbumsByArtistIdRepository;

    public function __construct(FindFirstArtistByNameRepository $spotifyArtistsRepository, FindAlbumsByArtistIdRepository $findAlbumsByArtistIdRepository)
    {
        $this->findFirstArtistByNameRepository = $spotifyArtistsRepository;
        $this->findAlbumsByArtistIdRepository = $findAlbumsByArtistIdRepository;
    }

    public function __invoke($artistName) : array
    {
        return  [
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
    }
}