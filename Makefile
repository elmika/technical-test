
# DOCKER TASKS
# Build the container
rebuild: ## ReBuild the container - only for DEV!
	docker stop simple_person | true
	docker-compose up --build

test:
	docker exec -it simple_person bin/phpunit

sniff:
	php vendor/bin/phpcs --standard=PSR2 src

clean:
	php vendor/bin/phpcbf --standard=PSR2 src

logs:
	docker logs -f simple_person

shell:
	docker exec -it simple_person /bin/sh
