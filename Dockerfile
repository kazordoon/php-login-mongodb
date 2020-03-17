FROM php:7.4-apache
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mongodb
COPY ./src /var/www/html
WORKDIR /var/www/html
