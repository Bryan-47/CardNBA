<?php

declare(strict_types=1);

namespace App\Controllers;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AuthController extends Controller
{
    public function showLogin(Request $request, Response $response): Response
    {
        if ($this->auth->isLoggedIn()) {
            return $this->redirect($response, '/');
        }

        return $this->render($response, 'login', ['erreur' => '']);
    }

    public function login(Request $request, Response $response): Response
    {
        $donnees = (array) $request->getParsedBody();
        $user    = $this->auth->attempt(
            trim((string) ($donnees['email'] ?? '')),
            (string) ($donnees['password'] ?? '')
        );

        if ($user === null) {
            return $this->render($response, 'login', ['erreur' => 'Email ou mot de passe incorrect.']);
        }

        $this->auth->login($user);

        return $this->redirect($response, '/');
    }

    public function showSignup(Request $request, Response $response): Response
    {
        if ($this->auth->isLoggedIn()) {
            return $this->redirect($response, '/');
        }

        return $this->render($response, 'signup', ['erreur' => '']);
    }

    public function signup(Request $request, Response $response): Response
    {
        $donnees = (array) $request->getParsedBody();

        try {
            $user = $this->auth->register(
                trim((string) ($donnees['username'] ?? '')),
                trim((string) ($donnees['email'] ?? '')),
                (string) ($donnees['password'] ?? '')
            );
        } catch (InvalidArgumentException $e) {
            return $this->render($response, 'signup', ['erreur' => $e->getMessage()]);
        }

        if ($user === null) {
            return $this->render($response, 'signup', ['erreur' => 'Email ou pseudo déjà utilisé.']);
        }

        $this->auth->login($user);

        return $this->redirect($response, '/');
    }

    public function logout(Request $request, Response $response): Response
    {
        $this->auth->logout();

        return $this->redirect($response, '/login');
    }
}
