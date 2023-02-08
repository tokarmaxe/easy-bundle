FROM php:7.4-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN apt-get install -y libpng-dev
RUN apt-get update -yqq && \
    docker-php-ext-install pdo &&  \
   docker-php-ext-install pdo_mysql && \
    docker-php-ext-configure gd && \
    docker-php-ext-install gd

#RUN docker-php-ext-install gd

RUN docker-php-ext-install pcntl

#RUN pecl install libgearman && \
#    pecl install libevent \
#    && pecl install uuid \
#    && pecl install gearman
#RUN #apt-get install gearman-job-server -y
RUN apt-get install libgearman-dev -y \
    && apt-get install libevent-dev -y \
    && apt-get install uuid-dev -y \
    && pecl install gearman

RUN echo 'extension = gearman.so' > /usr/local/etc/php/conf.d/gearman.ini
RUN #echo "extension=gearman.so" | tee /usr/local/etc/php/conf.d/docker-php-ext-gearman.ini

RUN pecl install xdebug-2.9.0 && \
        docker-php-ext-enable xdebug


COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm", "--allow-to-run-as-root"]

EXPOSE 9000