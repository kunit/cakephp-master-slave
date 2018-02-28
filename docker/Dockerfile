FROM php:5.6-apache

COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./php/php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
  && apt-get install -y curl wget git libmcrypt-dev libicu-dev zlib1g-dev mysql-client \
  && docker-php-ext-install mcrypt pdo_mysql zip intl \
  && pecl install xdebug-2.5.5 \
  && docker-php-ext-enable xdebug \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
  && curl -sSL https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && a2enmod rewrite

ENV DOCKERIZE_VERSION v0.6.0
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
  && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
  && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz
