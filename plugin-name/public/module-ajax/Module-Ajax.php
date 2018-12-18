<?php

/**
* Does one thing well.
*
* @link       http://example.com
* @since      1.0.0
*
* @package    plugin-name
* @subpackage plugin-name/public/module-ajax
*/

/**
* Does one thing well.
*
* Here's the description of how it does it.
*
* @package    plugin-name
* @subpackage plugin-name/public/module-ajax
* @author     Your Name <email@example.com>
*/
class Plugin_Abbr_Public_Module_Ajax {

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
    * The data object for public AJAX functions.
    *
    * @since    1.0.0
    * @access   private
    * @var      associative array    $ajax_data    The data for public AJAX functions.
    */
    private $ajax_data;

    /**
    * The nonce for the AJAX call.  Must be available to public_ajax_callback().
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $ajax_nonce    The nonce for the AJAX call.
    */
    private $ajax_nonce;

    /**
    * The current post ID.  Needed for AJAX (otherwise unavailable).
    *
    * @since    1.0.0
    * @access   public
    * @var      object    $post_id    The current post ID.
    */
    public $post_id;


    /**
    * Initialize the class and set its properties.
    *
    * @since    1.0.0
    * @param      string    $plugin_title       The name of the plugin.
    * @param      string    $version           The version of this plugin.
    */
    public function __construct( $plugin_title, $version ) {

        $this->plugin_title = $plugin_title;
        $this->version = $version;

    }


    // ***** PRE-CALL METHODS ***** //

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
    * Set data to be passed to the frontend.
    *
    * @since    1.0.0
    */
    public function set_data_callback() {

        // Frontend data for data table:
        wp_localize_script(

            $this->plugin_title . '-public-js',

            'data_package_name',

            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'module_ajax_data_nonce' => wp_create_nonce( 'abbr_module_ajax_data_nonce' )
            )

        );

        // Add'l calls to wp_localize_script() for add'l data sets go here:

    }


    // ***** POST-CALL METHODS ***** //

    /**
    * AJAX callback function to bind to wp_ajax_{action_name} hook.
    *
    * @since    1.0.0
    */
    public function module_ajax_callback() {

        check_ajax_referer( 'abbr_module_ajax_data_nonce', 'ajax_nonce' ); // Dies if false.

        // Call the handler function.
        echo $this->handler_function();

        // Needed to return AJAX:
        wp_die();

    }


    /**
    * Handler function called by module_ajax_callback().
    *
    * @since    1.0.0
    */
    private function handler_function() {

    }


}
