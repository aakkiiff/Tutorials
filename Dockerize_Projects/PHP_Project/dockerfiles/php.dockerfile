FROM php:8.3.4-fpm-alpine3.18
 
WORKDIR /var/www/html
 
COPY ./src .

RUN docker-php-ext-install pdo pdo_mysql
 
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel
 
RUN chown -R laravel:laravel .

USER laravel 