## Movies

Ce projet est une application Laravel configurée pour un environnement de développement Dockerisé. Il utilise plusieurs outils pour améliorer la productivité, notamment le support des IDE et une structure conforme au Domain-Driven Design (DDD).
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

2. Visiter l'application

App : `http://localhost/`
Phpmyadmin : `http://localhost:8080`


## Commandes

Pour récupérer les films de l'API

- `make fetch_movies`
- `make fetch_movies timeWindow=day`
- `make fetch_movies timeWindow=week`

Pour voir les informations sur la récupération quotidienne des films

- `make schedule`


Pour formater le code

- `make pint`

## Packages installés

- https://github.com/barryvdh/laravel-ide-helper
- https://github.com/lunarstorm/laravel-ddd
- https://www.laravelactions.com/
- https://spatie.be/docs/laravel-data/v4/introduction
- https://laravel.com/docs/11.x/pint
