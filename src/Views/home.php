<?php
/** @var App\Controllers\Controller $this */
/** @var App\Models\User $user l'utilisateur connecté */
?>
<h2>Bienvenue, <?= $this->e($user->getUsername()) ?> !</h2>
<p>Tu es connecté avec l'adresse <?= $this->e($user->getEmail()) ?>.</p>
