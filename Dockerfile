FROM laravelsail/php81-composer:latest

RUN apt-get update \
    && apt-get install -y mariadb-client \
    && docker-php-ext-install pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
