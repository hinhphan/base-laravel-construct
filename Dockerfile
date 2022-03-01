# Set master image
FROM php:8.0.2-fpm-alpine3.12

# Set working directory
WORKDIR /var/www/html

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --update npm \
    && docker-php-source extract \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
        # pcntl \
    && docker-php-source delete

# pcntl: This extension required for Laravel Horizon

# Remove Cache
RUN rm -rf /var/cache/apk/*

# COPY ./.docker/supervisord.conf /etc/supervisord.conf
# COPY ./.docker/supervisor.d /etc/supervisor.d


# Add UID '1000' to www-data
RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add \
    # supervisor \
    shadow && usermod -u 1000 www-data

# Copy existing application directory
COPY . .

# Chang app directory permission
RUN chown -R www-data:www-data .

ENV ENABLE_CRONTAB 0
ENV ENABLE_HORIZON 0
# horizon da bao gom worker
ENV ENABLE_WORKER 0

# ENTRYPOINT ["sh", "/var/www/html/.docker/docker-entrypoint.sh"]

# CMD supervisord -n -c /etc/supervisord.conf