<?php
/**
 * Ajeff main inclusion file
 *
 * Here are included all main jeff classes.
 * Contains the definition of an autoload function, that automatically
 * loads the model type classes of modules, which follow the following convention:<br />
 * - filename: MODULE_NAME.class.php
 * - classname: MODULE_NAME
 *
 * @package proxy
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

include(ABS_CORE.DS.'registry.class.php');
include(ABS_PHPLIB.DS.'functions.php');
include(ABS_CORE.DS.'dtime.class.php');
include(ABS_CORE.DS.'authentication.class.php');
include(ABS_CORE.DS.'cache.class.php');
include(ABS_CORE.DS.'access.class.php');
include(ABS_PHPLIB.DS.'varFilters.php');
include(ABS_CORE.DS.'error.class.php');
include(ABS_MVC.DS.'controller.class.php');
include(ABS_CORE.DS.'router.class.php');
include(ABS_CORE.DS.'document.class.php');
include(ABS_CORE.DS.'adminTable.class.php');
include(ABS_CORE.DS.'export.class.php');
include(ABS_CORE.DS.'form.class.php');
include(ABS_CORE.DS.'image.class.php');
include(ABS_CORE.DS.'template.class.php');
include(ABS_CORE.DS.'template.factory.php');
include(ABS_CORE.DS.'pagination.class.php');
include(ABS_THEME.DS.'theme.class.php');
include(ABS_DB.DS.'db.factory.php');

/**
 * __autoload 
 * 
 * @param string $class 
 * @access public
 * @return void
 */
function __autoload($class)
{

   	if(is_file(ABS_MDL.DS.$class.DS.$class.'.php'))
   		include_once(ABS_MDL.DS.$class.DS.$class.'.php');
   		
	if (!class_exists($class, false))
		Error::syserrorMessage('include.php', 'autoload', sprintf(__("CantChargeModuleError"), $class, ABS_MDL.DS.$class.DS.$class.'.php'), __LINE__);

}

?>
