
FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY public/ /var/www/html/


RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]



