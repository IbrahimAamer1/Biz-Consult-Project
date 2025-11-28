.PHONY: help up down restart logs shell migrate seed fresh test cache-clear cache build-assets setup db-shell db-backup

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Start containers
	docker-compose up -d

down: ## Stop containers
	docker-compose down

restart: ## Restart containers
	docker-compose restart

logs: ## View logs
	docker-compose logs -f

shell: ## Access app container shell
	docker-compose exec app sh

migrate: ## Run migrations
	docker-compose exec app php artisan migrate

seed: ## Run seeders
	docker-compose exec app php artisan db:seed

fresh: ## Fresh migration with seed
	docker-compose exec app php artisan migrate:fresh --seed

test: ## Run tests
	docker-compose exec app php artisan test

cache-clear: ## Clear all caches
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

cache: ## Cache configurations
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan route:cache
	docker-compose exec app php artisan view:cache

build-assets: ## Build frontend assets
	docker-compose exec app npm run build

setup: ## Complete setup (build, start, migrate, seed)
	docker-compose build
	docker-compose up -d
	@echo "Waiting for database to be ready..."
	@sleep 5
	docker-compose exec app php artisan key:generate || true
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan storage:link || true
	docker-compose exec app npm run build

db-shell: ## Access database shell
	docker-compose exec db mysql -u bizconsult -ppassword bizconsult

db-backup: ## Create database backup
	docker-compose exec db mysqldump -u bizconsult -ppassword bizconsult > backup_$(shell date +%Y%m%d_%H%M%S).sql
	@echo "Backup created: backup_$(shell date +%Y%m%d_%H%M%S).sql"

