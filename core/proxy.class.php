<?php
/**
 * Ajeff proxy
 *
 * Ajeff supports permalinks, so that internal urls are something like<br />
 * <code>http://www.example.com/class_name/class_method/param/value</code><br/>
 * Such url must be parsed in order to create the right $_REQUEST and $_SERVER
 * arrays used by the other classes.
 * 
 * @package proxy
 * @version 1.0b
 * @copyright 2011 Otto srl
 * @author abidibo <abidibo@gmail.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */

/**
 * Parse the permalink url and set all environment variables
 *
 * Set $_GET and $_SERVER variables in order to call the right modules and use 
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
	 * Set environment variables after parsing the QUERY_STRING 
	 * 
	 * @access public
	 * @return void
	 */
	public function setEnvironment() {
	
		$query_string = $_SERVER['QUERY_STRING'];		
		$request_uri = $_SERVER['REQUEST_URI'];		

		$url_chunks = explode("/", $query_string);
		$length = count($url_chunks);
		$length = $url_chunks[$length-1] ? $length : $length-1;

		if($length == 1) {
			if($url_chunks[0] == 'login') {
				$pquery_string = "login";
				$_GET = array("login"=>null);
				$script = "index.php";
			}
			elseif($url_chunks[0] == 'logout') {
				$pquery_string = "logout";
				$_GET = array("logout"=>null);
				$script = "index.php";
			}
			elseif($url_chunks[0] == 'noaccess') {
				$pquery_string = "";
				$_GET = array();
				$script = "noaccess.php";
			}
			else {
				$pquery_string = "";
				$_GET = array();
			}
			$_SERVER['QUERY_STRING'] = $pquery_string;
			$_SERVER['REQUEST_URI'] = ROOT."/"
						. (($script || $pquery_string) ? $script."?".$pquery_string : "");
		}
		elseif($length == 2) {
			$_SERVER['QUERY_STRING'] = "module=".$url_chunks[0]."&method=".$url_chunks[1];
			$_SERVER['REQUEST_URI'] = ROOT."/index.php?".$_SERVER['QUERY_STRING'];
			$_GET = array(
				"module"=>$url_chunks[0],
				"method"=>$url_chunks[1]	
			);
		}
		elseif($length == 3) {
			$_SERVER['QUERY_STRING'] = "module=".$url_chunks[0]."&method=".$url_chunks[1]."&id=".$url_chunks[2];
			$_SERVER['REQUEST_URI'] = ROOT."/index.php?".$_SERVER['QUERY_STRING'];
			$_GET = array(
				"module"=>$url_chunks[0],
				"method"=>$url_chunks[1],	
				"id"=>$url_chunks[2]	
			);
		}
		elseif($length > 3) {
			$pquery_string = "module=".$url_chunks[0]."&method=".$url_chunks[1];
			for($i=2; $i<$length; $i+2) {
				$parname = $url_chunks[$i];
				$parvalue = $url_chunks[$i+1];
				$pquery_string .= "&".$parname."=".$parvalue;
				$_GET[$parname] = $parvalue;
			}
			$_SERVER['QUERY_STRING'] = $pquery_string;
			$_SERVER['REQUEST_URI'] = ROOT."/index.php?".$_SERVER['QUERY_STRING'];
		}

	}

}

?>
