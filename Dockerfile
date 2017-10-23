FROM moodlehq/moodle-php-apache:7.0

MAINTAINER amit.mondal2016@gmail.com

# Install mcrypt to get rid of those pesky mcrypt constant
# not defined errors (not sure how much we really need this though)

RUN docker-php-ext-install mcrypt

# Add config files for registrar connection

ADD ./assets/files/etc/freetds.conf ./assets/files/etc/odbc.ini /etc/

# Add php.ini file

ADD ./assets/files/etc/php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install unzip git unixODBC-dev libpq-dev -y

# Found this stuff here: https://github.com/docker-library/php/issues/103
# This gets rid of ODBC errors at the top of the page in Moodle, but doesn't automatically
# fix the registrar connection

RUN set -x \
    && docker-php-source extract \
    && cd /usr/src/php/ext/odbc \
    && phpize \
    && sed -ri 's@^ *test +"\$PHP_.*" *= *"no" *&& *PHP_.*=yes *$@#&@g' configure \
    && ./configure --with-unixODBC=shared,/usr \
    && docker-php-ext-install odbc \
    && docker-php-source delete

# Quite sure this stuff is necessary - it just installs a bunch of php pdo extensions
RUN set -x \
    && apt-get install -y unixodbc unixodbc-dev freetds-dev freetds-bin tdsodbc \
    && if ! [ -h /usr/lib/libsybdb.a ]; then ln -s /usr/lib/x86_64-linux-gnu/libsybdb.a /usr/lib/; fi \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_dblib \
    && docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
    && docker-php-ext-install pdo_odbc

# Much of the following code was adapted from https://hub.docker.com/r/stephenbutcher/mar10c7/~/dockerfile/

# Add FreeTDS driver info to the odbcinst.ini file
RUN echo "[FreeTDS]" >> /etc/odbcinst.ini
RUN echo "Driver = /usr/lib/x86_64-linux-gnu/odbc/libtdsodbc.so" >> /etc/odbcinst.ini
RUN echo "">> /etc/odbcinst.ini

# Not really sure what this line does (or if it's necessary)
RUN odbcinst -i -d -f /etc/odbcinst.ini
