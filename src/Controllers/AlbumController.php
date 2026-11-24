<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Collection;
use App\Services\AppService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AlbumController
{
    public function index(Request $request, Response $response): Response
    {
        if (!isset($_SESSION['user_id'])) {
            return AppService::rediriger($response, '/login');
        }

        $album = (new Collection())->getAlbum((int) $_SESSION['user_id']);

        $pack = $_SESSION['dernierPack'] ?? [];
        unset($_SESSION['dernierPack']);

        $possedees = count(array_filter($album, static fn (array $j): bool => (int) $j['quantite'] > 0));

        return AppService::render($response, 'album', [
            'album'     => $album,
            'pack'      => $pack,
            'possedees' => $possedees,
        ]);
    }

    public function ouvrirPack(Request $request, Response $response): Response
    {
        if (!isset($_SESSION['user_id'])) {
            return AppService::rediriger($response, '/login');
        }

        $_SESSION['dernierPack'] = (new Collection())->ouvrirPack((int) $_SESSION['user_id']);

        return AppService::rediriger($response, '/');
    }
}
