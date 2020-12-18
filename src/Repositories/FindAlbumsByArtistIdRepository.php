<?php
namespace App\Repositories;

use App\ExternalClients\RestClient;

class FindAlbumsByArtistIdRepository
{
    private $albumsCollection = [];

    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
    }

    public function __invoke(string $artistId) : array
    {
        $this->findAllAlbums($artistId);
        
        return $this->albumsCollection;
    }

    private function findAllAlbums($artistId, $offset = 0) {
        $endpoint = '';
        $limit = 20;

        $options = [
            'query' => [
                'album_type' => 'album',
                'offset' => $offset,
                'limmit' => $limit
            ]
        ];

        $response = $this->restClient->get($endpoint, $options);;
        foreach ($response['items'] as $album) {
            $this->addAlbum($album);
        }

        if (!is_null($response['next'])) {
            $this->findAllAlbums($artistId, $offset+$limit);
        }
    }

    private function addAlbum($album)
    {
        $this->albumsCollection[] = [
            'name' => $album['name'],
            'released' => $album['release_date'],
            'tracks' => $album['total_tracks'],
            'cover' => $album['images'][0] ?? []
        ];
    }
}