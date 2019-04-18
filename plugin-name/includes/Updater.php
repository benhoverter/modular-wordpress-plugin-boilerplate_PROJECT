<?php

/**
* The file that defines the methods for automatic updates in WordPress
*
* A class definition that includes properties and methods used to update the plugin
* from within the WordPress Plugin area.
*
* @link       https://github.com/benhoverter/modular-wordpress-plugin-boilerplate
* @since      1.0.0
*
* @package    plugin-name
* @subpackage plugin-name/includes
*/

/**
* The plugin updater class.
*
*
* @since      1.0.0
* @package    plugin-name
* @subpackage plugin-name/includes
* @author     Your Name <email@example.com>
*/
class Plugin_Abbr_Updater {

    /**
    * The plugin slug.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $slug    The plugin slug.
    */
    private $slug;

    /**
    * The plugin metadata drawn from WordPress.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $plugin_data    The plugin metadata.
    */
    private $plugin_data;

    /**
    * The username for the GitHub repo.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $github_username    The username for the GitHub repo.
    */
    private $github_username;

    /**
    * The GitHub repo name.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $repo_name    The GitHub repo name.
    */
    private $repo_name;

    /**
    * The plugin file, passed in as __FILE__ in the main plugin-name.php script.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $plugin_file    The plugin file.
    */
    private $plugin_file;

    /**
    * The result of the GitHub API call.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $github_api_result    The result of the GitHub API call.
    */
    private $github_api_result;

    /**
    * The access token for the GitHub repo.
    *
    * @since    1.0.0
    * @access   private
    * @var      string    $github_token    The access token for the GitHub repo.
    */
    private $github_token;


    /**
    * Set the properties from params and add the filters that hook into our public methods.
    *
    *
    * @since    1.0.0
    */
    public function __construct( $plugin_file, $github_username, $repo_name, $github_token ) {

      add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'set_transient' ) );
      // add_filter( 'plugins_api', array( $this, 'set_plugin_info' ) );
      // add_filter( 'upgrader_post_install', array( $this, 'handle_post_install' ) );

      $this->$plugin_file     = $plugin_file;
      $this->$github_username = $github_username;
      $this->$repo_name       = $repo_name;
      $this->$github_token    = $github_token;

    }


    /**
    * Short Description. (use period)
    *
    * Long Description.
    *
    * @since    1.0.0
    */
    private function get_plugin_data() {
      $this->slug = plugin_basename( $this->plugin_file );
      $this->plugin_data = get_plugin_data( $this->plugin_file );
    }

    /**
    * Short Description. (use period)
    *
    * Long Description.
    *
    * @since    1.0.0
    */
    private function get_repo_release_info() {

      // Prevent a double-call on 'pre_set_site_transient_update_plugins' hook,
      // which WP calls twice:
      if( !empty( $this->github_api_result ) ) {
        return;
      }

      // Set the GitHub API URL:
      $url = "https://api.github.com/repos/" . $this->username . "/" . $this->repo_name . "/releases";

      // Append the access token for the private repo:
      if( !empty( $this->github_token ) ) {
        $url = add_query_arg( array(
            'access_token' => $this->github_token,
          ), $url
        );
      }

      // Call the API:
      $this->github_api_result = wp_remote_retrieve_body(
        wp_remote_get( $url )
      );

      // Parse the response from JSON:
      // Suppress errors, just in case GitHub throws up.
      if( !empty( $this->github_api_result ) ) {
        $this->github_api_result = @json_decode( $this->github_api_result );
      }

      // Keep only the latest release:
      $this->github_api_result = $this->github_api_result[0];

    }

    /**
    * Provides info on the plugin update to WP.
    *
    * Called on 'pre_set_site_transient_update_plugins',
    * which WP calls when it checks for plugin updates.
    *
    * @since    1.0.0
    */
    public function set_transient( $transient ) {

      // If WP already checked for updates, don't re-check:
      if( empty( $transient->checked ) ) {
        return $transient;
      }

      // Get the plugin and release info:
      $this->get_plugin_data();
      $this->get_repo_release_info();

      var_dump( $this->plugin_data );
      // var_dump( $this->github_api_result );

    }


    /**
    * Short Description. (use period)
    *
    * Long Description.
    *
    * @since    1.0.0
    */
    public function set_plugin_info() {

    }


    /**
    * Short Description. (use period)
    *
    * Long Description.
    *
    * @since    1.0.0
    */
    public function handle_post_install() {

    }

}
