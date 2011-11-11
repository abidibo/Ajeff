<?php
/**
 * application entry point, all starts from here, babe
 * 
 * @package wrappers
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * the absolute path to appication root  
 */
define('ABS_ROOT', realpath(dirname(__FILE__)));

/**
 * the os directory separator 
 */
define('DS', DIRECTORY_SEPARATOR);

include(ABS_ROOT.DS.'paths.php');
include(ABS_ROOT.DS.'configuration.php');
include(ABS_CORE.DS.'proxy.class.php');
include(ABS_CORE.DS.'core.class.php');

/**
 * the relative path to application root 
 */
define('BASE_PATH', ROOT);

/**
 * set environment variables, re-write SERVER and REQUEST arrays
 *
 * do the work generally done by .htaccess
 */
$proxy = new proxy();
$proxy->setEnvironment();

/**
 * come on babe, let's start creating the final document 
 */
$core = new core();
$core->renderApp();

?>
