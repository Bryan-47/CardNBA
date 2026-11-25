<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Models\UserRepository;
use App\Services\AuthService;
use Slim\App;

return function (App $app): void {
    // Assemblage des objets (injection de dépendances à la main)
    $auth           = new AuthService(new UserRepository());
    $authController = new AuthController($auth);
    $homeController = new HomeController($auth);

    // Page protégée (le contrôleur redirige vers /login si non connecté)
    $app->get('/', [$homeController, 'index']);

    // Authentification
    $app->get('/login', [$authController, 'showLogin']);
    $app->post('/login', [$authController, 'login']);
    $app->get('/signup', [$authController, 'showSignup']);
    $app->post('/signup', [$authController, 'signup']);
    $app->post('/logout', [$authController, 'logout']);
};
