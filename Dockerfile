FROM php:7-apache
RUN apt-get update
RUN docker-php-ext-install pdo_mysql mbstring
RUN sed -i -E 's/^(expose_php = )On/\1Off/' /usr/local/etc/php/php.ini-development  && \
    sed -i -E 's/^(session.name = )PHPSESSID/\1SID/' /usr/local/etc/php/php.ini-development && \
    mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    a2enmod rewrite
RUN echo 'error_reporting = E_ALL' >> /usr/local/etc/php/conf.d/99_myconf.ini
RUN echo 'date.timezone = Asia/Tokyo' >> /usr/local/etc/php/conf.d/99_myconf.ini
