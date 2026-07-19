FROM php:8.4-cli

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libonig-dev libzip-dev libbrotli-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_pgsql gd opcache sockets pcntl \
    && pecl install swoole \
    && docker-php-ext-enable swoole

WORKDIR /var/www/html

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction --no-progress --optimize-autoloader

EXPOSE 8080

ENTRYPOINT ["php", "artisan"]
