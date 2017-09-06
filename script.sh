#!/bin/sh
echo $1
export MOODLE_DOCKER_WWWROOT=$1
export MOODLE_DOCKER_DB=mysql
docker=`pwd`
echo $docker

curl -L https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql > assets/mysql/new_moodle_instance.sql
cp config.docker-template.php $MOODLE_DOCKER_WWWROOT/config.php

cd $MOODLE_DOCKER_WWWROOT
curl -sS http://getcomposer.org/installer | php
php composer.phar install
php composer.phar install -d theme/uclashared
cd $docker

#run "sudo -E bin/moodle-docker-compose up -d" to up
#run "sudo -E bin/moodle-docker-compose down" to down
