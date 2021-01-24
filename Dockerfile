FROM php:7.4.11-fpm
RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN apt-get -y install curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer update
RUN composer install
RUN curl -sL -o/var/cache/apt/archives/google-chrome-stable_current_amd64.deb https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb &&  apt -y install /var/cache/apt/archives/google-chrome-stable_current_amd64.deb
RUN apt-get -yf install
RUN php artisan dusk:install
RUN php artisan dusk:chrome-driver --detect
CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000

