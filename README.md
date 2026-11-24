# CardNBA Adredalyn

Fonctionalitées : 

- Creation de compte.
- Première album.
- Debloquer des albums.
- Système de saisons avec les albums.
- Système de saisons avec les packs. 
- Achats de pack.
- Vente de carte.
- Succès.
- Carte exclusive personalisable.
- Mode MyTeam comme dans le jeux nba2k.


Problème Résolu : 
Cette application servira au utilisateurs, passionné de basket et de carte à collectionné, de jouer à un jeux, totalement gratuit. 
Ce jeux permettra de collectionné des cartes virutelle de joueurs nba et de créer une dream team, comme dans le jeux nba2k. Ainsi, les joueurs
n'ayant pas d'argent pour acheter le jeux, pourra utiliser l'application qui elle est gratuite. 

---

## Version minimale actuelle

Mini jeu de collection de cartes NBA : on s'inscrit, on ouvre des packs de 5 cartes aléatoires
et on suit son album. PHP 8 · Slim 4 · MySQL (PDO) · Docker.

### Démarrage

```bash
docker compose up -d --build
docker compose exec web composer install
```

Puis ouvrir **http://localhost:8080**.
Au premier lancement, MySQL crée les tables et charge 90 joueurs (`config/db/init.sql`).
Pour rejouer ce script (schéma modifié) : `docker compose down -v` puis relancer.

Le fichier `.env` est fourni ; le modèle est `config/env/.env.conf`.
Avec `APP_ENV=local`, les erreurs affichent leur détail.

### Fonctionnalités

| URL | Méthode | Rôle |
|---|---|---|
| `/signup` | GET, POST | inscription |
| `/login` | GET, POST | connexion (email + mot de passe) |
| `/logout` | GET | déconnexion |
| `/` | GET | album : progression, dernier pack ouvert, liste des joueurs (connecté) |
| `/pack` | POST | ouvre un pack de 5 cartes (connecté) |

### Structure

```
public/index.php                  point d'entrée (Slim, .env, session)
src/Routes/Routes.php             les 7 routes
src/Controllers/AuthController    inscription, connexion, déconnexion
src/Controllers/AlbumController   album + ouverture de pack
src/Models/User                   création de compte, authentification
src/Models/Collection             tirage du pack, album de l'utilisateur
src/Services/AppService           connexion PDO, rendu des vues, redirection
src/Views/                        layout, auth (login + signup), album
config/db/init.sql                tables + 90 joueurs
```
