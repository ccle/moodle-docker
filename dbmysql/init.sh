#!/bin/sh

set -e
set -x

#/usr/sbin/mysqld --user=root

/etc/init.d/mysql start

# /usr/sbin/mysqld &
# mysql_pid=$!

# until mysqladmin ping >/dev/null 2>&1; do
#   echo -n "."; sleep 0.2
# done

if [ "$(ls -A /var/lib/mysql)" ]
then
	echo "Initializing moodle db for first time"
	mysql --user=root --execute="CREATE DATABASE moodle DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
	# set env variable for password
	mysql --user=root --execute="GRANT ALL PRIVILEGES ON moodle.* TO 'moodle'@'localhost' IDENTIFIED BY 'm@0dl3ing'; FLUSH PRIVILEGES;"
	cd /tmp && apt-get update && apt-get -y install wget
	wget https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql
	mysql -u root -D moodle < /tmp/new_moodle_instance.sql
fi

# mysqladmin shutdown
# wait $mysql_pid