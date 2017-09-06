FROM danpoltawski/moodle-php-apache:7.0

MAINTAINER williamjlee1@gmail.com

RUN docker-php-ext-install mcrypt
