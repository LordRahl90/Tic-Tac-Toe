FROM php:7.2-apache

MAINTAINER Alugbin LordRahl Abiodun Olutola <alugbin.abiodun@gmail.com>

COPY ./ /var/www/html

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf


#Install PHP plugins
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd mbstring bcmath pdo pdo_mysql zip sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN chown -R www-data:www-data /var/www/html/storage /var/www/bootstrap/cache /var/www/html && a2enmod rewrite && service apache2 restart

RUN chmod -R 777 /storage

#Lets clean the docker application.
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan config:cache