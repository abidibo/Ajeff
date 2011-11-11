<?php
/**
 * application entry point, all starts from here, babe
 * 
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license MIT {@link http://www.opensource.org/licenses/mit-license.php}
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
include(ABS_CORE.DS.'core.php');

/**
 * the relative path to application root 
 */
define('BASE_PATH', ROOT);

/**
 * come on babe, let's start creating the final document 
 */
$core = new core();
$core->renderApp();

?>
