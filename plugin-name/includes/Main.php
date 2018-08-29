<?php

/**
* The file that defines the core plugin class
*
* A class definition that includes attributes and functions used across both the
* public-facing side of the site and the admin area.
*
* @link       https://github.com/benhoverter/modular-wordpress-plugin-boilerplate
* @since      1.0.0
*
* @package    plugin-name
* @subpackage plugin-name/includes
*/

/**
* The core plugin class.
*
* This is used to define internationalization, admin-specific hooks
* settings page hooks, and public-facing site hooks.
*
* Also maintains the unique identifier of this plugin as well as the current
* version of the plugin.
*
* @since      1.0.0
* @package    plugin-name
* @subpackage plugin-name/includes
* @author     Your Name <email@example.com>
*/
class Plugin_Name {

    /**
    * The loader that's responsible for maintaining and registering all hooks that power
    * the plugin.
    *
    * @since    1.0.0
    * @access   protected
    * @var      Plugin_Abbr_Loader    $loader    Maintains and registers all hooks for the plugin.
    */
    protected $loader;

    /**
    * The unique identifier of this plugin.
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_title    The string used to uniquely identify this plugin.
    */
    protected $plugin_title;

    /**
    * The current version of the plugin.
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $version    The current version of the plugin.
    */
    protected $version;

    /**
    * The mysqli database connection object instance.
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $conn    The mysqli database connection object instance.
    */
    public $conn;

    /**
    * The array of SQL queries that the plugin can run.
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $queries    The array of SQL queries that the plugin can run.
    */
    public $queries;


    /**
    * Define the core functionality of the plugin.
    *
    * Set the plugin name and the plugin version that can be used throughout the plugin.
    * Load the dependencies, define the locale, and set the hooks for the admin area and
    * the public-facing side of the site.
    *
    * @since    1.0.0
    */
    public function __construct() {
        if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
            $this->version = PLUGIN_NAME_VERSION;
        } else {
            $this->version = '1.0.0';
        }

        $this->plugin_title = 'Plugin Name';
        $this->load_dependencies_includes();

        // Localization.
        $this->set_locale();

        // Add new module files to one of these:
        $this->load_dependencies_admin();
        $this->load_dependencies_public();
        $this->load_dependencies_config();

        // These shouldn't need modification:
        $this->define_admin_asset_hooks();
        $this->define_public_asset_hooks();

        // The WeDevs Settings API interface:
        $this->define_settings_hooks();

        // Create a new hook definer for each module:
        $this->define_admin_module_hooks();
        $this->define_admin_module_ajax_hooks();

        $this->define_public_module_hooks();
        $this->define_public_module_ajax_hooks();

    }


    /**
    * Load the dependencies from /includes.
    *
    * Include the following files that make up the plugin:
    * - Loader.php. Orchestrates the hooks of the plugin.
    * - I18n.php. Defines internationalization functionality.
    *
    * Create an instance of the loader which will be used to register the hooks
    * with WordPress.
    *
    * @since    1.0.0
    * @access   private
    */
    private function load_dependencies_includes() {

        /**
        * The class responsible for orchestrating the actions and filters of the
        * core plugin.
        */
        require_once plugin_dir_path( __DIR__ ) . 'includes/Loader.php';

        /**
        * The class responsible for defining internationalization functionality
        * of the plugin.
        */
        require_once plugin_dir_path( __DIR__ ) . 'includes/I18n.php';

        // Instantiates the Loader object:
        $this->loader = new Plugin_Abbr_Loader();

    }


    /**
    * Load the required dependencies for the admin area.
    *
    * Include the following files that make up the plugin:
    * - Assets.php. Versions and enqueues JS and CSS for the admin area.
    * - Settings.php.  Defines the WeDevs Settings API integration.
    * - Module.php.  Defines the stuff.
    * - Module-Ajax.php.  Defines the AJAX stuff.
    *
    * @since    1.0.0
    * @access   private
    */
    private function load_dependencies_admin() {

        /**
        * The class responsible for versioning and enqueueing the combined
        * admin-area scripts and styles.
        */
        require_once plugin_dir_path( __DIR__ ) . 'admin/Assets.php';

        /**
        * The class responsible for defining all admin settings and menu options.
        */
        require_once plugin_dir_path( __DIR__ ) . 'admin/Settings.php';

        /**
        * The class responsible for the admin MODULE FUNCTIONS.
        */
        require_once plugin_dir_path( __DIR__ ) . 'admin/module/Module.php';

        /**
        * The class responsible for the admin MODULE-AJAX FUNCTIONS.
        */
        require_once plugin_dir_path( __DIR__ ) . 'admin/module-ajax/Module-Ajax.php';

    }


    /**
    * Load the required dependencies for the public area.
    *
    * Include the following files that make up the plugin:
    * - Assets.php. Versions and enqueues JS and CSS for the public area.
    * - Module.php.  Defines the stuff.
    * - Module-Ajax.php.  Defines the AJAX stuff.
    *
    * @since    1.0.0
    * @access   private
    */
    private function load_dependencies_public() {

        /**
        * The class responsible for versioning and enqueueing the combined
        * public-area scripts and styles.
        */
        require_once plugin_dir_path( __DIR__ ) . 'public/Assets.php';

        /**
        * The class responsible for the public MODULE FUNCTIONS.
        */
        require_once plugin_dir_path( __DIR__ ) . 'public/module/Module.php';

        /**
        * The class responsible for the public MODULE-AJAX FUNCTIONS.
        */
        require_once plugin_dir_path( __DIR__ ) . 'public/module-ajax/Module-Ajax.php';

    }


    /**
    * Load the required dependencies for the database configuration and queries.
    *
    * Include the following files that make up the plugin:
    * - Config.php. Defines all configuration options for the database connection.
    * - Queries.php.  Defines the queries to run on the database.
    *
    * @since    1.0.0
    * @access   private
    */
    private function load_dependencies_config() {

        /**
        * The class responsible for defining the database configuration options.
        */
        require_once plugin_dir_path( __DIR__ ) . 'config/Config.php';

        /**
        * The class responsible for defining the SQL queries run by the plugin.
        */
        require_once plugin_dir_path( __DIR__ ) . 'config/Queries.php';

    }


    /**
    * Define the locale for this plugin for internationalization.
    *
    * Uses the Plugin_Abbr_i18n class in order to set the domain and to register the hook
    * with WordPress.
    *
    * @since    1.0.0
    * @access   private
    */
    private function set_locale() {

        $plugin_i18n = new Plugin_Abbr_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }


    /**
    * Version and enqueue the JS and CSS for the admin side of the plugin.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_admin_asset_hooks() {

        $admin_assets = new Plugin_Abbr_Admin_Assets( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $admin_assets, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $admin_assets, 'enqueue_scripts' );

    }


    /**
    * Version and enqueue the JS and CSS for the public side of the plugin.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_public_asset_hooks() {

        $public_assets = new Plugin_Abbr_Public_Assets( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $public_assets, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $public_assets, 'enqueue_scripts' );

    }


    /**
    * Register all of the hooks related to the WeDevs Settings API functionality
    * of the plugin.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_settings_hooks() {

        $plugin_settings = new Plugin_Abbr_Settings( $this->get_plugin_name(), $this->get_version() );

        // Standard functions that call dev-defined sections and menus in the Settings class:
        $this->loader->add_action( 'admin_menu', $plugin_settings, 'admin_menu' );
        $this->loader->add_action( 'admin_init', $plugin_settings, 'admin_init' );

    }


    // ************************* ADMIN MODULE HOOKS ************************* //
    /**
    * Register all of the hooks related to the admin module functionality.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_admin_module_hooks() {

        $module = new Plugin_Abbr_Admin_Module( $this->get_plugin_name(), $this->get_version() );

        // Standard hooks go here:
        //$this->loader->add_action( 'add_meta_boxes{_post_type}', $module->element, 'render_metabox' );
        //$this->loader->add_action( 'save_post{_post_type}', $module->element, 'save_metabox' );
        $this->loader->add_action( 'admin_init', $module, 'render_view' );

    }


    /**
    * Register all of the hooks related to the admin module-ajax functionality.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_admin_module_ajax_hooks() {

        $module_ajax = new Plugin_Abbr_Admin_Module_Ajax( $this->get_plugin_name(), $this->get_version() );

        // Standard hooks go here:
        //$this->loader->add_action( 'add_meta_boxes{_post_type}', $module_ajax, 'render_metabox' );
        //$this->loader->add_action( 'save_post{_post_type}', $module_ajax, 'save_metabox' );
        $this->loader->add_action( 'admin_init', $module_ajax, 'render_view' );

        // AJAX hooks go here:
        //$this->loader->add_action( 'wp_ajax_{action_name}', $module_ajax, 'element_ajax_callback' );

    }


    // ************************* PUBLIC MODULE HOOKS ************************* //
    /**
    * Register all of the hooks related to the admin module functionality.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_public_module_hooks() {

        $module = new Plugin_Abbr_Public_Module( $this->get_plugin_name(), $this->get_version() );

        // Standard hooks go here:
        //$this->loader->add_action( 'add_meta_boxes{_post_type}', $module->element, 'render_metabox' );
        //$this->loader->add_action( 'save_post{_post_type}', $module->element, 'save_metabox' );
        $this->loader->add_action( 'wp_head', $module, 'render_view' );
        $this->loader->add_action( 'wp_head', $module, 'public_test' );

    }


    /**
    * Register all of the hooks related to the admin module-ajax functionality.
    *
    * @since    1.0.0
    * @access   private
    */
    private function define_public_module_ajax_hooks() {

        $module_ajax = new Plugin_Abbr_Public_Module_Ajax( $this->get_plugin_name(), $this->get_version() );

        // Standard hooks go here:
        //$this->loader->add_action( 'add_meta_boxes{_post_type}', $module_ajax, 'render_metabox' );
        //$this->loader->add_action( 'save_post{_post_type}', $module_ajax, 'save_metabox' );
        $this->loader->add_action( 'wp_head', $module_ajax, 'render_view' );

        // AJAX hooks go here:
        $this->loader->add_action( 'wp_ajax_{action_name}', $module_ajax, 'element_ajax_callback' );

    }


    // ************************* UTILITY FUNCTIONS ************************* //
    /**
    * Run the loader to execute all of the hooks with WordPress.
    *
    * @since    1.0.0
    */
    public function run() {
        $this->loader->run();
    }


    /**
    * The name of the plugin used to uniquely identify it within the context of
    * WordPress and to define internationalization functionality.
    *
    * @since     1.0.0
    * @return    string    The name of the plugin.
    */
    public function get_plugin_name() {
        return $this->plugin_title;
    }


    /**
    * The reference to the class that orchestrates the hooks with the plugin.
    *
    * @since     1.0.0
    * @return    Plugin_Abbr_Loader    Orchestrates the hooks of the plugin.
    */
    public function get_loader() {
        return $this->loader;
    }


    /**
    * Retrieve the version number of the plugin.
    *
    * @since     1.0.0
    * @return    string    The version number of the plugin.
    */
    public function get_version() {
        return $this->version;
    }


    /**
    * Get the config options for the DB and initialize a mysqli object instance.
    *
    * @since     1.0.0
    * @return    object    The mysqli database connection object instance.
    */
    public function set_db_connection() {

        $config = Plugin_Abbr_Config::set_config();

        $this->conn = new mysqli(
            $config->host,
            $config->user,
            $config->password,
            $config->db_name
        );

        return $this->conn;
    }


    /**
    * Retrieve the master list of queries to run.
    *
    * @since     1.0.0
    * @return    array    The multidimensional array of queries.
    */
    public function get_queries() {

        $this->queries = Plugin_Abbr_Queries::get_queries();

        return $this->queries;
    }




}
