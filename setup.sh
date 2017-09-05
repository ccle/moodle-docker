# Set up environmental vars
export MOODLE_DOCKER_WWWROOT=$1
export MOODLE_DOCKER_DB=mysql

# Download the initial sql file
curl -L https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql > assets/mysql/new_moodle_instance.sql

# Save docker dir
docker=$(pwd)

# Go to moodle dir and set up composer
cd $MOODLE_DOCKER_WWWROOT
curl -sS http://getcomposer.org/installer | php \
php composer.phar install \
php composer.phar install -d theme/uclashared

# Back to docker
cd $docker

# Up the containers for the first time with the --build flag
sudo -E bin/moodle-docker-compose up --build
