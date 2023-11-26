FROM php:8.0-apache

WORKDIR /var/www/html

RUN apt-get update -y && \
    apt-get install -y default-libmysqlclient-dev

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli