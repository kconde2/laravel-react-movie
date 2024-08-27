up: ## Lance le conteneur app
	vendor/bin/sail up -d

down: ## Ferme le conteneur app
	vendor/bin/sail down -v

migrate: ## Lance les migrations
	./vendor/bin/sail artisan migrate

fresh: ## Supprime et recreer les migrations
	./vendor/bin/sail artisan migrate:fresh

help: ## Affiche les commandes disponibles
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

artisan: ## Exécute une commande artisan dans le conteneur app
	docker-compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

# Pour éviter les erreurs "No rule to make target"
%:
	@:
