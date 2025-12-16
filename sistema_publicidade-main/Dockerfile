FROM php:8.2-apache

# Extensões PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configuração direta do Apache (SEM vhost externo)
RUN echo '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/nexus\n\
    <Directory /var/www/html>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride None\n\
        Require all granted\n\
    </Directory>\n\
    <Directory /var/www/html/nexus>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride None\n\
        Require all granted\n\
        DirectoryIndex index.php index.html\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
