FROM composer:latest AS builder

WORKDIR /app

COPY ./composer.json ./composer.json
COPY ./composer.lock ./composer.lock

RUN composer install

FROM php:7.3-fpm-alpine

WORKDIR /app

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=builder /app/vendor /app/vendor

EXPOSE 9000
