# Movies

Ce projet est une application Laravel configurée pour un environnement de développement Dockerisé. Il utilise plusieurs outils pour améliorer la productivité, notamment le support des IDE et une structure conforme au Domain-Driven Design (DDD).

## Code source

L'essentiel du code source se trouve dans `src/`

## Prérequis
- Docker (docker -v)
- Docker Compose (docker composer --version)
- Make (make --version)

## Installation

1. Cloner

```shell
git clone <url-du-depot>
cd votre-projet
make init
```
2. Insérer les données

```
make fetch_api_data
```

La commande doit fonctionner mais un fichier `web.sql` est disponible si la commande ne fonctionne pas. Pouvez l'importer en allant sur phpmyadmin

3. Visiter l'application

- App : [http://localhost/](http://localhost/)

- Phpmyadmin : [http://localhost:8080](http://localhost:8080)

- Telescope : [http://localhost/telescope](http://localhost/telescope)

## Commandes

Pour récupérer les films de l'API

```
make fetch_movies_day
```

```
make fetch_movies_week
```

Pour voir les informations sur la récupération quotidienne des films

```
make schedule
```

Pour formater le code

```
make pint
```

## Tests

```
make test
```

## Packages installés

- https://github.com/barryvdh/laravel-ide-helper
- https://github.com/lunarstorm/laravel-ddd
- https://www.laravelactions.com/
- https://spatie.be/docs/laravel-data/v4/introduction
- https://laravel.com/docs/11.x/pint
- https://spatie.be/docs/laravel-data/v4/advanced-usage/typescript
- https://spatie.be/docs/enum/v3/introduction
- composer require pestphp/pest-plugin-watch --dev
