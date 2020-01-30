up:
	docker-compose up -d

down:
	docker-compose down

ps:
	docker-compose ps

build:
	docker-compose up -d --build

test:
	docker-compose exec php-cli vendor/bin/phpunit --colors=always

perm:
	docker-compose exec php-cli chmod 777 bootstrap/cache -R
	docker-compose exec php-cli chmod 777 storage -R

assets-install:
	docker-compose exec node yarn install

assets-dev:
	docker-compose exec node yarn run dev

assets-watch:
	docker-compose exec node yarn run watch
