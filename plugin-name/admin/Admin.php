<?php

/**
* The admin-specific functionality of the plugin.
*
* @link       http://example.com
* @since      1.0.0
*
* @package    plugin-name
* @subpackage plugin-name/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name and version,
* enqueues the admin-facing stylesheet and JavaScript,
* and pipes in the admin-facing functions.
*
* @package    plugin-name
* @subpackage plugin-name/admin
* @author     Ben Hoverter <ben.hoverter@gmail.com>
*/
class Plugin_Abbr_Admin {

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
    * The data array for admin AJAX functions.
    *
    * @since    1.0.0
    * @access   public
    * @var      associative array    $ajax_data    The data for admin AJAX functions.
    */
    public $ajax_data;

    /**
    * The nonce for the AJAX call.  Must be available to event_mats_ajax_save().
    *
    * @since    1.0.0
    * @access   public
    * @var      string    $ajax_nonce    The nonce for the AJAX call.
    */
    public $ajax_nonce;

    /**
    * The current post ID.  Needed for AJAX (otherwise unavailable).
    *
    * @since    1.0.0
    * @access   public
    * @var      object    $post_id    The current post ID.
    */
    public $post_id;

    /**
    * The current mysqli database connection object.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $conn    The current mysqli database connection object.
    */
    private $conn;

    /**
    * The associative array holding all SQL queries.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $queries    The associative array holding all SQL queries.
    */
    private $queries;


    /**
    * Initialize the class and set its properties.
    *
    * @since    1.0.0
    * @param      string    $plugin_name       The name of the plugin.
    * @param      string    $version    The version of this plugin.
    */
public function __construct( $plugin_name, $version /*, $conn, $queries */ ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

    $this->load_dependencies( $plugin_name, $version );
    $this->set_elements( $plugin_name, $version );

    // For DB interactions:
    //$this->conn = $conn;
    //$this->queries = $queries;

}


/**
* Load the required dependencies for the Admin class elements.
*
* Should require_once each Element class file in /admin/element.
*
* @since    1.0.0
* @access   private
*/
private function load_dependencies( $plugin_name, $version ) {

    /**
    * The element responsible for ________.
    */
    require_once plugin_dir_path( __FILE__ ) . 'element/Element.php';
    $this->element = new Plugin_Abbr_Admin_Element( $plugin_name, $version );

    /**
    * The AJAX element responsible for ________.
    */
    require_once plugin_dir_path( __FILE__ ) . 'element-ajax/Element-Ajax.php';
    $this->element_ajax = new Plugin_Abbr_Admin_Element_Ajax( $plugin_name, $version );

}


/**
* Register the combined stylesheet for the admin-facing side of the site.
*
* @since    1.0.0
*/
public function enqueue_styles() {

    /**
    * An instance of this class is passed to the run() function
    * defined in Plugin_Abbr_Loader, which then creates the relationship
    * between the defined hooks and the functions defined in this
    * class.
    *
    * This architecture assumes you are transpiling all child directory
    * css/scss/less files into a single admin.css file in the /admin directory.
    */

    // Variable to hold the URL path for enqueueing.
    $admin_css_dir_url = plugin_dir_url( __DIR__ ) . 'assets/admin/admin.min.css';

    // Variable to hold the server path for filemtime() and versioning.
    $admin_css_dir_path = plugin_dir_path( __DIR__ ) . 'assets/admin/admin.min.css';

    // Register the style using an automatic and unique version based on modification time.
    wp_register_style( $this->plugin_name, $admin_css_dir_url, array(), filemtime( $admin_css_dir_path ), 'all' );

    // Enqueue the style.
    wp_enqueue_style( $this->plugin_name );
    //wp_enqueue_style( 'thickbox' );

}

/**
* Register the concat/minified JavaScript for the admin-facing side of the site.
*
* @since    1.0.0
*/
public function enqueue_scripts() {

    /**
    * An instance of this class is passed to the run() function
    * defined in Plugin_Abbr_Loader, which then creates the relationship
    * between the defined hooks and the functions defined in this
    * class.
    *
    * This architecture assumes you are transpiling all child directory
    * JavaScript files into "/admin/admin.min.js".
    */

    // Variable to hold the URL path for enqueueing.
    $admin_js_dir_url = plugin_dir_url( __DIR__ ) . 'assets/admin/admin.min.js';

    // Variable to hold the server path for filemtime() and versioning.
    $admin_js_dir_path = plugin_dir_path( __DIR__ ) . 'assets/admin/admin.min.js';

    // Register the script using an automatic and unique version based on modification time.
    wp_register_script( $this->plugin_name, $admin_js_dir_url, array( 'jquery' ), filemtime( $admin_js_dir_path ), true );

    // Enqueue the scripts.
    wp_enqueue_script( $this->plugin_name );

    // PHP data for the frontend.  Do one wp_localize_script() call per element.
    // Localize the script to make PHP data available to AJAX JS.  Define data in Element-Ajax.php.
    wp_localize_script( $this->plugin_name, 'abbr_admin_element_data', $this->element_ajax->get_ajax_data() );

}


/**
* Sets instances of each admin element class.
* Those elements' methods are hooked in /includes/Main.php.
*
* Initialize each element object in the property list above,
* then instance them here!
*
* @since    1.0.0
*/
public function set_elements( $plugin_name, $version ) {

    $this->element = new Plugin_Abbr_Admin_Element( $plugin_name, $version );
    $this->element_ajax = new Plugin_Abbr_Admin_Element_Ajax( $plugin_name, $version );

}


}
