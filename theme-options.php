<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'piraten_options', 'piraten_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */
$select_options = array(
	'0' => array(
		'value' =>	'0',
		'label' => __( 'Zero' )
	),
	'1' => array(
		'value' =>	'1',
		'label' => __( 'One' )
	),
	'2' => array(
		'value' => '2',
		'label' => __( 'Two' )
	),
	'3' => array(
		'value' => '3',
		'label' => __( 'Three' )
	),
	'4' => array(
		'value' => '4',
		'label' => __( 'Four' )
	),
	'5' => array(
		'value' => '3',
		'label' => __( 'Five' )
	)
);

$radio_options = array(
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Yes' )
	),
	'no' => array(
		'value' => 'no',
		'label' => __( 'No' )
	),
	'maybe' => array(
		'value' => 'maybe',
		'label' => __( 'Maybe' )
	)
);

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'piraten_options' ); ?>
			<?php $options = get_option( 'piraten_theme_options' ); ?>

			<table class="form-table">

				<?php
				/**
				 * show wanted field or not?
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Anzeigen' ); ?></th>
					<td>
						<input id="piraten_theme_options[show]" name="piraten_theme_options[show]" type="checkbox" value="1" <?php checked( '1', $options['show'] ); ?> />
						<label class="description" for="piraten_theme_options[show]"><?php _e( 'Steckbrief anzeigen.' ); ?></label>
					</td>
				</tr>
				
				<?php
				/**
				 * Name input 
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Name' ); ?></th>
					<td>
						<input id="piraten_theme_options[name]" class="regular-text" type="text" name="piraten_theme_options[name]" value="<?php esc_attr_e( $options['name'] ); ?>" />
						<label class="description" for="piraten_theme_options[name]"><?php _e( 'Name des Kandidaten' ); ?></label>
					</td>
				</tr>

				<?php
                                /**                                 
				 * Kandidatur input
                                 */
                                ?>
                                <tr valign="top"><th scope="row"><?php _e( 'Kandidatur' ); ?></th>
                                        <td>                                                <input id="piraten_theme_options[kandidatur]" class="regular-text" type="text" name="piraten_theme_options[kandidatur]" value="<?php esc_attr_e( $options['kandidatur'] ); ?>" />
                                                <label class="description" for="piraten_theme_options[kandidatur]"><?php _e( 'Genaue Beschreibung der Kandidatur' ); ?></label>
                                        </td>
                                </tr>

				<?php
                                /**                                 
				 * politics input
                                 */
                                ?>
                                <tr valign="top"><th scope="row"><?php _e( 'Politischer Schwerpunkt' ); ?></th>
                                        <td>                                                <input id="piraten_theme_options[politik]" class="regular-text" type="text" name="piraten_theme_options[politik]" value="<?php esc_attr_e( $options['politik'] ); ?>" />
                                                <label class="description" for="piraten_theme_options[name]"><?php _e( 'Politische Themenfelder und Prioritäten' ); ?></label>
                                        </td>
                                </tr>

				<?php
				/**
				 * biographic info
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Kurzbio' ); ?></th>
					<td>
						<textarea id="piraten_theme_options[bio]" class="large-text" cols="50" rows="10" name="piraten_theme_options[bio]"><?php echo stripslashes( $options['bio'] ); ?></textarea>
						<label class="description" for="piraten_theme_options[bio]"><?php _e( 'Eine kurze Beschreibung zur Person und Biographie.' ); ?></label>
					</td>
				</tr>

                                <?php
                                /**
                                 * picture-url input
                                 */
                                ?>
                                <tr valign="top"><th scope="row"><?php _e( 'Profilbild-URL' ); ?></th>
                                        <td>                                                <input id="piraten_theme_options[purl]" class="regular-text" type="text" name="piraten_theme_options[purl]" value="<?php esc_attr_e( $options['purl'] ); ?>" />
                                                <label class="description" for="piraten_theme_options[purl]"><?php _e( 'Vollständige Adresse des Profilbildes. (Die Größe des Bildes wird auf 175px (Höhe) und 150px (Breite) beschränkt.' ); ?></label>
                                        </td>
                                </tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['show'] ) )
		$input['show'] = null;
	$input['show'] = ( $input['show'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['name'] = wp_filter_nohtml_kses( $input['name'] );
	$input['politik'] = wp_filter_nohtml_kses( $input['politik'] );
	$input['kandidatur'] = wp_filter_nohtml_kses( $input['kandidatur'] );


	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['bio'] = wp_filter_post_kses( $input['bio'] );

	return $input;
}

