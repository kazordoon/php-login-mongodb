FROM php:8.1.8-apache

# Installing mongodb extension for PHP
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mongodb

# Installing composer
RUN  apt update && apt install git zip unzip -y
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

COPY ./src /var/www/html
COPY ./apache/000-default.conf /etc/apache2/sites-available
WORKDIR /var/www/html

# Enable the rewrite mod on apache
RUN a2enmod rewrite && \
    service apache2 restart

EXPOSE 80
