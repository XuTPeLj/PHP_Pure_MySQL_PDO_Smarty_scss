.PHONY: help build start stop restart shell composer migrate seed scss scss-watch first

help:
	@echo "Available commands:"
	@echo "  build      - Build Docker containers"
	@echo "  start      - Start Docker containers"
	@echo "  stop       - Stop Docker containers"
	@echo "  restart    - Restart Docker containers"
	@echo "  shell      - Open bash shell in PHP container"
	@echo "  composer   - Run composer command (usage: make composer CMD=\"install\")"
	@echo "  migrate    - Run database migrations"
	@echo "  seed       - Run database seeders"
	@echo "  scss       - Compile SCSS to CSS (one-time)"
	@echo "  scss-watch - Watch and compile SCSS on changes"
	@echo "  first      - Full initial setup (build, start, install, migrate, seed, scss)"

build:
	docker-compose build

start:
	docker-compose up -d

stop:
	docker-compose down

restart: stop start

shell:
	docker-compose exec php bash

composer:
	docker-compose exec php composer $(CMD)

migrate:
	docker-compose exec php php database/migrate.php

seed:
	docker-compose exec php php database/seed.php

scss:
	docker-compose exec php npx sass scss:public/css --no-source-map

scss-watch:
	docker-compose exec php npx sass scss:public/css --no-source-map --watch

first:
	docker-compose build
	docker-compose up -d
	docker-compose exec -T php composer install
	docker-compose exec -T php chmod -R 777 var/smarty/
	docker-compose exec -T php php database/migrate.php
	docker-compose exec -T php php database/seed.php
	docker-compose exec -T php npx sass scss:public/css --no-source-map
