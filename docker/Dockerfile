FROM php:8.2-alpine
LABEL maintainer="Ozeliurs <ozeliurs at gmail dot com>"

# Install system dependencies and Composer
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer

COPY ./composer.json ./composer.lock /var/www/html/

RUN composer install --no-dev --optimize-autoloader

COPY public/ src/ /var/www/html/

RUN rm -Rf /var/www/html/docker \
    && mkdir -p /var/www/html/vendor /var/www/html/database \
    && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

USER www-data

# Use PHP's built-in development server
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]

EXPOSE 80
