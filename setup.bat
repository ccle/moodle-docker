rem @echo off

rem Make sure that the argument is a directory.
if exist "%1" (
	echo Found moodle directory '%1'.
) else (
	echo Error: The first argument must be the path to your moodle code. '%1' is not a directory.
	goto :eof
)

setlocal

rem Set up environment variables.
set MOODLE_DOCKER_WWWROOT=%1
set DOCKER_DIRECTORY=%CD%

rem Work around for relative paths in command argument.
cd "%MOODLE_DOCKER_WWWROOT%"
set MOODLE_DOCKER_WWWROOT=%CD%
cd "%DOCKER_DIRECTORY%"

set MOODLE_DOCKER_DB=mariadb
set ONLINE_SQL_FILE=https://test.ccle.ucla.edu/vagrant/new_moodle_instance.sql
set LOCAL_SQL_FILE=assets\mysql\new_moodle_instance.sql
set EMAIL_DIRECTORY=assets\ccle_email_templates
set CONFIG_FILE=%MOODLE_DOCKER_WWWROOT%\config.php
set LOCAL_CONFIG_FILE=local\ucla\config\shared_dev_moodle-config.php
set COMPOSER_FILE=composer.phar

rem Get SQL file.
if exist "%LOCAL_SQL_FILE%" (
	echo Initial SQL file '%LOCAL_SQL_FILE%' found.
) else (
	echo Initial SQL file '%LOCAL_SQL_FILE%' not found. Downloading SQL file to create new moodle instance DB.
	curl -L %ONLINE_SQL_FILE% -o %LOCAL_SQL_FILE%
)

rem Clone the e-mail directory.
if exist "%EMAIL_DIRECTORY%" (
	echo Email directory '%EMAIL_DIRECTORY%' found.
	cd "%EMAIL_DIRECTORY%"
	git checkout master && git pull origin master >nul
) else (
	echo Email directory '%EMAIL_DIRECTORY%' not found. Cloning CCLE email templates.
	git clone git@github.com:ucla/ccle_email_templates.git .\assets\ccle_email_templates >nul
)

cd "%MOODLE_DOCKER_WWWROOT%"

rem Set up config files. Check if symbolic link exists.
dir "%CONFIG_FILE%" | find "<SYMLINK>" && (
	echo Config symbolic link '%CONFIG_FILE%' found.
)
if ERRORLEVEL 1 (
	echo Config symbolic link '%CONFIG_FILE%' not found. Making symbolic link.
	mklink "%CONFIG_FILE%" "%LOCAL_CONFIG_FILE%"
)
echo Copying custom moodle-docker config to config_private.
copy "%DOCKER_DIRECTORY%\moodle-docker_config_private-dist.php" config_private.php

rem Update git submodules.
git submodule update --init --recursive

rem Update compose if needed.
if exist "%COMPOSER_FILE%" (
	echo Composer file found.
) else (
	echo Composer file not found.
	curl -sS http://getcomposer.org/installer | php
	php "%COMPOSER_FILE%" install
	php "%COMPOSER_FILE%" install -d theme\uclashared
)

cd "%DOCKER_DIRECTORY%"

set BUILD_FLAG=--build
if "%2"=="--no-build" (
	set BUILD_FLAG=-d
) else (
	if "%3"=="--no-build" (
		set BUILD_FLAG=-d
	)
)

if "%2"=="--as-admin" (
	set AS_ADMIN=1
) else (
	if "%3"=="--as-admin" (
		set AS_ADMIN=1
	) else (
		set AS_ADMIN=0
	)
)

if %AS_ADMIN%==1 (
	echo Spinning up the containers as administrator for the first time with bin\moodle-docker-compose up %BUILD_FLAG%
	runas /user:Administrator "bin\moodle-docker-compose up %BUILD_FLAG%"
) else (
	echo Spinning up the containers for the first time with bin\moodle-docker-compose up %BUILD_FLAG%
	bin\moodle-docker-compose up %BUILD_FLAG%

	if ERRORLEVEL 1 (
		echo It seems 'docker-compose up' has failed. Try running this script with the '--as-admin' flag
	)
)

rem Cool way to keep certain files local and others global. see http://www.robvanderwoude.com/local.php
endlocal & set MOODLE_DOCKER_WWWROOT="%MOODLE_DOCKER_WWWROOT%" & set MOODLE_DOCKER_DB="%MOODLE_DOCKER_DB%"
