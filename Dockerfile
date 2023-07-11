# Utiliser l'image officielle de PHP avec Apache
FROM php:apache

# Activez l'extension MySQLi
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copier les fichiers du site web dans le répertoire du serveur Apache
ADD . /var/www/html

# Exposer le port 80 pour les requêtes HTTP
EXPOSE 80


