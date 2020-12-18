<?php
namespace App\Repositories;

use App\ExternalClients\RestClient;

class FindAlbumsByArtistIdRepository extends AbstractRestRespository
{
    private $albumsCollection = [];

    public function __invoke(string $artistId) : array
    {
        $this->findAllAlbums($artistId);
        
        return $this->albumsCollection;
    }

    private function findAllAlbums($artistId, $offset = 0) {
        /** TODO: Set this in a config file */
        $path = sprintf('/v1/artists/%s/albums', $artistId);
        $limit = 20;

        $endpoint = $this->getEndpoint($path);
        
        $options = [
            'query' => [
                'album_type' => 'album',
                'offset' => $offset,
                'limmit' => $limit
            ]
        ];

        $this->setAuthorizationHeader($options);
        
        $response = $this->restClient->get($endpoint, $options);
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