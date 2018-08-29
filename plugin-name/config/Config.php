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
    * The database hostname.
    *
    * @since    1.0.0
    * @access   public
    * @var      string    $host    The database hostname.
    */
    public $host;

    /**
    * The database username.
    *
    * @since    1.0.0
    * @access   public
    * @var      string    $user    The database username.
    */
    public $user;

    /**
    * The database name.
    *
    * @since    1.0.0
    * @access   public
    * @var      string    $password    The database name.
    */
    public $password;

    /**
    * The database name.
    *
    * @since    1.0.0
    * @access   public
    * @var      string    $db_name    The database name.
    */
    public $db_name;



    /**
    * Set the DB config values.
    *
    * @since     1.0.0
    */
    public static function set_config() {

        $this->host = 'hostname';
        $this->user = 'username';
        $this->password = 'password';
        $this->db_name = 'db_name';

    }

}
