<?php
/** @var App\Controllers\Controller $this */
/** @var string $erreur message d'erreur ('' si aucun) */
?>
<h2>Connexion</h2>

<?php if ($erreur !== ''): ?>
    <p><strong><?= $this->e($erreur) ?></strong></p>
<?php endif; ?>

<form method="post" action="/login">
    <p><label>Email <input type="email" name="email" required></label></p>
    <p><label>Mot de passe <input type="password" name="password" required></label></p>
    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="/signup">Inscription</a></p>
