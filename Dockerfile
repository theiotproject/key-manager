# Use the official PHP image as the base image
FROM php:8.0-fpm

# Set the working directory within the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install Composer globally
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Configure and install the ext-gd extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Install PDO extension for MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copy your Laravel application files into the container
COPY . /var/www/html

# Install Laravel dependencies
RUN composer install

# Set permissions for Laravel storage and bootstrap cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Change the working directory
WORKDIR /var/www/html

# Expose port 9000 to connect with PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
