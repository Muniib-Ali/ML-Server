FROM php:8.1.4 as php

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /var/www
COPY . .

COPY --from=composer:2.6.4 /usr/bin/composer /usr/bin/composer
ENV PORT=8000
ENTRYPOINT [ "Docker/entrypoint.sh" ]