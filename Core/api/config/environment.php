<?php
/*include the current environment state file*/
require_once("current_environment.php");

/**
 *this is the class where we setup all of our environment specific variables
 *
 */
class environment
{
    /*setup the variables here*/
    public static $db_connection;
    public static $tab_url;
    public static $fbappid;
    public static $fbapikey;
    public static $fbapisecret;
    public static $profanity_words;
    public static $web_home_dir;
    public static $mobile_home_dir;
    
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
                /*setup some db vars for dev here*/
				//mongodb://username:password@localhost:27017
                self::$db_connection = array("hostname"=>"mongodb://admin:admin@localhost:27017"
                                              ,"user"=>"admin"
                                              ,"pass"=>"admin"                                              
                                              );

				/*
				* @Profanity words
				*/
				self::$profanity_words = array();
				
                /*tab url for facebook
                self::$tab_url = "https://www.facebook.com/enter-test";
                */
				
                /*facebook app setup stuff here not used yet
                self::$fbappid = "482153885130141";
                self::$fbapikey = "482153885130141";
                self::$fbapisecret = "3b4d34d790b887924059f6cdd8e6e1bb";
				*/
				
				/*
				*
				* Set home dir if you your code in any subdirectories otherwise left blank
				* IMP :: Do not add the HTTP_HOST or DOCUMENT_ROOT (eg : http://localhost or /var/www/html/ etc)
				*
                self::$web_home_dir = "projects/ChicosFas/Source/FullWebsite";
                self::$mobile_home_dir = "projects/ChicosFas/Source/MobileWebsite";
				*/
				
                break;
            
            /**
            *STAGING STAGING STAGING
            *this case is for the STAGING environment
            **/
            case(0):
                /*setup some db vars for dev here*/
                self::$db_connection = array("hostname"=>"mongodb://209.239.120.86:27017"
                                              ,"user"=>"admin"
                                              ,"pass"=>"admin"                                              
                                              );

				/*
				* @Profanity words
				*self::$profanity_words = array("word1","word2");
				*/
				self::$profanity_words = array();

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