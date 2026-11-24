<?php

declare(strict_types=1);

use App\Controllers\AlbumController;
use App\Controllers\AuthController;
use Slim\App;

return function (App $app): void {
    // Album + ouverture de pack (connecté)
    $app->get('/', [AlbumController::class, 'index']);
    $app->post('/pack', [AlbumController::class, 'ouvrirPack']);

    // Authentification
    $app->get('/signup', [AuthController::class, 'showSignup']);
    $app->post('/signup', [AuthController::class, 'signup']);
    $app->get('/login', [AuthController::class, 'showLogin']);
    $app->post('/login', [AuthController::class, 'login']);
    $app->get('/logout', [AuthController::class, 'logout']);
};
