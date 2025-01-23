# Usa una imagen base con PHP y Apache
FROM php:8.2-apache

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Instala extensiones PHP necesarias
RUN docker-php-ext-install mysqli

# Configuración adicional para permisos
RUN chown -R www-data:www-data /var/www/html
