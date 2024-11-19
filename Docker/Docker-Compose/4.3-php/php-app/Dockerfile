FROM php:7.4-fpm

# Install required extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable installed extensions
RUN docker-php-ext-enable mysqli pdo pdo_mysql
