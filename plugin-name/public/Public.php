<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version,
 * and enqueues the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Ben Hoverter <ben.hoverter@gmail.com>
 */
class Plugin_Abbr_Public {

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
	 * The instance of the Plugin_Element() class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $element    The instance of the Plugin_Element() class.
	 */
	public $element;

    /**
	 * The instance of the Plugin_Element_Ajax() class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $element_ajax    The instance of the Plugin_Element_Ajax() class.
	 */
	public $element_ajax;

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
     * @var      string    $query_master_list    The associative array holding all SQL queries.
     */
    private $query_master_list;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
    public function __construct( $plugin_name, $version /*, $conn, $query_master_list */ ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        $this->load_dependencies();
        $this->set_elements( $plugin_name, $version );

        // For DB interactions:
        //$this->conn = $conn;
        //$this->query_master_list = $query_master_list;

	}


    /**
     * Load the required dependencies for the Public class' elements.
     *
     * Should require_once each Element class file in /public/element.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The element responsible for ________.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'element/Element.php';

        /**
        * The AJAX element responsible for ________.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'element-ajax/Element-Ajax.php';

    }


	/**
	 * Register the combined stylesheet for the public-facing side of the site.
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
         * css/scss/less files into a single public.css file in the /public directory.
		 */

          // Variable to hold the URL path for enqueueing.
          $public_css_url_path = plugin_dir_url( __FILE__ ) . 'public.css';

          // Variable to hold the server path for filemtime() and versioning.
          $public_css_dir_path = plugin_dir_path( __FILE__ ) . 'public.css';

          // Register the style using an automatic and unique version based on modification time.
          wp_register_style( $this->plugin_name, $public_css_url_path , array() ,  filemtime( $public_css_dir_path ) , 'all' );

          // Enqueue the style.
          wp_enqueue_style( $this->plugin_name );
          //wp_enqueue_style( 'thickbox' );

	}

	/**
	 * Register the concat/minified JavaScript for the public-facing side of the site.
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
        * JavaScript files into a single public.min.js file in the /public directory.
		 */

        // Variable to hold the URL path for enqueueing.
        $public_js_url_path = plugin_dir_url( __FILE__ ) . 'public.min.js';

        // Variable to hold the server path for filemtime() and versioning.
        $public_js_dir_path = plugin_dir_path( __FILE__ ) . 'public.min.js';

        // Register the script using an automatic and unique version based on modification time.
        wp_register_script( $this->plugin_name, $public_js_url_path , array( 'jquery' ) ,  filemtime( $public_js_dir_path ) , true );

        // Enqueue the scripts.
        wp_enqueue_script( $this->plugin_name );

        // PHP data for the frontend.  One wp_localize_script() call per element.
        // Localize the script to make PHP data available to AJAX JS.  Define data in Element-Ajax.php.
        wp_localize_script( $this->plugin_name, 'abbr_public_element_data', $this->element_ajax->get_ajax_data() );

	}


    /**
	 * Sets instances of each public element class.
     * Those elements' methods are hooked in /includes/Main.php.
     *
     * Initialize each element object in the property list above,
     * then instance them here!
	 *
	 * @since    1.0.0
	 */
	public function set_elements( $plugin_name, $version ) {

        $this->element = new Plugin_Abbr_Public_Element( $plugin_name, $version );
        $this->element_ajax = new Plugin_Abbr_Public_Element_Ajax( $plugin_name, $version );

    }


}
