# ----------------------
# The FPM base container
# ----------------------
FROM php:7.4-fpm-alpine AS dev

# Install dev dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    curl-dev \
    libtool \
    libxml2-dev \
    postgresql-dev

# Install production dependencies
RUN apk add --no-cache \
    bash \
    curl \
    freetype-dev \
    g++ \
    gcc \
    git \
    icu-dev \
    icu-libs \
    libc-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    make \
    oniguruma-dev \
    openssh-client \
    postgresql-libs \
    rsync \
    supervisor \
    zlib-dev

# Install PECL and PEAR extensions
RUN pecl install \
    redis

# Enable PECL and PEAR extensions
RUN docker-php-ext-enable \
    redis

# Install php extensions
RUN docker-php-ext-install \
    bcmath \
    calendar \
    curl \
    exif \
#    iconv \
    intl \
    mbstring \
    pdo \
    pdo_pgsql \
    pcntl \
#    tokenizer \
    xml \
    zip

# Cleanup dev dependencies
RUN apk del -f .build-deps

# Cleanup apk cache and temp files
RUN rm -rf /var/cache/apk/* /tmp/*

# ----------------------
# Composer install step
# ----------------------

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ----------------------
# The FPM production container
# ----------------------
FROM dev

COPY ./.docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY . /app

RUN mkdir -p /var/log/cron
RUN mkdir -p /var/log/supervisor

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/secu-supervisor.ini"]
