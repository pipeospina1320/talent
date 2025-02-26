FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y curl libpng-dev libonig-dev libxml2-dev unzip libzip-dev default-mysql-client

# Instala las extensiones de PHP y Composer
RUN docker-php-ext-install pdo_mysql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

ENV COMPOSER_ALLOW_SUPERUSER = 1
RUN composer install
EXPOSE 80
