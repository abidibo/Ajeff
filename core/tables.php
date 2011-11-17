<?php
/**
 * Ajeff table definition file
 *
 * This file contains the definition of all jeff base tables as constants.
 * Additional tables, tied to specific projects, may be defined in the file<br />
 * <pre>ROOT/project_tables</pre><br />
 * since if it exists is included here.
 *   
 * @package proxy
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

define('TBL_SYS_SETTINGS', 'sys_site_settings');
define('TBL_SYS_DATETIME_SETTINGS', 'sys_datetime_settings');
define('TBL_SYS_GROUPS', 'sys_groups');
define('TBL_SYS_PRIVILEGES', 'sys_privileges');
define('TBL_USERS', 'users');
define('TBL_THEMES', 'themes');
define('TBL_LNG', 'languages');

if(is_readable(ABS_ROOT.DS.'project_tables.php')) include(ABS_ROOT.DS.'project_tables.php');

?>
