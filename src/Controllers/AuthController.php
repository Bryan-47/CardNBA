<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Services\AppService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AuthController
{
    public function showSignup(Request $request, Response $response): Response
    {
        return AppService::render($response, 'auth', ['mode' => 'signup', 'erreur' => '']);
    }

    public function signup(Request $request, Response $response): Response
    {
        $donnees  = (array) $request->getParsedBody();
        $username = trim((string) ($donnees['username'] ?? ''));
        $email    = trim((string) ($donnees['email'] ?? ''));
        $password = (string) ($donnees['password'] ?? '');

        if ($username === '' || mb_strlen($username) > 50
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($password) < 8) {
            return AppService::render($response, 'auth', [
                'mode'   => 'signup',
                'erreur' => 'Pseudo (50 caractères max), email valide et mot de passe (8 caractères min) obligatoires.',
            ]);
        }

        $id = (new User())->create($username, $email, $password);

        if ($id === null) {
            return AppService::render($response, 'auth', [
                'mode'   => 'signup',
                'erreur' => 'Email ou pseudo déjà utilisé.',
            ]);
        }

        return $this->connecter($response, $id, $username);
    }

    public function showLogin(Request $request, Response $response): Response
    {
        return AppService::render($response, 'auth', ['mode' => 'login', 'erreur' => '']);
    }

    public function login(Request $request, Response $response): Response
    {
        $donnees     = (array) $request->getParsedBody();
        $utilisateur = (new User())->authentifier(
            trim((string) ($donnees['email'] ?? '')),
            (string) ($donnees['password'] ?? '')
        );

        if ($utilisateur === null) {
            return AppService::render($response, 'auth', [
                'mode'   => 'login',
                'erreur' => 'Email ou mot de passe incorrect.',
            ]);
        }

        return $this->connecter($response, $utilisateur['id'], $utilisateur['username']);
    }

    public function logout(Request $request, Response $response): Response
    {
        $_SESSION = [];
        session_destroy();

        return AppService::rediriger($response, '/login');
    }

    private function connecter(Response $response, int $id, string $username): Response
    {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $id;
        $_SESSION['username'] = $username;

        return AppService::rediriger($response, '/');
    }
}
