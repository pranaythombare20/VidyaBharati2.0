# Use official PHP Apache image
FROM php:8.2-apache

# Copy all project files to the container
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
