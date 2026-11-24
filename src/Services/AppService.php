<?php

declare(strict_types=1);

namespace App\Services;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
final class AppService
{
    private static ?PDO $pdo = null;

    public static function db(): PDO
    {
        if (self::$pdo === null) {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $_ENV['DB_HOST'], $_ENV['DB_NAME']);

            self::$pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$pdo;
    }
    public static function render(Response $response, string $vue, array $data = []): Response
    {
        extract($data);

        ob_start();
        include __DIR__ . '/../Views/' . $vue . '.php';
        $contenu = ob_get_clean();

        ob_start();
        include __DIR__ . '/../Views/layout.php';
        $response->getBody()->write(ob_get_clean());

        return $response;
    }

    public static function rediriger(Response $response, string $url): Response
    {
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
