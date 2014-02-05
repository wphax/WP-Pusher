<?php
/**
 * Plugin Name: WP Pusher
 * Plugin URI: http://wphax.com/blog/wp-pusher
 * Description: A WordPress plugin using the Pusher service to send push notifications to client browsers.
 * Version: 0.1b
 * Author: Jared Helgeson
 * Author URI: http://wphax.com
 */

if( !class_exists( 'WP_Pusher' ) ) {

	class WP_Pusher {
		private $version;
		private $options;
		private $pusher;

		public function __construct() {
			$this->version = 0.1;
			$this->options = get_option( 'wp_pusher', false );
			$this->pusher = false;

			add_action( 'publish_post', array( $this, 'publish_post' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		}

		public function set_pusher() {
			if( $this->settings_ok() ) {
				include_once 'pusher-php-server/lib/Pusher.php';
				$this->pusher = new Pusher( $this->options[ 'key' ], $this->options[ 'secret' ], $this->options[ 'app_id' ] );
			}
		}

		public function settings_ok() {
			$options = $this->options;
			return (
				( isset( $options[ 'active' ] ) && $options[ 'active' ] ) &&
				( isset( $options[ 'app_id' ] ) && $options[ 'app_id' ] !== '' ) &&
				( isset( $options[ 'key' ] ) && $options[ 'key' ] !== '' ) && 
				( isset( $options[ 'secret' ] ) && $options[ 'secret' ] !== '' )
			);
		}

		public function publish_post( $post_id ) {
			$post = get_post( $post_id );
			$post->permalink = get_permalink( $post->ID );
			if( strlen( $post->post_title ) > 20 )
				$post->post_title = substr( $post->post_title, 0, 20 ) . '...';

			$this->set_pusher();

			if( $this->pusher !== false )
				$this->pusher->trigger( 'private-wp_pusher', 'client-publish_post', $post );
		}

		public function admin_menu () {
			add_options_page( 'WP Pusher Settings', 'WP Pusher', 'manage_options', 'wp-pusher', array( $this, 'settings_page' ) );
		}

		public function  settings_page () {
			include 'wp-pusher-settings.php';
		}

		public function wp_enqueue_scripts() {
			// jQuery
			if( !wp_script_is( 'jquery', 'enqueued' ) )
				wp_enqueue_script( 'jquery' );

			// Pusher
			if( !wp_script_is( 'pusher', 'registered' ) )
				wp_register_script( 'pusher', 'http://js.pusher.com/2.1/pusher.min.js', array(), $this->version, true );

			wp_enqueue_script( 'pusher' );

			// WP Pusher
			wp_register_script( 'wp-pusher', plugins_url( 'js/wp-pusher.js', __FILE__ ), array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'wp-pusher' );
			wp_localize_script( 'wp-pusher', 'wp_pusher', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'plugin_url' => plugins_url( '', __FILE__ ),
				'nonce' => wp_create_nonce( 'wp-pusher-nonce' ),
				'active' => ( isset( $this->options[ 'active' ] ) && $this->options[ 'active' ] ) ? $this->options[ 'active' ] : 0,
				'debug_js' => ( isset( $this->options[ 'debug_js' ] ) && $this->options[ 'debug_js' ] ) ? $this->options[ 'debug_js' ] : 0,
				'key' => isset( $this->options[ 'key' ] ) ? $this->options[ 'key' ] : '',
				'auth_endpoint' => plugins_url( 'wp-pusher-auth.php', __FILE__ )
			) );
			wp_register_style( 'wp-pusher-css', plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_style( 'wp-pusher-css' );
		}

		public function admin_enqueue_scripts() {
			// Pusher
			if( !wp_script_is( 'pusher', 'registered' ) )
				wp_register_script( 'pusher', 'http://js.pusher.com/2.1/pusher.min.js', array(), $this->version, true );

			wp_enqueue_script( 'pusher' );
		}

		public function pr( $die ) {
			echo "<pre>";
			print_r( $die );
			echo "</pre>";
			exit;
		}
	}

}

global $wp_pusher;
$wp_pusher = new WP_Pusher();