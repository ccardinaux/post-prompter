<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      0.1
 *
 * @package    Post_Prompter
 * @subpackage Post_Prompter/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1
 * @package    Post_Prompter
 * @subpackage Post_Prompter/includes
 * @author     Your Name <email@example.com>
 */
class Post_Prompter {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      Post_Prompter_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $post_prompter    The string used to uniquely identify this plugin.
	 */
	protected $post_prompter;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function __construct() {

		$this->post_prompter = 'post-prompter';
		$this->version = '0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Post_Prompter_Loader. Orchestrates the hooks of the plugin.
	 * - Post_Prompter_i18n. Defines internationalization functionality.
	 * - Post_Prompter_Admin. Defines all hooks for the admin area.
	 * - Post_Prompter_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-post-prompter-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-post-prompter-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-post-prompter-admin.php';

		/**
		 * The class responsible for defining all actions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-post-prompter-cron.php';

		$this->loader = new Post_Prompter_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Post_Prompter_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Post_Prompter_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Post_Prompter_Admin( $this->get_post_prompter(), $this->get_version() );
		$plugin_cron = new Post_Prompter_Cron( $this->get_post_prompter(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_page' );
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'add_user_profile_fields' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'add_user_profile_fields' );
		$this->loader->add_action( 'personal_options_update', $plugin_admin, 'save_user_profile_fields' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'save_user_profile_fields' );

		$this->loader->add_filter( 'cron_schedules', $plugin_cron, 'add_custom_cron_schedules' );
		$this->loader->add_action( 'personal_options_update', $plugin_cron, 'schedule_post_prompt', 99 );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_cron, 'schedule_post_prompt', 99 );
		$this->loader->add_action( 'post_prompt_scheduled_send', $plugin_cron, 'send_post_prompt' );
 
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_post_prompter() {
		return $this->post_prompter;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1
	 * @return    Post_Prompter_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
