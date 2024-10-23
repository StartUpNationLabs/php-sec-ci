FROM php:8.2-apache
LABEL maintainer="YOUR NAME <YOUR EMAIL>"

ARG DEBIAN_FRONTEND=noninteractive

ARG SQLITE_VERSION=3430200
ARG SQLITE_YEAR=2023

ARG XDEBUG_VERSION="3.3.0"

ARG BUILD_DATE
ARG TAG
ARG GIT_COMMIT
ARG GIT_URL
ARG PROJECT_USERNAME="SI5"

ENV VERSION="${TAG}"

# Metadata
LABEL maintainer="${PROJECT_USERNAME}" \
    org.opencontainers.image.authors="${PROJECT_USERNAME}" \
    org.opencontainers.image.url="${GIT_URL}" \
    org.opencontainers.image.version="${VERSION}" \
    org.opencontainers.image.vendor="${PROJECT_USERNAME}" \
    org.opencontainers.image.licenses="proprietary" \
    org.opencontainers.image.title="PHP Devops TP" \
    org.opencontainers.image.description="Example of a PHP application automatically encapsulated inside a docker container by the CI pipeline" \
    org.opencontainers.image.revision="${GIT_COMMIT}" \
    org.opencontainers.image.source="${GIT_URL}"

ENV DATABASE_DRIVER=sqlite
ENV DATABASE_DATABASE=/var/www/html/database/db.sqlite

# Install system dependencies, SQLite, Xdebug, PHP extensions, Infisical CLI, and Composer
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev unzip wget \
    apt-utils apt-transport-https bash curl \
    && mkdir /opt/sqlite3 && cd /opt/sqlite3 \
    && wget https://www.sqlite.org/${SQLITE_YEAR}/sqlite-autoconf-${SQLITE_VERSION}.tar.gz \
    && tar xvfz sqlite-autoconf-${SQLITE_VERSION}.tar.gz \
    && cd sqlite-autoconf-${SQLITE_VERSION} \
    && CFLAGS="-O2 -DSQLITE_ENABLE_COLUMN_METADATA=1" ./configure \
    && make -j$(nproc) && make install \
    && ln -s /usr/local/bin/sqlite3 /usr/bin/sqlite3 \
    && cd / && rm -Rf /opt/sqlite3 \
    && pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip pdo_sqlite \
    && curl -1sLf 'https://dl.cloudsmith.io/public/infisical/infisical-cli/setup.deb.sh' | bash \
    && apt-get update && apt-get install -y infisical \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && a2enmod rewrite \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./composer.json ./composer.lock /var/www/html/

RUN composer install --no-dev --optimize-autoloader

COPY . /var/www/html

RUN rm -Rf /var/www/html/docker \
    && mkdir -p /var/www/html/vendor /var/www/html/database \
    && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

EXPOSE 80
