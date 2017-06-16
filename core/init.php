<?php
session_start();
error_reporting();
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'textile'  
		),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry'=> 604800
		 ),	
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
		)

 );

spl_autoload_register(function($class){
	if(file_exists('../classes/' .$class.'.php')){
	require_once '../classes/' .$class.'.php';}
	else{
		return false;
	}
});
require_once '../functions/sanitize.php';
?>