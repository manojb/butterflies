<?php
require_once("current_environment.php");

/**
 *this is the class where we setup all of our environment specific variables
 *
 */
class environment
{
    /*setup the variables here*/
    public static $tab_url;
    public static $fbappid;
    public static $fbapikey;
    public static $fbapisecret;
    public static $api_url;
    public static $web_home_url;
    
    /**
     * this is a static function to setup your environment variables
     * user this method to initialize the values based on environment
     */
    public static function set_vars()
    {
        
        switch(CURR_ENV::current_environment)
        {
            /**
            *DEV DEV DEV
            *this case is for the dev environment
            **/
            case(-1):
				/*API Url */
				self::$api_url = 'http://localhost/projects/ChicosFas/Source/Core/api';
				
				/*tab url for facebook*/
                self::$tab_url = "https://www.facebook.com/enter-test";
                
                /*facebook app setup stuff here*/
                self::$fbappid = "482153885130141";
                self::$fbapikey = "482153885130141";
                self::$fbapisecret = "3b4d34d790b887924059f6cdd8e6e1bb";
				
				/*
				*
				* Set HOME URL, if left blank it will automatically calculate from the current page
				* But it is good practice to set the home url here. If any URL rewrite rule is written in '.htaccess' file, it may reflect the calculation of home url from the current page
				* Set full home page url eg : http://localhost/projects/ChicosFas/Source/FullWebsite
                self::$web_home_url = "http://localhost/projects/ChicosFas/Source/FullWebsite/";
				*/
                break;
            
            /**
            *STAGING STAGING STAGING
            *this case is for the STAGING environment
            **/
            case(0):
				/*API Url */
				self::$api_url = 'http://209.239.120.86/dev/chicos_fas_lbbc/Core/api';
				
				/*tab url for facebook*/
                self::$tab_url = "https://www.facebook.com/enter-test";
                
                /*facebook app setup stuff here*/
                self::$fbappid = "354922457924244";
                self::$fbapikey = "354922457924244";
                self::$fbapisecret = "7fcff15387656efaab51c619bd1bfcd7";
				
				/*
				*
				* Set HOME URL, if left blank it will automatically calculate from the current page
				* But it is good practice to set the home url here. If any URL rewrite rule is written in '.htaccess' file, it may reflect the calculation of home url from the current page
				* Set full home page url eg : http://localhost/projects/ChicosFas/Source/FullWebsite
                #self::$web_home_url = "http://209.239.120.86/dev/chicos_fas_lbbc/FullWebsite/";
                self::$web_home_url = "";
				*/
				break;
            
            /**
            *PRODUCTION PRODUCTION PRODUCTION
            *this case is for the production environment
            **/
            case(1):
                /*setup some db vars for dev here*/
                self::$db_connection = array("hostname"=>"prodhost"
                                              ,"user"=>"produser"
                                              ,"pass"=>"12354"                                              
                                              );

                /*tab url for facebook*/
                self::$tab_url = "https://www.facebook.com/bio";
                
                /*facebook app setup stuff here*/
                self::$fbappid = "1235648798456";
                self::$fbapikey = "asdhkasdg8asdjgahsdkjgasdg";
                self::$fbapisecret = "asddfewegw115454";
                break;
        }
    }
}

?>