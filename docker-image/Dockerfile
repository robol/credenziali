FROM php:7.4-apache
RUN apt-get update && apt-get install -y libldap2-dev && \
    docker-php-ext-install ldap && \
    rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html
