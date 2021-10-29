test:
	docker run --rm -d --name umt -v $(PWD):/var/www/html -w /var/www/html ubuntu-mailhog-testing:latest "/root/go/bin/MailHog"
	-docker exec umt php ./vendor/bin/phpunit tests
	docker stop umt
composer-exec:
	docker run --rm --interactive --tty --volume $(PWD):/app --user $(id -u):$(id -g) composer $(command)
install:
	docker build --rm --tag ubuntu-mailhog-testing:latest ./docker/Ubuntu