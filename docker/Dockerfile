FROM php:5.6-apache

COPY ./php/php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
  && apt-get install -y git g++ libmcrypt-dev \
  && docker-php-ext-install mcrypt pdo_mysql mysqli \
  && pecl install xdebug-2.5.5 \
  && docker-php-ext-enable xdebug \
  && apt-get purge --auto-remove -y g++ \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
  && curl -sSL https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer
