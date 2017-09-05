# git clone https://github.com/ccle/moodle-docker.git
# cd moodle-docker
# git checkout ucla_mod
# git clone git@github.com:ucla/moodle.git
# cd moodle
# git submodule update --init --recursive
# curl -sS http://getcomposer.org/installer | php
# php composer.phar install
# php composer.phar install -d theme/uclashared
# cp ../config.docker-template.php config_private.php
# ln -s local/ucla/config/shared_dev_moodle-config.php config.php
# export MOODLE_DOCKER_WWWROOT=$(pwd)
# export MOODLE_DOCKER_DB=mysql
# cd ..
# bin/moodle-docker-compose up -d
# docker exec -ti moodledocker_db_1 /bin/bash
# apt-get -qq update
# apt-get -qq -y install wget
# cd /tmp && wget https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql && mysql -u moodle --password="m@0dl3ing" moodle < /tmp/new_moodle_instance.sql
# exit
# Now you should be able to access http://localhost:8000/
# bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/init.php
# bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/run.php --tags=@ucla
# Stop docker containers use: bin/moodle-docker-compose stop