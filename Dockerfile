FROM php:8.1-apache

# Instalar módulo rewrite do Apache
RUN a2enmod rewrite
RUN a2enmod headers

# Install PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Restart Apache
RUN service apache2 restart