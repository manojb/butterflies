<?php 
	/**
	* We are developing two versions : Web and Mobile 
	* For this we are creating a Rest API to commonly access the business logic
	* Set the API url for the Web version and Mobile version 
	*
	**/

	ini_set('display_errors',1);
	
	define("DS", DIRECTORY_SEPARATOR);
	
	$current_dir = dirname(__FILE__);
	$root_dir = str_replace("/",DS,$_SERVER['DOCUMENT_ROOT']);
	$root_dir_to_url = str_replace($root_dir,'',$current_dir);
	$root_dir_to_url = str_replace(DS,'/',$root_dir_to_url);
	
	// Set home url 
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	#$home_url = $protocol.$_SERVER['HTTP_HOST'].'/'.trim($root_dir_to_url,'/');
	$get_home_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$get_home_url = str_replace(array('.php/?','.html/?'),array('.php?','.html?'),$get_home_url);
	$get_home_url_arr = explode("/",$get_home_url);
	unset($get_home_url_arr[count($get_home_url_arr) -1]);
	$home_url = implode("/",$get_home_url_arr);

	
	//Get and set from Fullwebsite environmnet file
	require_once("config/environment.php");
	environment::set_vars();
	
	if(isset(environment::$web_home_url) && (trim(environment::$web_home_url) != '')) {
		DEFINE('HOMEURL',trim(environment::$web_home_url,"/"));
	} else {
		DEFINE('HOMEURL',$home_url);
	}
	
	DEFINE('HOMEDIR',$current_dir);
	DEFINE('APIURL',environment::$api_url);
	DEFINE('FBTABURL',environment::$tab_url);
	DEFINE('FBAPPID',environment::$fbappid);
	DEFINE('FBAPIKEY',environment::$fbapikey);
	DEFINE('FBAPISECRET',environment::$fbapisecret);
	

	$config_json = file_get_contents(APIURL.'?action=get_config&u=cadmin&p=w0rdp455');
	$config_data = json_decode($config_json);
	
	if(isset($config_data->error)) {
		die($config_data->error);
	}
				
	//Get and Set from API environment file
	/* 
	$root = "http://".$_SERVER['HTTP_HOST'];
	$root .= (isset($config_data->WEBHOMEDIR) && $config_data->WEBHOMEDIR != '') ? "/".trim($config_data->WEBHOMEDIR,"/") : '';
	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	$root_dir .= (isset($config_data->WEBHOMEDIR) && $config_data->WEBHOMEDIR != '') ? "/".trim($config_data->WEBHOMEDIR,"/") : '';
	DEFINE('HOMEURL',$root);
	DEFINE('HOMEDIR',$root_dir);
	DEFINE('MONGODHOST', $config_data->MONGODHOST);
	DEFINE('USERNAME', $config_data->USERNAME);
	DEFINE('PASSWORD', $config_data->PASSWORD);
	DEFINE('MONGODBNAME', $config_data->MONGODBNAME);
	*/
	
	$profanity_words = $config_data->PROFANITY;
	
	#echo "<br>HOMEURL".HOMEURL."<br>HOMEDIR: ".HOMEDIR."<br>APIURL: ".APIURL."<br>FBTABURL: ".FBTABURL."<br>FBAPPID: ".FBAPPID."<br>FBAPIKEY: ".FBAPIKEY."<br>FBAPISECRET: ".FBAPISECRET;	exit;
?>