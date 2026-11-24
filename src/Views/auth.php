<?php
/** @var string $mode   'login' ou 'signup' */
/** @var string $erreur message d'erreur ('' si aucun) */
?>
<?php $inscription = $mode === 'signup'; ?>

<h2><?= $inscription ? 'Inscription' : 'Connexion' ?></h2>

<?php if ($erreur !== ''): ?>
    <p><strong><?= htmlspecialchars($erreur) ?></strong></p>
<?php endif; ?>

<form method="post" action="<?= $inscription ? '/signup' : '/login' ?>">
    <?php if ($inscription): ?>
        <p><label>Pseudo <input type="text" name="username" required maxlength="50"></label></p>
    <?php endif; ?>
    <p><label>Email <input type="email" name="email" required></label></p>
    <p><label>Mot de passe <input type="password" name="password" required minlength="8"></label></p>
    <button type="submit"><?= $inscription ? 'Créer mon compte' : 'Se connecter' ?></button>
</form>

<?php if ($inscription): ?>
    <p>Déjà inscrit ? <a href="/login">Connexion</a></p>
<?php else: ?>
    <p>Pas encore de compte ? <a href="/signup">Inscription</a></p>
<?php endif; ?>
