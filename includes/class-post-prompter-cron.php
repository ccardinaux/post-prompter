<?php

/**
 * The cron-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1
 *
 * @package    Post_Prompter
 * @subpackage Post_Prompter/includes
 */

/**
 * The cron-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Prompter
 * @subpackage Post_Prompter/includes
 * @author     Your Name <email@example.com>
 */
class Post_Prompter_Cron {

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

	public function add_custom_cron_schedules( $schedules ) {
		for( $i = 2; $i < 15; $i++) {
			$schedules["{$i}_days"] = array(
				'interval'	=> ($i * 24 * 60 * 60),
				'display'	=> "Once Every {$i} Days"
			);
		}

		return $schedules;
	}

	public function schedule_post_prompt( $user_id ) {
		$old_schedule = wp_get_schedule( 'post_prompt_scheduled_send', array( $user_id ) );
		$new_schedule = get_user_option( 'post_prompter_frequency', $user_id ) . '_days';

		if( get_user_option( 'post_prompter_enabled', $user_id ) == 1 ) {
			if( $old_schedule && $old_schedule != $new_schedule ) {
				wp_clear_scheduled_hook( 'post_prompt_scheduled_send', array( $user_id ) );
			}
			
			if( !$old_schedule || $old_schedule != $new_schedule ) {
				wp_schedule_event( time(), $new_schedule, 'post_prompt_scheduled_send', array( $user_id ) );
			}
		}
		else {
			if( $old_schedule )
				wp_clear_scheduled_hook( 'post_prompt_scheduled_send', array( $user_id ) );
		}
	}

	public function send_post_prompt( $user_id ) {
		$user_data = get_userdata( $user_id );
		$user_meta = get_user_meta( $user_id );

		if( $user_meta['first_name'][0] != '' ) {
			$user_first_name = $user_meta['first_name'][0];
		}
		else {
			$user_first_name = $user_meta['nickname'][0];
		}

		$to = $user_data->data->user_email;
		$subject = "It's time to write a blog post!";
		$message = $this->generate_post_prompt_email( $user_id, $user_first_name );
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		wp_mail( $to, $subject, $message, $headers );
	}

	private function generate_post_prompt_email( $user_id, $user_first_name ) {
		$keywords = get_user_option( 'post_prompter_keywords', $user_id );
		$site_url = get_site_url();
		$site_name = get_bloginfo( 'name' );
		$new_post_url = admin_url( 'post-new.php' );
		$unsubscribe_url = admin_url( 'profile.php#post-prompter' );
		$most_recent_post = $this->get_last_published_post( $user_id );
		$most_recent_post_url = get_permalink( $most_recent_post->ID );
		$time_since_last_post = $this->get_time_since_last_post( $most_recent_post );

		if( $time_since_last_post ) {
			$last_published = "It looks like the last time you published a blog post on <a href='{$site_url}'>{$site_name}</a> was {$time_since_last_post}.";
		}
		else {
			$last_published = "It looks like you've never published a blog post on <a href='{$site_url}'>{$site_name}</a>.";
		}

		if( $most_recent_post ) {
			$most_recent = "While your last post <a href='{$most_recent_post_url}'>{$most_recent_post->post_title}</a> was awesome, your readers (and search engines) want fresh content.";
		}
		else {
			$most_recent = "Updating your blog with fresh content gives your readers (and search engines) reasons to keep coming back to your website.";
		}

		$args = array(
			'first_name' => $user_first_name,
			'last_published' => $last_published,
			'most_recent' => $most_recent,
			'new_post_url' => $new_post_url,
			'keywords' => $keywords,
			'unsubscribe_url' => $unsubscribe_url,
		);

		$html = $this->post_prompt_email_template( $args );

		return $html;
	}

	private function get_last_published_post( $user_id ) {
		$args = array(
			'posts_per_page' => 1,
			'author'	     => $user_id,
		);

		$most_recent_post = get_posts( $args );

		if( is_array( $most_recent_post ) && count( $most_recent_post ) > 0 )
			return $most_recent_post[0];

		return false;
	}

	private function get_time_since_last_post( $post ) {
		if( $post ) {
			return sprintf( _x( '%s ago',
								'%s = human-readable time difference',
								'post-prompter' ),
							human_time_diff(
								get_the_time( 'U', $post->ID ),
								current_time( 'timestamp' )
							)
			);
		}

		return false;
	}

	private function post_prompt_email_template( $args ) {
		extract( $args );

		$news_url = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . urlencode($keywords);
		$feed_url = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . urlencode($keywords) . '&output=rss';

		include_once(ABSPATH . WPINC . '/feed.php');
		$rss = fetch_feed( $feed_url );

		$maxitems = 0;

		if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

			// Figure out how many total items there are, but limit it to 5. 
			$maxitems = $rss->get_item_quantity( 5 ); 

			// Build an array of all the items, starting with element 0 (first element).
			$rss_items = $rss->get_items( 0, $maxitems );

		endif;

		ob_start();
		
		require plugin_dir_path( __FILE__ ) . 'partials/post-prompter-email-template.php';
		
		$html = ob_get_contents();
		
		ob_end_clean();
		
		return $html;
	}

}
