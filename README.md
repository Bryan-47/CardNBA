# CardNBA

Version réduite à un **système de login**, avec une architecture **MVC** en **POO**.
PHP 8.2 · Slim 4 · MySQL (PDO) · Docker.

## Démarrage

```bash
cp config/env/.env.conf .env      # puis renseigner DB_PASS et MYSQL_ROOT_PASSWORD
docker compose up -d --build
docker compose exec web composer install
```

Ouvrir **http://localhost:8080**.
Pour rejouer `config/db/init.sql` (schéma modifié) : `docker compose down -v` puis relancer.

## Routes

| URL | Méthode | Rôle |
|---|---|---|
| `/signup` | GET, POST | inscription |
| `/login` | GET, POST | connexion (email + mot de passe) |
| `/logout` | POST | déconnexion (connecté) |
| `/` | GET | page d'accueil protégée (connecté) |

## Architecture

```
public/index.php                    point d'entrée (.env, session, Slim)
src/Routes/Routes.php               routes + assemblage des objets
src/Controllers/Controller          classe de base (render, redirect)
src/Controllers/AuthController      login, signup, logout
src/Controllers/HomeController      page protégée
src/Models/Model                    classe de base : connexion PDO
src/Models/User                     entité utilisateur
src/Models/UserRepository           accès à la table users
src/Services/AuthService            logique métier : inscription, connexion, session
src/Views/                          layout, login, signup, home
config/db/init.sql                  table users
```

Flux d'une requête : **Route → Controller → Service → Model → View**.
