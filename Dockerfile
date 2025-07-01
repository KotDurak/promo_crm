FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/html