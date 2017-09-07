<?php

// This should be the config_private if you're using moodle-docker for CCLE

$CFG->dbtype    = getenv('MOODLE_DOCKER_DBTYPE');
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'db';


$CFG->dbname    = getenv('MOODLE_DOCKER_DBNAME');
$CFG->dbuser    = getenv('MOODLE_DOCKER_DBUSER');
$CFG->dbpass    = getenv('MOODLE_DOCKER_DBPASS');

// Registrar
$CFG->registrar_dbtype = 'odbc_mssql';
$CFG->registrar_dbhost = '';
$CFG->registrar_dbuser = '';
$CFG->registrar_dbpass = '';
$CFG->registrar_dbname = '';

$CFG->prefix    = 'mdl_';
$CFG->dboptions = ['dbcollation' => getenv('MOODLE_DOCKER_DBCOLLATION')];


$CFG->wwwroot   = 'http://localhost';
$port = getenv('MOODLE_DOCKER_WEB_PORT');
if (!empty($port)) {
    $CFG->wwwroot .= ":{$port}";
}
$CFG->dataroot  = '/var/www/moodledata';
$CFG->admin     = 'admin';
$CFG->directorypermissions = 0777;
$CFG->smtphosts = 'mailhog:1025';
