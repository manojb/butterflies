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
    public static $profanity_words;
    
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
				//mongodb://username:password@Hostname:Portno
                self::$db_connection = array("hostname"=>"mongodb://admin:admin@localhost:27017");

				/*
				* @Profanity words
				* @ eg : $profanity_words = array('words1','word2');
				*/
				self::$profanity_words = array();
				
                break;
            
            /**
            *STAGING STAGING STAGING
            *this case is for the STAGING environment
            **/
            case(0):
                /*setup some db vars for dev here*/
				//mongodb://username:password@Hostname:Portno
                self::$db_connection = array("hostname"=>"mongodb://209.239.120.86:27017");

				/*
				* @Profanity words
				*/
				self::$profanity_words = array();

                break;
            
            /**
            *PRODUCTION PRODUCTION PRODUCTION
            *this case is for the production environment
            **/
            case(1):
                /*setup some db vars for dev here*/
				//mongodb://username:password@Hostname:Portno
                self::$db_connection = array("hostname"=>"prodhost");

				/*
				* @Profanity words
				*/
				self::$profanity_words = array();

                break;
        }
    }
}

?>