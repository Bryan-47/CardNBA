<?php
/** @var App\Controllers\Controller $this */
/** @var string $erreur message d'erreur ('' si aucun) */
?>
<h2>Inscription</h2>

<?php if ($erreur !== ''): ?>
    <p><strong><?= $this->e($erreur) ?></strong></p>
<?php endif; ?>

<form method="post" action="/signup">
    <p><label>Pseudo <input type="text" name="username" required maxlength="50"></label></p>
    <p><label>Email <input type="email" name="email" required></label></p>
    <p><label>Mot de passe <input type="password" name="password" required minlength="8"></label></p>
    <button type="submit">Créer mon compte</button>
</form>

<p>Déjà inscrit ? <a href="/login">Connexion</a></p>
