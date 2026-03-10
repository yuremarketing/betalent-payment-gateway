FROM php:8.2-fpm
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip libzip-dev unzip git curl
RUN docker-php-ext-install pdo_mysql bcmath gd zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
