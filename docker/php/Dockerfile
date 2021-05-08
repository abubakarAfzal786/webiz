FROM php:7.3.26-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    gnupg2 \
    zip \
    libzip-dev \
    git \
    cron \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && apt-get install -y nodejs && apt-get install -y npm

#RUN curl -o- -L https://yarnpkg.com/install.sh | bash

#RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.34.0/install.sh | bash

RUN a2enmod rewrite && service apache2 restart

COPY ./apache_php/apache_config.conf /etc/apache2/sites-enabled/000-default.conf

COPY ./apache_php/php.ini /usr/local/etc/php/php.ini

COPY ./apache_php/cron /etc/crontab

#CMD ["cron", "-f"]