<?php 
	require_once("config/environment.php");
	environment::set_vars();
	$db_info = environment::$db_connection;
	$CONFIG['MONGODHOST'] = $db_info['hostname'];
	$CONFIG['USERNAME'] = $db_info['user'];
	$CONFIG['PASSWORD'] = $db_info['pass'];
	$CONFIG['MONGODBNAME'] = 'chicos_db';
	$CONFIG['PROFANITY'] = environment::$profanity_words;
	$CONFIG['WEBHOMEDIR'] = environment::$web_home_dir;
	$CONFIG['MOBILEHOMEDIR'] = environment::$mobile_home_dir;
	
	$CONFIG['INITNOROWS'] = 11;
?>