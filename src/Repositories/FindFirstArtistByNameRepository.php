<?php
namespace App\Repositories;

use App\Entities\ArtistEntity;

class FindFirstArtistByNameRepository
{
    private $artistsCollection = [];

    public function __invoke(string $artistName) : ArtistEntity
    {
        return new ArtistEntity(['id' => '1MuQ2m2tg7naeRGAOxYZer']);
    }
}