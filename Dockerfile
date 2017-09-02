FROM mysql:5

MAINTAINER amit.mondal2016@gmail.com

ADD files/new_moodle_instance.sql files/copy_db /docker-entrypoint-initdb.d/