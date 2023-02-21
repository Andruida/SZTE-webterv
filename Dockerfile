FROM php:8.1-apache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod a+x /usr/local/bin/install-php-extensions \ 
 && apt-get update && apt-get install -y tzdata dnsutils \
 && apt-get clean


RUN install-php-extensions mysqli \
 && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
