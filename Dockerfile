# Use the official PHP Apache image
FROM php:8.1-apache

# Install the PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy your entire project into Apache's web root
COPY . /var/www/html/

# Expose port 80 (Apache)
EXPOSE 80
