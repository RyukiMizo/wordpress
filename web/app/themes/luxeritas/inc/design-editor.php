<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

require_once( INC . 'optimize.php' );
global $luxe, $wp_filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

$file = '';
$title = '';
$title_sub = '';
$content = '';
$error = false;
$allowed_files = array();

$files = array(
	'design_style' => array(
		'style.css',
		__( 'Stylesheet', 'luxeritas' ),
		''
	),
	'design_amp' => array(
		'style-amp.css',
		__( 'Stylesheet for AMP', 'luxeritas' ),
		''
	),
);

$theme = wp_get_theme( get_stylesheet() );

if( current_user_can('edit_themes') === false ) {
	wp_die('<p>' . __( 'You do not have sufficient permissions to edit templates for this site.', 'luxeritas' ) . '</p>');
}
if( $theme->exists() === false ) {
	wp_die( __( 'The requested theme does not exist.', 'luxeritas' ) );
}
if( $theme->errors() && 'theme_no_stylesheet' == $theme->errors()->get_error_code() ) {
	wp_die( __( 'The requested theme does not exist.', 'luxeritas' ) . ' ' . $theme->errors()->get_error_message() );
}

if( TPATH !== SPATH ) {
	if( isset( $luxe['design_file'] ) ) {
		if( !isset( $_GET['active'] ) ) {
			$file = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . $files['edit_style'][0];
			$title = $files['edit_style'][1];
			$msg = $files['edit_style'][2];
		}
		else {
			foreach( $files as $key => $val ) {
				if( $_GET['active'] === $key ) {
					$file = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . $val[0];
					$title = $val[1];
					$msg = $val[2];
				}
			}
		}

		if( is_file( $file ) === true && file_exists( $file ) === true ) {
			$content = thk_convert( $wp_filesystem->get_contents( $file ) );
			$content = esc_textarea( $content );
		}
		else {
			$error = true;
		}

		$title_sub = str_replace( SPATH . DSEP . 'design' . DSEP, '', $file );
	}
	else {
		$title = '<span class="red">' . __( 'An editable design file is not activated', 'luxeritas' ) . '</span>';
		$title_sub = __( 'Please select design.', 'luxeritas' );
	}
}
else {
	$title = '<span class="red">' . __( 'The theme selected is not the child theme, but the parent theme', 'luxeritas' ) . '</span>';
	$title_sub = __( 'This feature can only be used when the child theme is selected.', 'luxeritas' );
}
?>
<h3><?php echo $title, '&nbsp;:<span class="normal">&nbsp;&nbsp;', $title_sub; ?></span></h3>
<?php
echo !empty( $msg ) ? '<p>' . $msg . '</p>' : '';

if( $theme->errors() ) {
	if( !get_settings_errors( 'luxe-custom' ) ) {
		echo '<div class="error"><p><strong>' . __( 'This theme is broken.', 'luxeritas' ) . '</strong> ' . $theme->errors()->get_error_message() . '</p></div>';
	}
}
if( $error ) {
	echo '<div class="error"><p>' . __( 'Oops, no such file exists! Double check the name and try again, merci.', 'luxeritas' ) . '</p></div>';
}
else {
	require( INC . 'codemirror.php' );
}
