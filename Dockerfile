FROM php:8.2-apache

# Устанавливаем необходимые расширения
RUN docker-php-ext-install pdo pdo_mysql

# Копируем проект в контейнер
COPY . /var/www/html/

# Включаем модуль переписывания для Apache
RUN a2enmod rewrite

# Настраиваем Apache
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Устанавливаем права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
