<?php
namespace App\Repositories;

class FindAlbumsByArtistIdRepository
{
    public function __invoke(string $artistId) : array
    {
        return [
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
    }
}