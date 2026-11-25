<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** Page protégée affichée une fois connecté. */
final class HomeController extends Controller
{
    public function index(Request $request, Response $response): Response
    {
        $user = $this->auth->currentUser();

        if ($user === null) {
            return $this->redirect($response, '/login');
        }

        return $this->render($response, 'home', ['user' => $user]);
    }
}
