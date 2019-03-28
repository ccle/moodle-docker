# Check some args
if ! [[ -d "$1" ]]; then
    echo "Error: The first argument must be the path to your moodle code. '$1' is not a directory"
    exit 1
fi    

# Set up environmental vars
export MOODLE_DOCKER_WWWROOT=$1
export MOODLE_DOCKER_DB=mariadb

# Download the initial sql file

if ! [ -e assets/mysql/new_moodle_instance.sql ]; then    
    echo "Downloading SQL file to create new moodle instance DB..."
    curl -L https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql > assets/mysql/new_moodle_instance.sql
else
    echo "Initial SQL file already exists; no need to download it"
fi

# Save docker dir
docker=$(pwd)

# Clone the e-mail directory

if ! [ -d ./assets/ccle_email_templates ]; then
    echo "Cloning CCLE email templates..."
    git clone git@github.com:ucla/ccle_email_templates.git ./assets/ccle_email_templates
else
    cd ./assets/ccle_email_templates
    git checkout
    cd $docker
fi

# Go to moodle dir
cd $MOODLE_DOCKER_WWWROOT

echo "Setting up moodle config files..."
# Set up config files
if ! [ -L "config.php" ]; then
    echo "Config symlink does not exist, making it for the first time..."
    ln -s local/ucla/config/shared_dev_moodle-config.php config.php
else
    echo "Config symlink exists, no need to make a new one"
fi
if ! [ -f "config_private.php" ]; then
    echo "Copying custom moodle-docker config to config_private..."
    cp "$docker/moodle-docker_config_private-dist.php" config_private.php
else
    echo "Config private exists, no need to make a new one"
fi

# Submodule update
echo "Updating moodle submodules..."
git submodule update --init --recursive

# See if we need to do the composer update
if ! [ -e composer.phar ]; then
    echo "Doing composer install and setup..."
    curl -sS http://getcomposer.org/installer | php
    php composer.phar install
else
    echo "Composer set already done; no need to redo"
fi

# Back to docker
cd $docker

buildflag='--build'
if [ "$2" == "--no-build" ] || [ "$3" == "--no-build" ]; then
    buildflag='-d'
fi

if [ "$2" == "--with-sudo" ] || [ "$3" == "--with-sudo" ]; then
    # Up the containers for the first time with the --build flag (only use sudo if necessary)
    echo "Spinning up the containers for the first time with sudo -E bin/moodle-docker-compose up $buildflag"
    sudo -E bin/moodle-docker-compose up $buildflag
else
    echo "Spinning up the containers for the first time with bin/moodle-docker-compose up $buildflag"
    bin/moodle-docker-compose up $buildflag
    # If the script failed, let the user know they probably need to run with sudo
    if ! [ $? -eq 0 ]; then
	echo ""
	echo "It seems 'docker-compose up' has failed; try running this script with the '--with-sudo' flag"
    fi
fi
