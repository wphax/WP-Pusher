<?php
if( isset( $_POST[ 'wp_pusher' ] ) )
	update_option( 'wp_pusher', $_POST[ 'wp_pusher' ] );
?>
<div class="wrap">

	<h2>WP Pusher</h2>

	<form action="" method="post">
		<p>
			Enter your app credentials for <a href="http://pusher.com">Pusher</a> and we'll take care of the rest!<br/>
			If these details are all filled out and correct, the plugin should start working immediately.
		</p>

		<table class="form-table">
			<tbody>

				<?php
				$saved = get_option( 'wp_pusher', '' );
				$options = array(
					'active' => array(
						'label' => 'Pusher Status',
						'type' => 'select',
						'options' => array(
							'0' => 'Inactive',
							'1' => 'Active'
						),
						'value' => isset( $saved[ 'active' ] ) ? $saved[ 'active' ] : 0
					),
					'app_id' => array(
						'label' => 'App ID',
						'value' => isset( $saved[ 'app_id' ] ) ? $saved[ 'app_id' ] : ''
					),
					'key' => array(
						'label' => 'Key',
						'value' => isset( $saved[ 'key' ] ) ? $saved[ 'key' ] : ''
					),
					'secret' => array(
						'label' => 'Secret',
						'value' => isset( $saved[ 'secret' ] ) ? $saved[ 'secret' ] : ''
					),
					'debug_js' => array(
						'label' => 'Debug Javascript',
						'type' => 'select',
						'options' => array(
							'0' => 'Inactive',
							'1' => 'Active'
						),
						'value' => isset( $saved[ 'debug_js' ] ) ? $saved[ 'debug_js' ] : 0
					)
				);

				foreach( $options as $key => $settings ) {
					if( !isset( $settings[ 'type' ] ) )
						$settings[ 'type' ] = 'text';
				?>
				<tr valign="top">
					<th scope="row">
						<label for="wp_pusher-<?php echo $key; ?>"><?php echo $settings[ 'label' ]; ?></label>
					</th>
					<td>
						<?php
						global $wp_pusher;
						switch( $settings[ 'type' ] ) {
							case 'select':
								echo '<select name="wp_pusher[' . $key . ']" id="wp_pusher-' . $key . '">';
								foreach( $settings[ 'options' ] as $opt_key => $opt_value ) {
									$selected = $settings[ 'value' ] == $opt_key ? 'selected="selected"' : '';
									echo '<option value="' . $opt_key . '" ' . $selected . '>' . $opt_value . '</option>';
								}
								echo '</select>';
								break;
							default:
								echo '<input name="wp_pusher[' . $key . ']" type="text" id="wp_pusher-' . $key . '" value="' . $settings[ 'value' ]. '" class="regular-text">';
						}
						?>
					</td>
				</tr>
				<?php }	?>

			</tbody>
		</table>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>

</div>