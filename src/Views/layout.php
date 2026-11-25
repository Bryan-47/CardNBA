<?php
/** @var App\Controllers\Controller $this */
/** @var string      $contenu  HTML de la vue affichée */
/** @var string|null $username pseudo si connecté, sinon null */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CardNBA</title>
</head>
<body>
    <h1>CardNBA</h1>

    <nav>
        <?php if ($username !== null): ?>
            Connecté : <?= $this->e($username) ?>
            <form method="post" action="/logout" style="display:inline">
                <button type="submit">Déconnexion</button>
            </form>
        <?php else: ?>
            <a href="/login">Connexion</a> | <a href="/signup">Inscription</a>
        <?php endif; ?>
    </nav>
    <hr>

    <?= $contenu ?>
</body>
</html>
