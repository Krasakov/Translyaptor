FROM php:7.4-fpm

RUN apt-get update \
     && apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-configure zip \
    && pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install mysqli zip pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["php-fpm"]
