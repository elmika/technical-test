
# DOCKER TASKS
# Build the container
rebuild: ## ReBuild the container
	docker stop simple_person | true
	docker build -t "registration-exercise" .
	docker run -d --rm -p 8000:80 --name=simple_person "registration-exercise"

test:
	docker exec -it simple_person bin/phpunit

sniff:
	php vendor/bin/phpcs --standard=PSR2 src

sniff-and-fix:
	php vendor/bin/phpcbf --standard=PSR2 src
