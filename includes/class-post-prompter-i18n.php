<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      0.1
 *
 * @package    Post_Prompter
 * @subpackage Post_Prompter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1
 * @package    Post_Prompter
 * @subpackage Post_Prompter/includes
 * @author     Your Name <email@example.com>
 */
class Post_Prompter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'post-prompter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
