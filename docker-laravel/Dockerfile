# Set master image
FROM php:8.1.3-fpm-alpine3.15

# Set working directory
WORKDIR /var/www/html

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --update npm \
    && docker-php-source extract \
    && docker-php-ext-install mysqli pdo pdo_mysql pcntl \
    && docker-php-source delete

# Remove Cache
RUN rm -rf /var/cache/apk/*

COPY ./supervisord.conf.default /etc/supervisord.conf
COPY ./supervisor.d /etc/supervisor.d

# pcntl: This extension required for Laravel Horizon

# Add UID '1000' to www-data
RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow && usermod -u 1000 www-data

# Copy existing application directory
COPY . .

ENV ENABLE_CRONTAB 0
ENV ENABLE_HORIZON 0
# horizon da bao gom worker
ENV ENABLE_WORKER 1

ENTRYPOINT ["sh", "/var/www/html/docker-laravel/docker-entrypoint.sh"]

CMD supervisord -n -c /etc/supervisord.conf