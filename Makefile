# HELP
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

include .env
dc := docker-compose
CONTAINER_NAME := app
ARGS = $(filter-out $@,$(MAKECMDGOALS))

.SILENT: ;               # no need for @
.EXPORT_ALL_VARIABLES: ; # send all vars to shell

default: help

check:
ifeq ($(APP_NAME),)
	$(error Missed APP_NAME argument.)
endif

build: down check ## Run build
	$(dc) build --force-rm
	make up
	$(dc) exec -T "$(CONTAINER_NAME)" composer install --optimize-autoloader --no-interaction --ansi --no-suggest
	$(dc) exec "$(CONTAINER_NAME)" php artisan key:gen
	$(dc) exec "$(CONTAINER_NAME)" php artisan migrate:fresh --seed
	$(dc) exec "$(CONTAINER_NAME)" php artisan storage:link

code-sniff: ## Run code sniff
	$(dc) exec -T "$(CONTAINER_NAME)" ./vendor/bin/phpcs $(git diff --name-only)

up: ## Run containers
	$(dc) up -d --remove-orphans

down: ## Remove docker containers
	$(dc) down

bash: ## Bash to main container
	$(dc) exec "$(CONTAINER_NAME)" bash

logs: ## Docker logs
	$(dc) logs $(ARGS)

config: ## Show container config
	$(dc) config

test: up ## Execute application tests
	$(dc) exec "$(APP_CONTAINER_NAME)" ./vendor/bin/phpunit
