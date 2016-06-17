<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             0.1
 * @package           Post_Prompter
 *
 * @wordpress-plugin
 * Plugin Name:       Post Prompter
 * Plugin URI:        http://example.com/post-prompter-uri/
 * Description:       Get prompts to write a blog post delivered to your inbox.
 * Version:           0.1
 * Author:            Charles Cardinaux
 * Author URI:        http://www.charlescardinaux.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-prompter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-post-prompter-activator.php
 */
function activate_post_prompter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-prompter-activator.php';
	Post_Prompter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-post-prompter-deactivator.php
 */
function deactivate_post_prompter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-prompter-deactivator.php';
	Post_Prompter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_post_prompter' );
register_deactivation_hook( __FILE__, 'deactivate_post_prompter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-post-prompter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1
 */
function run_post_prompter() {

	$plugin = new Post_Prompter();
	$plugin->run();

}
run_post_prompter();
