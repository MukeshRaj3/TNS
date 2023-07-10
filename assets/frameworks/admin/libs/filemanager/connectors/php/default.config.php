<?php
/**
 *	Filemanager PHP connector
 *  This file should at least declare auth() function 
 *  and instantiate the Filemanager as '$fm'
 *  
 *  IMPORTANT : by default Read and Write access is granted to everyone
 *  Copy/paste this file to 'user.config.php' file to implement your own auth() function
 *  to grant access to wanted users only
 *
 *	filemanager.php
 *	use for ckeditor filemanager
 *
 *	@license	MIT License
 *  @author		Simon Georget <simon (at) linea21 (dot) com>
 *	@copyright	Authors
 */

//$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
//define('HOST', 'localhost');
//define('USERNAME', 'root');
//if ($host == 'localhost' || $host = '192.168.1.123') {
//    define('PASSWORD', '');
//} else {
//    define('PASSWORD', 'God1zAz1');
//}
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'God1zAz1');
define('DATABASE', 'take_your_seat');


$link = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

//Output any connection error
if ($link->connect_error) {
    die('Error : (' . $link->connect_errno . ') ' . $link->connect_error);
}

ob_start();
include('../../../../../../../index.php');

ob_end_clean();
$CI =& get_instance();
$CI->load->driver('session');

if(@$_SESSION['role_id'] == 1){
	$codeigniterAuth = true;
} else {
	$codeigniterAuth = false;
}

/**
 *	Check if user is authorized
 *	
 *
 *	@return boolean true if access granted, false if no access
 */
function auth() {
  // You can insert your own code over here to check if the user is authorized.
  // If you use a session variable, you've got to start the session first (session_start())
  return $GLOBALS['codeigniterAuth'];
}


// @todo Work on plugins registration
// if (isset($config['plugin']) && !empty($config['plugin'])) {
// 	$pluginPath = 'plugins' . DIRECTORY_SEPARATOR . $config['plugin'] . DIRECTORY_SEPARATOR;
// 	require_once($pluginPath . 'filemanager.' . $config['plugin'] . '.config.php');
// 	require_once($pluginPath . 'filemanager.' . $config['plugin'] . '.class.php');
// 	$className = 'Filemanager'.strtoupper($config['plugin']);
// 	$fm = new $className($config);
// } else {
// 	$fm = new Filemanager($config);
// }


// we instantiate the Filemanager
$fm = new Filemanager();

?>