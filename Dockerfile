# Use the official PHP-Apache base image
FROM php:8.1-apache

# Install libpq (Postgres client headers), then build both MySQL and Postgres PDO drivers
RUN apt-get update \
 && apt-get install -y libpq-dev \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql \
 && rm -rf /var/lib/apt/lists/*

# Copy your entire project into Apache's web root
COPY . /var/www/html/

# Expose port 80 so Render’s router can reach it
EXPOSE 80

