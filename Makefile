.PHONY: run install test

test:
	docker run --rm -d --name umt -v $(PWD):/var/www/html -w /var/www/html ubuntu-mailhog-testing:latest "/root/go/bin/MailHog"
	-docker exec umt php ./vendor/bin/phpunit --testdox tests
	docker stop umt
run:
	docker run --rm --name umt -v $(PWD):/var/www/html -w /var/www/html --user $(id -u):$(id -g) ubuntu-mailhog-testing:latest $(cmd)
composer-install:
	docker run --rm --name umt -v $(PWD):/var/www/html -w /var/www/html --user $(id -u):$(id -g) ubuntu-mailhog-testing:latest composer install
docker-build:
	docker build --rm --tag ubuntu-mailhog-testing:latest ./docker/Ubuntu