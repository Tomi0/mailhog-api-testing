FROM composer:2.2.7 AS composer

FROM php:8.1-bullseye

RUN apt-get update && DEBIAN_FRONTEND="noninteractive" apt-get -y install \
    sendmail \
    ca-certificates \
    apt-transport-https \
    software-properties-common \
    libonig-dev \
    libzip-dev \
    libcurl4-gnutls-dev \
    libxml2-dev \
    zip

RUN docker-php-ext-install mbstring zip curl xml

COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 9000