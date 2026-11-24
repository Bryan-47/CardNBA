<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\AppService;
use PDOException;

final class User
{
    /** Crée un compte. Retourne son id, ou null si l'email ou le pseudo existe déjà. */
    public function create(string $username, string $email, string $password): ?int
    {
        $requete = AppService::db()->prepare(
            'INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)'
        );

        try {
            $requete->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // violation d'unicité
                return null;
            }
            throw $e;
        }

        return (int) AppService::db()->lastInsertId();
    }

    /** Retourne l'utilisateur (id, username) si email + mot de passe sont corrects, sinon null. */
    public function authentifier(string $email, string $password): ?array
    {
        $requete = AppService::db()->prepare(
            'SELECT id, username, password_hash FROM users WHERE email = ?'
        );
        $requete->execute([$email]);
        $utilisateur = $requete->fetch();

        if ($utilisateur === false || !password_verify($password, $utilisateur['password_hash'])) {
            return null;
        }

        return ['id' => (int) $utilisateur['id'], 'username' => $utilisateur['username']];
    }
}
