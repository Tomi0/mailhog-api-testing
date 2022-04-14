UID := $(shell id -u)
GID := $(shell id -g)
run := env UID=${UID} GID=${GID} docker-compose run --rm php-mailhog-testing


.PHONY: test
test:
	-$(run) ./vendor/bin/phpunit --testdox --configuration ./phpunit.xml
	env UID=${UID} GID=${GID} docker-compose down

.PHONY: composer-install
composer-install:
	$(run) composer install

.PHONY: composer-update
composer-update:
	$(run) composer update

.PHONY: docker-build
docker-build:
	env UID=${UID} GID=${GID} docker-compose build