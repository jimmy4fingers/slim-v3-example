FROM php:7.2.6-fpm-stretch

RUN apt-get update \
    && apt-get install zip -y \
    && apt-get install unzip -y

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$(curl -s https://composer.github.io/installer.sig)')  { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer

RUN composer install -a; exit 0