
# DOCKER TASKS
# Build the container
rebuild: ## ReBuild the container - only for DEV!
	docker stop simple_person | true
	docker-compose up --build

clear-cache:
	docker exec -it simple_person bin/console cache:clear

composer-install:
	docker exec -it simple_person composer install

composer-update:
	docker exec -it simple_person composer update

composer-self-update:
	docker exec -it simple_person composer self-update --2

composer-self-update-rollback:
	docker exec -it simple_person composer self-update --rollback

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
