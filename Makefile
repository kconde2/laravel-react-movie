SHELL := /bin/bash
DOCKER_COMPOSE_SHELL := vendor/bin/sail

help: ## Affiche les commandes disponibles
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

init: ## Initialise le projet (copie .env, installe les dépendances, et lance le conteneur)
	cp -n .env.example .env || echo ".env already exists"
	$(DOCKER_COMPOSE_SHELL) up -d
	composer install
	npm run build
	vendor/bin/sail artisan migrate:fresh

idehelpers: ## Genere l'ide-helper
	$(DOCKER_COMPOSE_SHELL) php artisan ide-helper:generate

up: ## Lance le conteneur app
	$(DOCKER_COMPOSE_SHELL) up -d

down: ## Ferme le conteneur app
	$(DOCKER_COMPOSE_SHELL) down -v

migrate: ## Lance les migrations
	$(DOCKER_COMPOSE_SHELL) artisan migrate

fresh: ## Supprime et recreer les migrations
	$(DOCKER_COMPOSE_SHELL) artisan migrate:fresh

ps: ## Affiche les conteneurs en cours d'exécution
	$(DOCKER_COMPOSE_SHELL) ps

logs: ## Affiche les logs des conteneurs
	$(DOCKER_COMPOSE_SHELL) logs -f

shell: ## Ouvre un terminal bash dans le conteneur app
	$(DOCKER_COMPOSE_SHELL) bash

fetch_movies: ## Recharge les films en base de données
	$(DOCKER_COMPOSE_SHELL) artisan movies:fetch

shedule_fetch_movies: ## Planifie la recuperation des films en base de données
	$(DOCKER_COMPOSE_SHELL) artisan schedule:list

pint: ## Exécute la commande Pint
	$(DOCKER_COMPOSE_SHELL) bin pint

artisan: ## Exécute une commande artisan dans le conteneur app
	$(DOCKER_COMPOSE_SHELL) php artisan $(filter-out $@,$(MAKECMDGOALS))

# Pour éviter les erreurs "No rule to make target"
%:
	@:
