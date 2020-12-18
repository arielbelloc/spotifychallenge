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
        $artist = ($this->findFirstArtistByNameRepository)($artistName);
        $ambumList = ($this->findAlbumsByArtistIdRepository)($artist->getId());

        return $ambumList;
    }
}