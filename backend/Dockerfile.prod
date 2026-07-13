FROM composer:latest as builder

WORKDIR /var/www/html

COPY composer.json ./
COPY . .

RUN composer install --no-interaction --no-progress --optimize-autoloader

FROM php:8.4-cli

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libonig-dev libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_pgsql gd opcache sockets pcntl


WORKDIR /var/www/html

COPY . .

COPY --from=builder /var/www/html/vendor /var/www/html/vendor

EXPOSE 8080

ENTRYPOINT ["php", "artisan"]
