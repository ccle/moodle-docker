# moodle-docker for CCLE

[![Build Status](https://travis-ci.com/ccle/moodle-docker.svg?branch=ucla)](https://travis-ci.com/ccle/moodle-docker/branches)

So you want to get CCLE up and running locally? Well, you've come to the right place. This repository contains a Docker config aimed at
CCLE developers to easily deploy a testing environment for CCLE

## Features:

- All supported database servers (PostgreSQL, MySQL, Micosoft SQL Server, Oracle XE)
- Behat/Selenium configuration for Firefox and Chrome
- Catch-all smtp server and web interface to messages using [MailHog](https://github.com/mailhog/MailHog/)
- All PHP Extensions enabled configured for external services (e.g. solr, ldap)
- All supported PHP versions
- Zero-configuration approach
- Backed by [automated tests](https://travis-ci.org/ccle/moodle-docker/branches)

## Prerequisites

- [Docker](https://docs.docker.com) and [Docker Compose](https://docs.docker.com/compose/) installed
- 3.25GB of RAM (to [run Microsoft SQL Server](https://docs.microsoft.com/en-us/sql/linux/sql-server-linux-setup#prerequisites))
- Git: http://git-scm.com/
- Access to the CCLE codebase.
  - Make sure you are using SSH keys to access to the CCLE codebase: https://help.github.com/articles/generating-ssh-keys

### Download and set up environment

Note: If you already have the CCLE codebase set up, you can skip step 2 and clone moodle-docker wherever you want.

1. Check out moodle-docker
   - mkdir ~/Projects && cd ~/Projects
   - git clone git@github.com:ccle/moodle-docker.git ccle
   - cd ~/Projects/ccle
2. Check out CCLE the codebase from Github
   - cd ~/Projects/ccle
   - git clone git@github.com:ucla/moodle.git
   - cd moodle
   - git submodule update --init --recursive
3. Run the setup script from the ccle directory
   - ./setup.sh ./moodle (substituting the correct path if your moodle code is located somewhere else)
     - If you get an error like this: "ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?", then you need to run with sudo (./setup.sh /path/to/moodle/code --with-sudo). DO NOT call sudo directly on the setup script, otherwise Composer will be unhappy.
     - This script may take a long time to complete. If the Docker container output appears to get stuck at "/usr/local/bin/docker-entrypoint.sh: running /docker-entrypoint-initdb.d/schema.sql," don't worry, everything is working as normal. This just means the initial DB is getting set up within the container, which can take some time. Wait until the moodle*docker_db_1 output has moved past this line (ignore any mailhog ouput, it's not useful to us). You'll know the setup has completed when the last line outputted by moodle_docker_db_1 is \_no longer* "/usr/local/bin/docker-entrypoint.sh: running /docker-entrypoint-initdb.d/schema.sql".
4. See if CCLE works as expected
   - When you go to http://localhost:8000, you should be greeted with the typical CCLE login page, complete with UCLA theme. If you don't see this, something might have gone wrong.
   - PHPMyAdmin is accessible at http://localhost:8001. You shouldn't have to log in, but if it does prompt you for a username and password, the username is 'root' and the password is empty.
   - Mail sent from your dev instance is captured by MailHog. You can view these emails at http://localhost:8000/_/mail.
5. You can login using the following accounts: admin/test, instructor/test, student/test
6. Download and install the English (United States)(en_us) language pack. Instructions are here: https://ccle.ucla.edu/mod/qanda/view.php?id=897711&mode=entry&hook=5345

### Use after initial setup

1. After you've done the initial setup described above, you can use Ctrl-C to stop the containers. You should now set the environmental variables for the Docker script. In your terminal, enter 'export MOODLE_DOCKER_WWWROOT=/path/to/moodle/code' (substituting the correct path, obviously) and 'export MOODLE_DOCKER_DB=mysql'. These variables will be reset if you close your terminal, so if you want them to persist, I recommend you add the above two commands to your .bash_profile or .bashrc file.
   - You can read about what .bash_profile and .bashrc are here: http://hacktux.com/bashrc-bash_profile/ In summary, code that you put in these files is run when you start up a bash shell.
2. You can now spin up the containers manually, with '[sudo -E] bin/moodle-docker-compose up -d'. The '-d' causes the containers to run in detached mode, meaning they will run in the background. If you needed the '--with-sudo' option in the setup script, you'll need 'sudo -E' every time you call moodle-docker-compose.
3. Stop the containers with '[sudo -E] bin/moodle-docker-compose stop'. This stops the containers without removing them.
4. If you want to quickly spin up the Docker containers without setting environmental variables, you can run './setup.sh /path/to/moodle/code [--with-sudo] --no-build' to quickly spin up the containers in detached mode without rebuilding the Docker images. However, you will not be able to use any other docker-compose options unless you follow the above steps.

If you need to SSH into the webserver container for any reason, use the following command:

'[sudo] docker exec -it moodledocker_webserver_1 bash'

If you want to use vagrant again, you'll have to run 'cp config_private-dist.php config_private.php' in the moodle directory. To switch back to docker, just run './setup /path/to/moodle/code [--with-sudo] --no-build' to copy the appropriate config file back.

### Running Behat tests and using VNC to view Behat tests

1. Change the linked config.php file from local/ucla/config/shared_dev_moodle-config.php to local/ucla/config/shared_behat_moodle-config.php.
   ```
   cd moodle; rm config.php ; ln -s local/ucla/config/shared_behat_moodle-config.php config.php
   ```

- The difference between the shared_behat_moodle-config.php and the shared_dev_moodle-config.php config files is that Behat has a fewer settings hard coded and has debugging turned off. To develop features with Moodle configured more like Production, use the dev config, but when writing tests run the behat config.

2. Initialize Behat
   ```
   cd ..; bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/init.php
   ```
3. You can now run a Behat test by running:
   ```
   bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/run.php --tags=@ucla
   ```
4. The behat faildump directory is exposed at http://localhost:8000/_/faildumps/.

### Using VNC to view behat tests

If `MOODLE_DOCKER_SELENIUM_VNC_PORT` is defined, selenium will expose a VNC session on the port specified so behat tests can be viewed in progress.

For example, if you set `MOODLE_DOCKER_SELENIUM_VNC_PORT` to 5900..

1. Download a VNC client: https://www.realvnc.com/en/connect/download/viewer/
2. With the containers running, enter 0.0.0.0:5900 as the port in VNC Viewer. You will be prompted for a password. The password is 'secret'.
3. You should be able to see an empty Desktop. When you run any Behat tests a browser will popup and you will see the tests execute.
4. When the tests are running, you should be able to see a Firefox window pop up in the VNC viewer and start to run the Behat test steps.

## Use containers for running phpunit tests

```bash
# Initialize phpunit environment
bin/moodle-docker-compose exec webserver php admin/tool/phpunit/cli/init.php
# [..]

# Run phpunit tests
bin/moodle-docker-compose exec webserver vendor/bin/phpunit auth_manual_testcase auth/manual/tests/manual_test.php
Moodle 3.4dev (Build: 20171006), 33a3ec7c9378e64c6f15c688a3c68a39114aa29d
Php: 7.1.9, pgsql: 9.6.5, OS: Linux 4.9.49-moby x86_64
PHPUnit 5.5.7 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 4.45 seconds, Memory: 38.00MB

OK (2 tests, 7 assertions)
```

Notes:

- If you want to run test with coverage report, use command: `bin/moodle-docker-compose exec webserver phpdbg -qrr vendor/bin/phpunit --coverage-text auth_manual_testcase auth/manual/tests/manual_test.php`

### Troubleshooting

So you had a problem setting up Docker. Don't worry, I had plenty of problems too.

1. First, make sure your environmental variables are set. In the same terminal window that you will run Docker from, enter 'export MOODLE_DOCKER_WWWROOT=/path/to/moodle/code' (substituting the correct path, obviously) and 'export MOODLE_DOCKER_DB=mysql'. You can double-check these variables are set properly by echo-ing them in the shell.
2. Next, try running 'sudo -E bin/moodle-docker-compose down' to stop and remove the containers. Then, run 'sudo -E bin/moodle-docker-compose up --build' to rebuild the docker images and bring the containers up again. If you did not have to run the setup script with sudo, you don't have to use it here, either.
3. If the above two steps did not fix your issue, try the nuclear option. Run './purge.sh [--volumes][--images] [--untagged][--all]' By default, the purge script only removes the containers, but with the additional flags, it will remove the volumes and images (along with untagged images). Running the script with the '--volumes' option will remove your database, and you will have to reinstall it with the setup script. If you do this with all the options ('./purge.sh --all), you will have to run the setup script again and it will install everything from scratch, which will take a long time, so only do this if nothing else has worked.
4. If you get an error related to checking out a submodule try the following:
   - If you are on WiFi, make sure you are not using UCLA_WEB, that connection blocks the SSH port.
   - Try running the update command with --no-recommend-shallow: git submodule update --init --recursive --no-recommend-shallow

## Stop and restart containers

`bin/moodle-docker-compose down` which was used above after using the containers stops and destroys the containers. If you want to use your containers continuously for manual testing or development without starting them up from scratch everytime you use them, you can also just stop without destroying them. With this approach, you can restart your containers sometime later, they will keep their data and won't be destroyed completely until you run `bin/moodle-docker-compose down`.

```bash
# Stop containers
bin/moodle-docker-compose stop

# Restart containers
bin/moodle-docker-compose start
```

## Environment variables

You can change the configuration of the docker images by setting various environment variables before calling `bin/moodle-docker-compose up`.

| Environment Variable                      | Mandatory | Allowed values                         | Default value  | Notes                                                                                                                                                                                                            |
| ----------------------------------------- | --------- | -------------------------------------- | -------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `MOODLE_DOCKER_DB`                        | yes       | pgsql, mariadb, mysql, mssql, oracle   | none           | The database server to run against                                                                                                                                                                               |
| `MOODLE_DOCKER_WWWROOT`                   | yes       | path on your file system               | none           | The path to the Moodle codebase you intend to test                                                                                                                                                               |
| `MOODLE_DOCKER_PHP_VERSION`               | no        | 7.4, 7.3, 7.2, 7.1, 7.0, 5.6           | 7.2            | The php version to use                                                                                                                                                                                           |
| `MOODLE_DOCKER_BROWSER`                   | no        | firefox, chrome                        | firefox        | The browser to run Behat against                                                                                                                                                                                 |
| `MOODLE_DOCKER_PHPUNIT_EXTERNAL_SERVICES` | no        | any value                              | not set        | If set, dependencies for memcached, redis, solr, and openldap are added                                                                                                                                          |
| `MOODLE_DOCKER_WEB_HOST`                  | no        | any valid hostname                     | localhost      | The hostname for web                                                                                                                                                                                             |
| `MOODLE_DOCKER_WEB_PORT`                  | no        | any integer value (or bind_ip:integer) | 127.0.0.1:8000 | The port number for web. If set to 0, no port is used.<br/>If you want to bind to any host IP different from the default 127.0.0.1, you can specify it with the bind_ip:port format (0.0.0.0 means bind to all)  |
| `MOODLE_DOCKER_SELENIUM_VNC_PORT`         | no        | any integer value (or bind_ip:integer) | not set        | If set, the selenium node will expose a vnc session on the port specified. Similar to MOODLE_DOCKER_WEB_PORT, you can optionally define the host IP to bind to. If you just set the port, VNC binds to 127.0.0.1 |

## Advanced usage

As can be seen in [bin/moodle-docker-compose](https://github.com/moodlehq/moodle-docker/blob/master/bin/moodle-docker-compose),
this repo is just a series of docker-compose configurations and light wrapper which make use of companion docker images. Each part
is designed to be reusable and you are encouraged to use the docker[-compose] commands as needed.

## Companion docker images

The following Moodle customised docker images are close companions of this project:

- [moodle-php-apache](https://github.com/moodlehq/moodle-php-apache): Apache/PHP Environment preconfigured for all Moodle environments
- [moodle-db-mssql](https://github.com/moodlehq/moodle-db-mssql): Microsoft SQL Server for Linux configured for Moodle
- [moodle-db-oracle](https://github.com/moodlehq/moodle-db-oracle): Oracle XE configured for Moodle

## Contributions

Are extremely welcome!
