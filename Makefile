test:
	docker run --rm -d --name umt -p 1025:1025 -p 8025:8025 ubuntu-mailhog-testing:latest "/root/go/bin/MailHog"
	docker exec umt sleep 2
	docker stop umt
composer-exec:
	docker run --rm --interactive --tty --volume $(PWD):/app --user $(id -u):$(id -g) composer $(command)
install:
	docker build --rm --tag ubuntu-mailhog-testing:latest ./docker/Ubuntu