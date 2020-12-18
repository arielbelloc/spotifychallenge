<?php
declare(strict_types=1);

use App\Services\AlbumsListService;
use \Slim\Http\Request;
use \Slim\Http\Response;

// GET /
$app->get('/check-status', function (Request $request, Response $response, array $args) {
    return $response
        ->withStatus(200)
        ->withJson(['status' => 'ok']);
});

// GET 
// Example: http://localhost/api/v1/albums?q=<band-name>
$app->get('/api/v1/albums', function (Request $request, Response $response, array $args) {
    $artistName = $request->getQueryParam('q');
    $albumsListService = $this->get(AlbumsListService::class);
    $albumsList = ($albumsListService)($artistName);
    return $response
        ->withStatus(200)
        ->withJson($albumsList);
});

