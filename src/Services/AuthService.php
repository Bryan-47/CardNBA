<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\UserRepository;
use InvalidArgumentException;

/** Logique métier de l'authentification (inscription, connexion, session). */
final class AuthService
{
    public function __construct(private readonly UserRepository $users)
    {
    }

    /**
     * Crée un compte. Retourne null si l'email ou le pseudo est déjà pris.
     *
     * @throws InvalidArgumentException données invalides
     */
    public function register(string $username, string $email, string $password): ?User
    {
        if ($username === '' || mb_strlen($username) > 50
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($password) < 8) {
            throw new InvalidArgumentException(
                'Pseudo (50 caractères max), email valide et mot de passe (8 caractères min) obligatoires.'
            );
        }

        return $this->users->create($username, $email, password_hash($password, PASSWORD_DEFAULT));
    }

    /** Retourne l'utilisateur si email + mot de passe sont corrects, sinon null. */
    public function attempt(string $email, string $password): ?User
    {
        $user = $this->users->findByEmail($email);

        return ($user !== null && $user->verifyPassword($password)) ? $user : null;
    }

    public function login(User $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user->getId();
        $_SESSION['username'] = $user->getUsername();
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function currentUsername(): ?string
    {
        return $_SESSION['username'] ?? null;
    }

    public function currentUser(): ?User
    {
        return $this->isLoggedIn() ? $this->users->findById((int) $_SESSION['user_id']) : null;
    }
}
