FROM php:8.5-apache
WORKDIR /var/www/html
# download my sql PDO extension
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Change base root to public to ensure safety
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# change directory to public in APACHE config
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# enable Apache mod_rewrite for work with routing
RUN a2enmod rewrite