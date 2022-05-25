FROM php:8-apache

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli

RUN docker-php-ext-install pdo pdo_mysql

RUN apt update -y

RUN apt install -y libpng-dev

RUN docker-php-ext-install gd

COPY . /var/www/html

RUN mkdir /var/www/html/data

RUN chmod -R 777 /var/www/html/data
