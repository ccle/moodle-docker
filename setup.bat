@echo off

REM Make sure that the argument is a directory.
IF exist %1 (
	echo Found moodle directory '%1'.
) ELSE (
	echo Error: The first argument must be the path to your moodle code. '%1' is not a directory.
	goto :eof
)

REM Set up environment variables.
SET MOODLE_DOCKER_WWWROOT=%1
SET MOODLE_DOCKER_DB=mariadb
SET ONLINE_SQL_FILE=https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql
SET LOCAL_SQL_FILE=assets/mysql/new_moodle_instance.sql
SET DOCKER_DIRECTORY=%CD%
SET EMAIL_DIRECTORY=assets/ccle_email_templates

REM Get SQL file.
if exist %LOCAL_SQL_FILE% (
	echo Initial SQL file not found. Downloading SQL file to create new moodle instance DB.
	curl -L %ONLINE_SQL_FILE% -o %LOCAL_SQL_FILE%
) ELSE (
	echo Initial SQL file found.
)

echo "more"
