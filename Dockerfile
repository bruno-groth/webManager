FROM php:8.1-apache

# Instalar módulo rewrite do Apache
RUN a2enmod rewrite