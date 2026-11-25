<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->load();

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(($_ENV['APP_ENV'] ?? 'prod') === 'local', true, true);

(require __DIR__ . '/../src/Routes/Routes.php')($app);

$app->run();
