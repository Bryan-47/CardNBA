<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\AppService;
use Throwable;

final class Collection
{
    private const TAILLE_PACK = 5;
    public function ouvrirPack(int $userId): array
    {
        $pdo = AppService::db();

        $joueurs = $pdo
            ->query('SELECT id, nom, equipe, poste, taille FROM joueurs ORDER BY RAND() LIMIT ' . self::TAILLE_PACK)
            ->fetchAll();

        $requete = $pdo->prepare('INSERT INTO cartes_utilisateur (user_id, joueur_id) VALUES (?, ?)');

        try {
            $pdo->beginTransaction();
            foreach ($joueurs as $joueur) {
                $requete->execute([$userId, $joueur['id']]);
            }
            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        return $joueurs;
    }
    public function getAlbum(int $userId): array
    {
        $requete = AppService::db()->prepare(
            'SELECT j.id, j.nom, j.equipe, j.poste, j.taille, COUNT(c.id) AS quantite
             FROM joueurs j
             LEFT JOIN cartes_utilisateur c ON c.joueur_id = j.id AND c.user_id = ?
             GROUP BY j.id, j.nom, j.equipe, j.poste, j.taille
             ORDER BY j.equipe, j.nom'
        );
        $requete->execute([$userId]);

        return $requete->fetchAll();
    }
}
