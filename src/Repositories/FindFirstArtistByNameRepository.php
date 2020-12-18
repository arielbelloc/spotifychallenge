<?php
namespace App\Repositories;

use App\Entities\ArtistEntity;

class FindFirstArtistByNameRepository
{
    private $artistsCollection = [];

    public function __invoke(string $artistName) : ArtistEntity
    {
        return new ArtistEntity();
    }
}