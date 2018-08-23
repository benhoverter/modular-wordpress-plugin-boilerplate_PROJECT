<?php

/**
 * This class stores the database configuration options. It is not instanced.
 *
 * NOTE: IMPORTANT! THIS FILE SHOULD BE INCLUDED IN YOUR .gitignore FILE!
 *       Do not expose your database configuration on your repository!
 *
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/config
 */

/**
 * This class stores the database configuration options. It is not instanced.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/config
 * @author     Ben Hoverter <ben.hoverter@gmail.com>
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
	 * Initialize the config values.
     *
     * Values should be entered in the set_config() method below.
	 *
	 * @since     1.0.0
	 */
    public function __construct() {

        $this->set_config();

    }


	/**
	 * Set the DB config values.
	 *
	 * @since     1.0.0
	 */
	public function set_config() {

        $this->host = 'hostname';
        $this->user = 'username';
        $this->password = 'password';
        $this->db_name = 'db_name';

	}

}
