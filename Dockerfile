FROM node:24-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

FROM composer:2 AS dependencies

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

COPY . .
RUN composer dump-autoload --no-dev --optimize --no-interaction

FROM php:8.5-apache-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        pcntl \
        pdo_mysql \
        zip \
    && a2enmod rewrite headers \
    && printf '%s\n' \
        'ServerTokens Prod' \
        'ServerSignature Off' \
        '<Directory /var/www/html/public>' \
        '    Options +FollowSymLinks' \
        '    AllowOverride All' \
        '    Require all granted' \
        '</Directory>' \
        > /etc/apache2/conf-available/laravel.conf \
    && printf '%s\n' \
        'Header always set X-Content-Type-Options "nosniff"' \
        'Header always set X-Frame-Options "SAMEORIGIN"' \
        'Header always set Referrer-Policy "strict-origin-when-cross-origin"' \
        'Header always set Permissions-Policy "camera=(), microphone=(), geolocation=()"' \
        >> /etc/apache2/conf-available/laravel.conf \
    && printf '%s\n' \
        'upload_max_filesize = 10M' \
        'post_max_size = 12M' \
        'memory_limit = 256M' \
        'max_execution_time = 60' \
        'opcache.enable = 1' \
        'opcache.memory_consumption = 128' \
        'opcache.max_accelerated_files = 10000' \
        'opcache.validate_timestamps = 0' \
        'opcache.jit = 1255' \
        'opcache.jit_buffer_size = 64M' \
        > /usr/local/etc/php/conf.d/app.ini \
    && a2enconf laravel \
    && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/000-default.conf \
        /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY --from=dependencies --chown=www-data:www-data /app ./
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build
COPY --chown=root:root docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && rm -rf public/storage \
    && ln -s ../storage/app/public public/storage \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
