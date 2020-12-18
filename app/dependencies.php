<?php
declare(strict_types=1);

use App\ExternalClients\RestClient;
use App\Repositories\FindAlbumsByArtistIdRepository;
use App\Repositories\FindFirstArtistByNameRepository;
use App\Repositories\GetTokenRepository;
use App\Services\AlbumsListService;
use GuzzleHttp\Client;

$container = $app->getContainer();
$container[AlbumsListService::class] = function ($container) {
    return new AlbumsListService(
        $container[FindFirstArtistByNameRepository::class],
        $container[FindAlbumsByArtistIdRepository::class]
    );
};

$container[FindFirstArtistByNameRepository::class] = function ($container) {
    return new FindFirstArtistByNameRepository(
        $container[RestClient::class],
        $container[GetTokenRepository::class]
    );
};

$container[FindAlbumsByArtistIdRepository::class] = function ($container) {
    return new FindAlbumsByArtistIdRepository(
        $container[RestClient::class],
        $container[GetTokenRepository::class]
    );
};

$container[RestClient::class] = function ($container) {
    return new RestClient(
        new Client(),
    );
};

$container[GetTokenRepository::class] = function ($container) {
    return new GetTokenRepository(
        $container[RestClient::class],
    );
};

