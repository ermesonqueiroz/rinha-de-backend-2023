FROM php:8.2-cli
WORKDIR /var/www/html

RUN apt-get update
RUN apt-get install git libzip-dev libcurl4-openssl-dev libsodium-dev -y
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

COPY . .
RUN php composer.phar install

CMD ["php","artisan","serve","--host=0.0.0.0"]
