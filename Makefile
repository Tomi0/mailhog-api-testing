test:
	docker run -it --rm --volume $(PWD):/var/www/html --workdir="/var/www/html" --user $(id -u):$(id -g) php:8.0-cli ./vendor/bin/phpunit tests
composer-install:
	docker run --rm --interactive --tty --volume $(PWD):/app --user $(id -u):$(id -g) composer composer install