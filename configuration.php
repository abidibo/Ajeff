<?php
/**
 * main configuration file, set here your preferences and settings, babe
 *
 * set session name, application language, dbms parameters, password encryption and debug mode
 * 
 * @package wrappers
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

define('SESSIONNAME', 'JEFF_SID');

define('APP_LANGUAGE', 'en_EN');

/**
 * Database Management System
 *
 * Here you may set a different dbms. Make sure to have written
 * and included its proper connector
 * @see interface.db 
 */
define('DBMS', 'mysql');
define('DB_HOST', 'localhost');
define('DB_DBNAME', 'db_jeff');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_SCHEMA', '');
define('DB_CHARSET', 'utf8'); 

/**
 * password encryption
 *
 * available values: 'md5' | 'sha1' | ''<br />
 * if empty no crypt method is set
 */
define('PWD_HASH', 'md5');

/**
 * debug mode.

 * If true system errors are displayed with class, method and line informations.<br /> 
 * If false a custom message is shown (must be passed to the error class).
 */
define('DEBUG', true);

?>
