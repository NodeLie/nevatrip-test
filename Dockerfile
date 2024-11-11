FROM php:8.2-fpm

# Установите необходимые зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip

# Установите расширение pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Установите другие необходимые расширения
# RUN docker-php-ext-install другие_расширения