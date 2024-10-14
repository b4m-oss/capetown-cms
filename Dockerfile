# Define base image
FROM php:8.2-fpm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install packages for Laravel and PostgreSQL support
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql

# Define working directory
WORKDIR /app

# Copy composer.json and install with it
COPY ./dev/composer.json ./
RUN composer install --prefer-dist --no-scripts --no-autoloader

# Copy source code
COPY . .

# Fire dump auto-load
RUN composer dump-autoload

# CMDは必要に応じて設定（PHP-FPMのデフォルト起動で問題ない）
