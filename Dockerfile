ARG PHP_EXTENSIONS="pdo_mysql pdo_sqlite"
FROM thecodingmachine/php:7.4-v3-slim-apache AS php
ENV TEMPLATE_PHP_INI=production \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN composer global require hirak/prestissimo
ENV COMPOSER_ALLOW_SUPERUSER 1

ADD --chown=docker:docker . /var/www/html

WORKDIR /var/www/html

### PHP Development
FROM php AS php-dev

RUN composer install

### PHP Production
FROM php AS php-prod

RUN composer install --quiet --optimize-autoloader

WORKDIR /var/www/html
