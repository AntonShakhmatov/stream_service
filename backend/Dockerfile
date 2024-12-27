FROM php:8.2-fpm

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Установка рабочего окружения
WORKDIR /var/www/html/backend

# Установка прав
RUN chown -R www-data:www-data /var/www/html/backend

# Переменные окружения
ENV APACHE_DOCUMENT_ROOT /var/www/html/backend/public
EXPOSE 9000

CMD ["php-fpm"]
