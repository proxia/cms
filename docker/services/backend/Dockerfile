FROM dunglas/frankenphp:php8.4-alpine

RUN set -ex \
    && install-php-extensions \
    apcu \
    gd \
    gettext \
    intl \
    mysqli \
    pdo_mysql \
    opcache \
    zip

RUN apk add --no-cache composer git 7zip

RUN set -e \
    && sed -i -e 's/\/usr\/bin\/php83/\/usr\/local\/bin\/php/g' /usr/bin/composer

WORKDIR /app
