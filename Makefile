test:
	@docker-compose up -d 2> /dev/null
	@docker-compose run --rm --user $(id -u):$(id -g) php-mailhog-testing ./vendor/bin/phpunit tests
	@docker-compose down 2> /dev/null
composer-install:
	docker run --rm --interactive --tty --volume $(PWD):/app --user $(id -u):$(id -g) composer composer install