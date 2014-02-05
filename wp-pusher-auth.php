<?php
if( !class_exists( 'WP_Pusher_Auth' ) ) {

	class WP_Pusher_Auth {
		private $options;

		public function __construct() {
			define( 'WP_USE_THEMES', false );
			include_once dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php';

			$this->options = get_option( 'wp_pusher', false );

			if( $this->options !== false && $this->options[ 'key' ] !== '' && $this->options[ 'secret' ] !== '' && $this->options[ 'app_id' ] !== '' ) {
				include_once 'pusher-php-server/lib/Pusher.php';
				$pusher = new Pusher( $this->options[ 'key' ], $this->options[ 'secret' ], $this->options[ 'app_id' ] );

				echo $pusher->socket_auth( $_POST[ 'channel_name' ], $_POST[ 'socket_id' ] );
			}
		}
	}

}

$wp_pusher_auth = new WP_Pusher_Auth();