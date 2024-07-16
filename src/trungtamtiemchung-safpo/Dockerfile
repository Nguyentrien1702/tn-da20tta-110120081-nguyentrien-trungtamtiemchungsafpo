# Sử dụng PHP 7.4 FPM như là base image
FROM php:7.4-fpm

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install pdo_mysql

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy các file cấu hình và mã nguồn vào container
COPY . .

# Cài đặt Composer và các dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader

# Thiết lập quyền cho thư mục storage và bootstrap
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Generate mã autoload và chạy các scripts
RUN composer dump-autoload
RUN php artisan key:generate

# Expose cổng mặc định của PHP-FPM
EXPOSE 9000

# CMD để start PHP-FPM
CMD ["php-fpm"]
