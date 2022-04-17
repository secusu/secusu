DOCKER-APP-EXEC = docker exec -it secu-app /bin/sh -c
DOCKER-NODEJS-EXEC = docker-compose run --rm nodejs /bin/sh -c
C=app # Container name

ssh: ## Connect to containers via SSH
	docker exec -it secu-$(C) /bin/sh

setup-dev: ## Setup project for development
	make start
	make composer-install
	make app-key-generate
	make db-migrate
	make db-seed
	make yarn-install
	make yarn-dev

start: ## Start application silently
	docker-compose up -d

stop: ## Stop application
	docker-compose down

restart: ## Restart the application
	make stop
	make start

composer-install: ## Install composer dependencies
	$(DOCKER-APP-EXEC) 'composer install'

composer-dump: ## Dump composer dependencies
	$(DOCKER-APP-EXEC) 'composer dump'

composer-update: ## Update composer dependencies
	$(DOCKER-APP-EXEC) 'composer update $(filter-out $@,$(MAKECMDGOALS))'

copy-env: ## Copy .env.example as .env
	cp .env.example .env

app-key-generate: ## Generate key for laravel
	$(DOCKER-APP-EXEC) 'php artisan key:generate'

db-migrate: ## Migrate database structure
	$(DOCKER-APP-EXEC) 'php artisan migrate'

db-seed: ## Seed database data
	$(DOCKER-APP-EXEC) 'php artisan db:seed'

phpunit-test: ## Test app
	$(DOCKER-APP-EXEC) 'php artisan test'

yarn-install: ## Install NPM dependencies
	$(DOCKER-NODEJS-EXEC) 'yarn install'

yarn-dev: ## Build frontend static files for development
	$(DOCKER-NODEJS-EXEC) 'yarn run development'

yarn-watch: ## JIT rebuilding frontend static files for development
	$(DOCKER-NODEJS-EXEC) 'yarn run watch'

yarn-prod: ## Build minimized frontend static files for production
	$(DOCKER-NODEJS-EXEC) 'yarn run production'

cleanup-docker: ## Remove old docker images
	docker rmi $$(docker images --filter "dangling=true" -q --no-trunc)

run: ## Run command in the container
	$(DOCKER-APP-EXEC) '$(filter-out $@,$(MAKECMDGOALS))'

help: # Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
