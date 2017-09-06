FROM danpoltawski/moodle-php-apache:7.0

MAINTAINER amit.mondal2016@gmail.com

RUN docker-php-ext-install mcrypt

RUN apt-get update \
  && apt-get install unzip git unixODBC-dev libpq-dev -y

RUN set -x \
    && docker-php-source extract \
    && cd /usr/src/php/ext/odbc \
    && phpize \
    && sed -ri 's@^ *test +"\$PHP_.*" *= *"no" *&& *PHP_.*=yes *$@#&@g' configure \
    && ./configure --with-unixODBC=shared,/usr \
    && docker-php-ext-install odbc \
    && docker-php-source delete

ADD ./assets/files/etc/freetds.conf ./assets/files/etc/odbc.ini /etc/


