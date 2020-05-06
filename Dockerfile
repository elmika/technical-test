FROM php:7.3-alpine

COPY . /

CMD php -S 0.0.0.0:80 public/index.php