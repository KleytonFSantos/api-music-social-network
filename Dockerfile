FROM php:8.1 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

WORKDIR /var/www
COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

ENV PORT=8000
RUN ["chmod", "a+x", "./entrypoint.sh"]
ENTRYPOINT [ "./entrypoint.sh" ]
CMD [ "run" ]

# ===============================================================================================

#node

FROM node:18.12-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install

VOLUME /var/www/node_modules
