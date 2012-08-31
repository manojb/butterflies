<?php 
	require_once("config/environment.php");
	environment::set_vars();
	$db_info = environment::$db_connection;
	$CONFIG['MONGODHOST'] = $db_info['hostname'];
	$CONFIG['USERNAME'] = isset($db_info['user']) ? $db_info['user'] : '';
	$CONFIG['PASSWORD'] = isset($db_info['pass']) ? $db_info['pass'] : '';
	$CONFIG['MONGODBNAME'] = 'chicos_db';
	$CONFIG['PROFANITY'] = environment::$profanity_words;
	
	$CONFIG['INITNOROWS'] = 11;
?>