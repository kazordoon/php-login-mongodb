FROM php:7.4-apache
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mongodb
RUN  apt update && apt install git zip unzip -y
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer
COPY ./src /var/www/html
WORKDIR /var/www/html
RUN cd /var/www/html && composer update
