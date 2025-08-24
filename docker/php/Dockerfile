# PHP 8.4 FPM + Alpine 3.20 — image DEV
FROM php:8.4-fpm-alpine3.20 AS php84
SHELL ["/bin/ash", "-o", "pipefail", "-c"]

# Vars env
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    PATH="$PATH:/home/dockeruserphp/.composer/vendor/bin" \
    XDEBUG_MODE=off

# ----- System dependencies (runtime + build) -----
RUN apk update && apk add --no-cache \
    bash shadow curl curl-dev libzip libzip-dev \
    git unzip zip icu icu-dev oniguruma oniguruma-dev libxml2 libxml2-dev \
    libpng libpng-dev libjpeg-turbo libjpeg-turbo-dev freetype freetype-dev libwebp libwebp-dev \
    gmp gmp-dev openssl openssl-dev \
    postgresql-dev sqlite-dev \
    imagemagick imagemagick-dev \
    rabbitmq-c rabbitmq-c-dev \
    libsodium libsodium-dev \
    libmemcached libmemcached-libs libmemcached-dev cyrus-sasl-dev \
    linux-headers autoconf make g++ pkgconfig

# ----- Extensions PHP  -----
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j"$(nproc)" \
    gd intl mbstring xml gmp opcache \
    pdo pdo_mysql pdo_pgsql pdo_sqlite mysqli \
    curl zip exif pcntl sodium bcmath sockets

# ----- PECL -----
RUN pecl install redis apcu igbinary amqp imagick xdebug pcov memcached \
 && docker-php-ext-enable redis apcu igbinary amqp imagick xdebug pcov memcached

# ----- Cleaning -----
RUN apk del --no-network g++ make autoconf pkgconfig linux-headers \
 && rm -rf /var/cache/apk/* /tmp/pear

# ----- Composer 2.8 -----
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# ----- User non-root -----
ARG HOST_UID=1000
ARG HOST_GID=1000
RUN groupadd -g $HOST_GID dockerusergroup \
 && useradd -m -u $HOST_UID -g dockerusergroup dockeruserphp \
 && mkdir -p /var/www /app \
 && chown -R dockeruserphp:dockerusergroup /var/www /app

# ----- Symfony CLI -----
RUN curl -sS https://get.symfony.com/cli/installer | bash \
 && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

USER dockeruserphp
WORKDIR /app
EXPOSE 9000
CMD ["php-fpm", "-F"]
