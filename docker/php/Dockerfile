FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Dependencies
RUN set -ex \
    && apk update \
    && apk add --no-cache \
        bash \
        bash-completion \
        coreutils \
        freetype \
        icu-libs \
        libbz2 \
        libcurl \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng \
        libpq \
        libxml2 \
        libxpm-dev \
        libxslt-dev \
        libzip-dev \
        linux-headers \
        oniguruma \
        nano \
        unzip \
        util-linux \
        util-linux-bash-completion \
        wget \
        zlib \
        zstd-dev

# Install PHP extensions
RUN set -ex \
    && apk add --no-cache --virtual .build-deps \
        autoconf \
        bzip2-dev \
        curl-dev \
        file \
        freetype-dev \
        gcc \
        git \
        krb5-dev \
        krb5-conf \
        libc-dev \
        libpng-dev \
        make \
        oniguruma-dev \
        postgresql-dev \
        zlib-dev \
    && pecl install apcu igbinary xdebug \
    && docker-php-ext-enable apcu igbinary xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && yes | pecl install msgpack redis \
#    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd \
       --with-freetype=/usr/include/ \
       --with-jpeg=/usr/include/ \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/include/postgresql/ \
    && docker-php-ext-install \
        bcmath \
        curl \
        gd \
        intl \
#        json \
        mbstring \
        opcache \
        pcntl \
        pgsql \
        pdo \
        pdo_pgsql \
        soap \
        sockets \
        xsl \
        zip \
    && apk del --no-network .build-deps

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
