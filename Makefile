UID := $(shell id -u)
GID := $(shell id -g)
run := env UID=${UID} GID=${GID} docker-compose run --rm php-mailhog-testing

composer-install:
	docker run --rm --interactive -u $(shell id -u):$(shell id -g) --tty --volume $(shell pwd):/app composer install

composer-update:
	docker run --rm --interactive -u $(shell id -u):$(shell id -g) --tty --volume $(shell pwd):/app composer update

build:
	docker-compose build

.PHONY: test
test:
	-docker-compose run --rm php7.3-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	-docker-compose run --rm php7.4-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	-docker-compose run --rm php8.0-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	-docker-compose run --rm php8.1-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	-docker-compose run --rm php8.2-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	-docker-compose run --rm php8.3-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	-docker-compose run --rm php8.4-mailhog-testing ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	docker-compose down
