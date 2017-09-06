# Set up environmental vars
export MOODLE_DOCKER_WWWROOT=$1
export MOODLE_DOCKER_DB=mysql

# Download the initial sql file

if ! [ -e assets/mysql/new_moodle_instance.sql ]; then    
    echo "Downloading SQL file to create new moodle instance DB..."
    curl -L https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql > assets/mysql/new_moodle_instance.sql
else
    echo "Initial SQL file already exists; no need to download it"
fi

# Save docker dir
docker=$(pwd)

# Go to moodle dir
cd $MOODLE_DOCKER_WWWROOT

echo "Setting up moodle config files..."
# Set up config files
if ! [ -h "$MOODLE_DOCKER_WWWROOT/config.php" ]; then
    echo "Config symlink does not exist, making it for the first time..."
    ln -s local/ucla/config/shared_dev_moodle-config.php config.php
else
    echo "Config symlink exists, no need to make a new one"
fi
echo "Copying custom moodle-docker config to config_private..."
cp "$docker/moodle-docker_config_private-dist.php" config_private.php

# Submodule update
echo "Updating moodle submodules..."
git submodule update --init --recursive

echo "Doing composer install and setup..."
curl -sS http://getcomposer.org/installer | php
php composer.phar install
php composer.phar install -d theme/uclashared

# Back to docker
cd $docker

echo "Spinning up the containers for the first time with bin/moodle-docker-compose up --build"
# Up the containers for the first time with the --build flag
bin/moodle-docker-compose up --build
