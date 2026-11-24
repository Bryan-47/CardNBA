<?php
/** @var array $album     tous les joueurs avec la clé 'quantite' */
/** @var array $pack      cartes du dernier pack ouvert (vide sinon) */
/** @var int   $possedees nombre de joueurs différents possédés */
?>
<h2>Mon album</h2>
<p><?= $possedees ?> / <?= count($album) ?> joueurs collectionnés</p>

<form method="post" action="/pack">
    <button type="submit">Ouvrir un pack (5 cartes)</button>
</form>

<?php if ($pack !== []): ?>
    <h3>Cartes obtenues</h3>
    <ul>
        <?php foreach ($pack as $carte): ?>
            <li><?= htmlspecialchars($carte['nom']) ?> (<?= htmlspecialchars((string) $carte['equipe']) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h3>Tous les joueurs</h3>
<table border="1" cellpadding="4">
    <tr>
        <th>Joueur</th>
        <th>Équipe</th>
        <th>Poste</th>
        <th>Taille (cm)</th>
        <th>Exemplaires</th>
    </tr>
    <?php foreach ($album as $joueur): ?>
        <tr>
            <td><?= htmlspecialchars($joueur['nom']) ?></td>
            <td><?= htmlspecialchars((string) $joueur['equipe']) ?></td>
            <td><?= htmlspecialchars((string) $joueur['poste']) ?></td>
            <td><?= htmlspecialchars((string) $joueur['taille']) ?></td>
            <td><?= (int) $joueur['quantite'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
