FROM php:8.3-apache
COPY . /var/www/html/
RUN apt-get update
RUN docker-php-ext-install mysqli