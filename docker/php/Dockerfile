FROM php:7.2-apache-stretch
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y libicu-dev \
    && apt-get install -y git zip unzip \
    && docker-php-ext-install pdo_mysql pdo_pgsql intl
