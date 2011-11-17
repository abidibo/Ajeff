<?php
/**
 * Ajeff proxy
 *
 * Ajeff supports permalinks, so that internal urls are something like<br />
 * <pre>http://www.example.com/class_name/class_method/param/value</pre><br/>
 * Such url must be parsed in order to create the right $_GET array.
 * 
 * @package proxy
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * Parse the permalink url and set all predefined variables
 *
 * Set $_GET and if needed $_SERVER variables in order to call the right modules and use 
 * url parameters inside methods.
 *
 * @package url-management 
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
class proxy {

	/**
	 * Set environment variables after parsing the request uri 
	 * 
	 * @param bool $set_server_vars rewrite $_SERVER query string and request uri
	 * @access public
	 * @return array environment variables
	 */
	public function setEnvironment($set_server_vars = false) {
	
		// default environment, public site
		$env = array(
			'root'=>ROOT,
			'site'=>'main'	
		);
		$script = 'index.php';
		$get = array();

		$request_uri = $_SERVER['REQUEST_URI'];		

		// separate real query_string from permalink part
		$ru_parts = explode("?", $request_uri);
		$to_parse = substr(preg_replace("#".preg_quote(ROOT)."#", '', $ru_parts[0]), 1);

		// parse permalink part
		$url_chunks = explode("/", $to_parse);

		// check administration
		if(isset($url_chunks[0]) && $url_chunks[0] == 'admin') {
			$env['root'] = ROOT_ADMIN;
			$env['site'] = array_shift($url_chunks);
		}

		// url ending with /
		$length = count($url_chunks);
		$length = $url_chunks[$length-1] ? $length : $length-1;

		if($length == 0) {
			$pquery_string = "module=index&method=index";
		}
		elseif($length == 1) {
			if($url_chunks[0] == 'login') {
				$pquery_string = 'login=';
			}
			elseif($url_chunks[0] == 'logout') {
				$pquery_string = "logout=";
			}
			elseif($url_chunks[0] == 'noaccess') {
				$pquery_string = "";
				$script = "noaccess.php";
			}
			else {
				$pquery_string = "module=index&method=index";
			}	
		}
		elseif($length == 3) {
			$pquery_string = "module=".$url_chunks[0]."&method=".$url_chunks[1]."&id=".$url_chunks[2];
		}
		else {
			$pquery_string = "module=".$url_chunks[0]."&method=".$url_chunks[1];
			for($i=2; $i<$length; $i += 2) {
				$parname = $url_chunks[$i];
				$parvalue = $url_chunks[$i+1];
				$pquery_string .= "&".$parname."=".$parvalue;
			}
		}

		$query_string = (isset($ru_parts[1]) && $ru_parts[1]) 
			? ($pquery_string ? $pquery_string."&".$ru_parts[1] : $ru_parts[1]) 
			: $pquery_string;


		// set server variables
		if($set_server_vars) {
			$_SERVER['QUERY_STRING'] = $query_string;
			$_SERVER['REQUEST_URI'] = $env['root']."/".$query_string;
		}

		// and now go with get
		$_GET = array();
		foreach(explode("&", $query_string) as $qsp) {
			if(strpos($qsp, '=')) {
				$_GET[substr($qsp, 0, strpos($qsp, '='))] = substr($qsp, strpos($qsp, '=')+1); 
			}
			else {
				$_GET[$qsp] = '';	
			}
		}

		var_dump($_GET);
		return $env;

	}

}

?>
