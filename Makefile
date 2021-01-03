DOCKER_COMPOSE=docker-compose

tests:
				symfony console doctrine:fixtures:load -n
				symfony php bin/phpunit tests/ConferenceControllerTest.php
.PHONY: 			tests

start:
				$(DOCKER_COMPOSE) up -d

stop:			## Stop all containers
				$(DOCKER_COMPOSE) stop

phpcsfixer:
				vendor/bin/php-cs-fixer fix --config=.php_cs.dist