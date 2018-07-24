@echo off

rem Make sure that the argument is a directory.
if exist %1 (
	echo Found moodle directory '%1'.
) else (
	echo Error: The first argument must be the path to your moodle code. '%1' is not a directory.
	goto :eof
)

setlocal

rem Set up environment variables.
set MOODLE_DOCKER_WWWROOT=%1
set MOODLE_DOCKER_DB=mariadb
set ONLINE_SQL_FILE=https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql
set LOCAL_SQL_FILE=assets/mysql/new_moodle_instance.sql
set DOCKER_DIRECTORY=%CD%
set EMAIL_DIRECTORY=assets/ccle_email_templates

rem Get SQL file.
if exist %LOCAL_SQL_FILE% (
	echo Initial SQL file '%LOCAL_SQL_FILE%' found.
) else (
	echo Initial SQL file '%LOCAL_SQL_FILE%' not found. Downloading SQL file to create new moodle instance DB.
	curl -L %ONLINE_SQL_FILE% -o %LOCAL_SQL_FILE%
)

rem Clone the e-mail directory.
if exist %EMAIL_DIRECTORY% (
	echo Email directory '%EMAIL_DIRECTORY%' found.
	cd %EMAIL_DIRECTORY%
	git checkout
) else (
	echo Email directory '%EMAIL_DIRECTORY%' not found. Cloning CCLE email templates.
	git clone git@github.com:ucla/ccle_email_templates.git ./assets/ccle_email_templates
)

rem Smart way to keep certain files local and others global. see http://www.robvanderwoude.com/local.php
endlocal & set MOODLE_DOCKER_WWWROOT=%MOODLE_DOCKER_WWWROOT% & set MOODLE_DOCKER_DB=%MOODLE_DOCKER_DB%
