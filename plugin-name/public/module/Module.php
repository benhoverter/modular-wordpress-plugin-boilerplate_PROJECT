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
* @author     Your Name <email@example.com>
*/
class Plugin_Abbr_Public_Module {

    /**
    * The ID of this plugin.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $plugin_title    The ID of this plugin.
    */
    private $plugin_title;

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
    * @param      string    $plugin_title       The name of the plugin.
    * @param      string    $version    The version of this plugin.
    */
    public function __construct( $plugin_title, $version ) {

        $this->plugin_title = $plugin_title;
        $this->version = $version;

    }


    /**
    * Render a view before the content.
    * Different hooks will require separate render_{} methods.
    *
    * @since    1.0.0
    */
    public function render_view_before_content( $content ) {

      $view = file_get_contents( plugin_dir_path( __FILE__ ) . 'views/view-name.php' );

      return $view . $content;

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
