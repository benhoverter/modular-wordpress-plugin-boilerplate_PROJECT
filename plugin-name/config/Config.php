<?php

/**
* This class stores the database configuration options. It is not instanced.
*
* NOTE: IMPORTANT! THIS FILE SHOULD BE INCLUDED IN YOUR .gitignore FILE.
*       Do not expose your database configuration on your repository.
*
* @since      1.0.0
*
* @package    plugin-name
* @subpackage plugin-name/config
*/

/**
* This class stores the database configuration options.
*
* @since      1.0.0
* @package    plugin-name
* @subpackage plugin-name/config
* @author     Your Name <email@example.com>
*/
class Plugin_Abbr_Config {

    /**
    * Set the DB config values.
    *
    * @since     1.0.0
    */
    public static function set_config() {

        // Live values:
        $config = array(

            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root',
            'db_name' => 'project_dev'

        );

        return $config;
    }

}
