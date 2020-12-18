<?php
namespace App\Repositories;

use App\Entities\ArtistEntity;

class FindFirstArtistByNameRepository extends AbstractRestRespository
{
    private $artistsCollection = [];

    public function __invoke(string $artistName) : ArtistEntity
    {
        $endpoint = $this->getEndpoint('/v1/search');
        $options = [
            'query' => [
                'q' => $artistName,
                'type' => 'artist',
                'limit' => '10',
                'offset' => '0',
            ]
        ];

        $this->setAuthorizationHeader($options);

        $response = $this->restClient->get($endpoint, $options);

         if (!isset($response['artists']['items'][0])) {
            throw new \Exception('Artist not found');
         }

        return new ArtistEntity($response['artists']['items'][0]);
    }
}