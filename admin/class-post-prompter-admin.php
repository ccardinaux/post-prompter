<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1
 *
 * @package    Post_Prompter
 * @subpackage Post_Prompter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Prompter
 * @subpackage Post_Prompter/admin
 * @author     Your Name <email@example.com>
 */
class Post_Prompter_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $post_prompter    The ID of this plugin.
	 */
	private $post_prompter;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @param      string    $post_prompter       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $post_prompter, $version ) {

		$this->post_prompter = $post_prompter;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1
	 */
	public function add_settings_page() {
		add_options_page(
			'Post Prompter Settings',
			'Post Prompter',
			'manage_options',
			$this->post_prompter,
			array( $this, 'admin_settings_page' )
		);
	}

	public function admin_settings_page() {
		?>
		<div class="wrap">
			<h2>Post Prompter Settings</h2>
		</div>
		<?php
	}

	public function add_user_profile_fields( $user ) {
		?>
		<h3 id="post-prompter">Post Prompter</h3>
		<table class="form-table">
			<tr>
				<th>Prompts via Email</th>
				<td>
					<label for="post_prompter_enabled"><input type="checkbox" name="post_prompter_enabled" id="post_prompter_enabled" value="1" <?php checked( get_user_option( 'post_prompter_enabled', $user->ID ), 1 ); ?> /> Receive blog post prompts via email</label>
				</td>
			</tr>
			<tr>
				<th><label for="post_prompter_frequency">Frequency</label></th>
				<td>
					<select name="post_prompter_frequency" id="post_prompter_frequency">
					<?php for( $i = 1; $i < 15; $i++ ) { ?>
						<option value="<?php echo $i; ?>" <?php selected( get_user_option( 'post_prompter_frequency', $user->ID ), $i ); ?>><?php echo $i; ?></option>
					<?php } ?>
					</select>
					<span>day(s)</span>
					<p class="description">Send me an email reminder if I haven't written a post for this many days.</p>
				</td>
			</tr>
			<tr>
				<th><label for="post_prompter_keywords">Prompt Keywords</label></th>
				<td>
					<input type="text" name="post_prompter_keywords" id="post_prompter_keywords" value="<?php echo esc_attr( get_user_option( 'post_prompter_keywords', $user->ID ) ); ?>" class="regular-text" />
					<p class="description">Enter a comma-separated list of keywords.</p>
				</td>
			</tr>
		</table>
		<?php
	}

	public function save_user_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		update_user_option( absint( $user_id ), 'post_prompter_enabled', absint( $_POST['post_prompter_enabled'] ) );
		update_user_option( absint( $user_id ), 'post_prompter_frequency', absint( $_POST['post_prompter_frequency'] ) );
		update_user_option( absint( $user_id ), 'post_prompter_keywords', sanitize_text_field( $_POST['post_prompter_keywords'] ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Prompter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Prompter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->post_prompter, plugin_dir_url( __FILE__ ) . 'css/post-prompter-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Prompter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Prompter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->post_prompter, plugin_dir_url( __FILE__ ) . 'js/post-prompter-admin.js', array( 'jquery' ), $this->version, false );

	}

}
