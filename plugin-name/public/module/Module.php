<?php

/**
* Does one thing well.
*
* @link       http://example.com
* @since      1.0.0
*
* @package    plugin-name
* @subpackage plugin-name/public/module
*/

/**
* Does one thing well.
*
* Here's the description of how it does it.
*
* @package    plugin-name
* @subpackage plugin-name/public/module
* @author     Ben Hoverter <ben.hoverter@gmail.com>
*/
class Plugin_Abbr_Public_Module {

    /**
    * The ID of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $plugin_name    The ID of this plugin.
    */
    private $plugin_name;

    /**
    * The version of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $version    The current version of this plugin.
    */
    private $version;


    /**
    * Initialize the class and set its properties.
    *
    * @since    1.0.0
    * @param      string    $plugin_name       The name of the plugin.
    * @param      string    $version    The version of this plugin.
    */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }


    /**
    * Render a view.
    * Different hooks will require separate render_{} methods.
    *
    * @since    1.0.0
    */
    public function render_view() {

        /**
        * The view responsible for ________.
        */
        include( plugin_dir_path( __FILE__ ) . 'views/view-name.php' ) ;

    }


    /**
    * Do a thing.
    *
    * @since    1.0.0
    * @param      string    $your_param       Param description.
    * @return     string    $return_var       The var this method returns.
    */
    public function method( $your_param ) {

        // Do the thing.

    }


}
