FROM php:7.4-alpine

COPY . /app
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR app

CMD php -S 0.0.0.0:80 public/index.php