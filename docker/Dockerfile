FROM php:8.2-apache
LABEL maintainer="Ozeliurs <ozeliurs at gmail dot com>"

ARG DEBIAN_FRONTEND=noninteractive

# Install system dependencies and Composer
RUN apt-get update && apt-get --no-install-recommends install -y \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && a2enmod rewrite \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./composer.json ./composer.lock /var/www/html/

RUN composer install --no-dev --optimize-autoloader

COPY public/ src/ /var/www/html/

RUN rm -Rf /var/www/html/docker \
    && mkdir -p /var/www/html/vendor /var/www/html/database \
    && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

USER www-data

EXPOSE 80
