FROM php:8.1-apache

# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y tzdata dnsutils \
 && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
