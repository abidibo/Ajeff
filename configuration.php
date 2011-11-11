<?php

/**
 * main configuration file, set here your preferences and settings, babe
 *
 * set session name, application language, dbms parameters, password encryption and debug mode
 * 
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license MIT {@link http://www.opensource.org/licenses/mit-license.php}
 */

define('SESSIONNAME', 'JEFF_SID');

define('APP_LANGUAGE', 'en_EN');

define('DBMS', 'mysql');
define('DB_HOST', 'localhost');
define('DB_DBNAME', 'db_jeff');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_SCHEMA', '');
define('DB_CHARSET', 'utf8'); 

define('PWD_HASH', 'md5'); // md5 | sha1 | "empty"(-> no criptation)

// want to show syserror messages with class, method and line informations?
define('DEBUG', true);

?>
