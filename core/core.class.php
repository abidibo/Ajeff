<?php
/**
 * Ajeff core
 *
 * This file contains the Ajeff core class, which performs the document printing.
 *   
 * @package Ajeff
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * Ajeff core class 
 * 
 * It's the class that actually outputs the document. Can print the whole document
 * charging the right theme and template, but also a single class method output,
 * feature useful to perform ajax requests.
 * 
 * @package url-management 
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license MIT {@link http://www.opensource.org/licenses/mit-license.php}
 */

class core {

	private $_registry, $_base_path, $_site;

	/**
	 * __construct 
	 * 
	 * start session
	 * include other important files  
	 * instantiate the registry object and set some properties
	 * check and set session timeout
	 * charge extra plugins
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {

		session_name(SESSIONNAME);
		session_start();
		require_once(ABS_CORE.DS.'tables.php');
		require_once(ABS_CORE.DS.'include.php');

		$this->_base_path = BASE_PATH;
		
		// initializing registry variable
		$this->_registry = new registry();
		$this->_registry->db = db::getInstance();
		$this->_registry->admin_privilege = 1;
		$this->_registry->admin_view_privilege = 2;
		$this->_registry->public_view_privilege = 3;
		$this->_registry->private_view_privilege = 4;
		$this->_registry->theme = $this->getTheme();
		$_SESSION['theme'] = $this->_registry->theme; // translations
		$this->_registry->lng = language::setLanguage($this->_registry);
		$this->_registry->site_settings = new siteSettings($this->_registry);
		$this->_registry->dtime = new dtime($this->_registry);
		$this->_registry->router = new router($this->_registry, $this->_base_path);
		$this->_registry->isHome = preg_match("#^module=index&method=index(&.*)?$#", $_SERVER['QUERY_STRING']) ? true : false;
		$this->_registry->css = array();
		$this->_registry->js = array();

		// set session timeout
		if($this->_registry->site_settings->session_timeout) {
			if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $this->_registry->site_settings->session_timeout)) {
				// last request was more than timeout seconds ago
				session_regenerate_id(true);
				session_destroy();
				unset($_SESSION);
				session_start();
			}
			$_SESSION['last_activity'] = time(); // update last activity time stamp
		}

		// extra plugins
		$plugins_objs = array();
		if(is_readable(ABS_ROOT.DS.'plugins.php')) {
			require_once(ABS_ROOT.DS.'plugins.php');
			foreach($plugins as $k=>$v) { 
				if(is_readable(ABS_PLUGINS.DS.$k.".php")) {
					require_once(ABS_PLUGINS.DS.$k.".php");
					$plugins_objs[$k] = new $k($this->_registry, $v);
				}
				else 
					exit(error::syserrorMessage(get_class($this), '__construct', sprintf(__("cantFindPluginSource"), $k), __LINE__));
			}
		}
		$this->_registry->plugins = $plugins_objs;

	}

	/**
	 * renderApp 
	 * 
	 * check for authentication actions
	 * create the document and flush it 
	 * 
	 * @param string $site    available values: 'admin' | 'main'
	 *                        indicate the user surfing area (front-end or administrative area) 
	 * @access public
	 * @return void
	 */
	public function renderApp($site) {
		
		ob_start();
		
		// some other registry properties
		$this->_registry->site = $site;

		/*
		 * check login/logout
		 */
		authentication::check($this->_registry);

		/*
		 * create document
		 */
		$doc = new document($this->_registry);
		$buffer = $doc->render();

		ob_end_flush();

	}

	/**
	 * methodPointer 
	 * 
	 * check authentication actions
	 * print a specific class method outputs called by url 
	 * 
	 * @access public
	 * @return void
	 */
	public function methodPointer() {

		ob_start();

		/*
		 * check login/logout
		 */
		authentication::check($this->_registry);

		echo $this->_registry->router->loader(null);
		ob_end_flush();

		exit(); 
	}

	/**
	 * getTheme 
	 * 
	 * charge the used theme 
	 * 
	 * @access public
	 * @return theme | void
	 */
	public function getTheme() {

		$rows = $this->_registry->db->autoSelect(array("name"), TBL_THEMES, "active='1'", '');
		$theme_name = $rows[0]['name'];

		if(is_readable(ABS_THEMES.DS.$theme_name.DS.$theme_name.'.php'))
			require_once(ABS_THEMES.DS.$theme_name.DS.$theme_name.'.php');
		else 
			Error::syserrorMessage('core', 'getTheme', sprintf(__("CantLoadThemeError"), $theme_name, __LINE__));

		$theme_class = $theme_name.'Theme';

		if(class_exists($theme_class))
			return new $theme_class($this->_registry);
		else 
			Error::syserrorMessage('coew', 'getTheme', sprintf(__("CantLoadThemeError"), $theme_name, __LINE__));

	}


}

?>
