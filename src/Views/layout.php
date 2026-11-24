<?php
/** @var string $contenu HTML de la vue affichée */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AppPanini</title>
</head>
<body>
    <h1>AppPanini - collection de cartes NBA</h1>

    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            Connecté : <?= htmlspecialchars($_SESSION['username']) ?>
            | <a href="/">Mon album</a>
            | <a href="/logout">Déconnexion</a>
        <?php else: ?>
            <a href="/login">Connexion</a> | <a href="/signup">Inscription</a>
        <?php endif; ?>
    </nav>
    <hr>

    <?= $contenu ?>
</body>
</html>
