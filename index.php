<?php
/**
 * Application entry point, all starts from here, babe
 * 
 * @package Ajeff
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * The absolute path to appication root. 
 */
define('ABS_ROOT', realpath(dirname(__FILE__)));

/**
 * The os directory separator 
 */
define('DS', DIRECTORY_SEPARATOR);

include(ABS_ROOT.DS.'paths.php');
include(ABS_ROOT.DS.'configuration.php');
include(ABS_CORE.DS.'proxy.class.php');
include(ABS_CORE.DS.'core.class.php');

/**
 * Set environment variables, re-write SERVER and REQUEST arrays
 *
 * Do the work generally done by .htaccess file.
 */
$proxy = new proxy();
$env = $proxy->setEnvironment();

/**
 * The relative path to the site root (main or admin)
 */
define('BASE_PATH', $env['root']);


/**
 * Come on babe, let's start creating the final document 
 */
$core = new core();
$core->renderApp($env['site']);

?>
