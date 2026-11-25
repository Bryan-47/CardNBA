<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\AuthService;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    public function __construct(protected readonly AuthService $auth)
    {
    }

    /** Affiche src/Views/<template>.php à l'intérieur de layout.php. */
    protected function render(Response $response, string $template, array $data = []): Response
    {
        $contenu = $this->capture($template, $data);

        $html = $this->capture('layout', [
            'contenu'  => $contenu,
            'username' => $this->auth->currentUsername(),
        ]);

        $response->getBody()->write($html);

        return $response;
    }

    protected function redirect(Response $response, string $url): Response
    {
        return $response->withStatus(302)->withHeader('Location', $url);
    }

    /** Échappe une valeur pour l'afficher dans du HTML (utilisé dans les vues). */
    protected function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    private function capture(string $template, array $data): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        include __DIR__ . '/../Views/' . $template . '.php';

        return (string) ob_get_clean();
    }
}
