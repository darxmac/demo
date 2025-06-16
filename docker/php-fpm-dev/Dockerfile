FROM php:7.4-fpm
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions gd pdo pdo_mysql mcrypt intl soap mbstring sqlite3 zip mysqli redis xdebug

RUN apt-get update -y \
        && apt-get -y --no-install-recommends install wget pngquant jpegoptim curl

RUN apt-get install -y git
RUN apt-get install -y sudo

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini
COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

# SETUP PHP-FPM CONFIG SETTINGS (max_children / max_requests)
RUN echo 'pm.max_children = 30' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_requests = 500' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    sudo mv composer.phar /usr/local/bin/composer

