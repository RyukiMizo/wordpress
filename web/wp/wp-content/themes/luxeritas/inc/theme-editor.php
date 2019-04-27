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
global $wp_filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

$file = '';
$title = '';
$title_sub = '';
$content = '';
$error = false;
$allowed_files = array();

$files = array(
	'edit_style' => array(
		'style.css',
		__( 'Stylesheet', 'luxeritas' ),
		'<span class="blue small">' . __( '* Deleting the original comment may malfunction to have the theme not work as the child theme.', 'luxeritas' ) . '</span>'
	),
	'edit_script' => array(
		'luxech.js',
		'Javascript',
		''
	),
	'edit_header' => array(
		'add-header.php',
		'Head ' . __(  'tag', 'luxeritas' ),
		'<span class="blue small">' . __( '* Write here the Sytle or Javascript which wants to be placed in the head tag.', 'luxeritas' ) . '</span>'
	),
	'edit_footer' => array(
		'add-footer.php',
		__( 'Footer', 'luxeritas' ),
		'<span class="blue small">' . __( '* Write here the Sytle or Javascript which wants to be placed in the footer.', 'luxeritas' ) . '</span>'
	),
	'edit_analytics' => array(
		'add-analytics.php',
		'Analytics ( body )',
		'<p class="blue small">' . __( '* When inserting the tracking code in &lt;body&gt; tag, please write it here.', 'luxeritas' ) . '</p>' .
		'<p class="blue small">' . __( '* Recommended to add Google Analytics code (analytics.js / ga.js) and other tracking code here.', 'luxeritas' ) . '</p>' .
			'<table style="background:#f5f5f5;border:1px solid #ccc"><tbody><tr style="vertical-aligin:top">' .
			'<td style="padding:6px">' . __( 'Tracking code position', 'luxeritas' ) . ' :</td>' .
			'<td style="padding:6px"><input type="radio" value="top" name="analytics_position"' . thk_value_check( 'analytics_position', 'radio', 'top', false ) . ' />' . sprintf( __( 'Top of %s', 'luxeritas' ), '&lt;body&gt;' ) . '</td>' .
			'<td style="padding:6px"><input type="radio" value="bottom" name="analytics_position"' . thk_value_check( 'analytics_position', 'radio', 'bottom', false ) . ' />' . sprintf( __( 'Bottom of %s', 'luxeritas' ), '&lt;body&gt;' ) . '</td>' .
			'</tr></tbody></table>'
	),
	'edit_analytics_head' => array(
		'add-analytics-head.php',
		'Analytics ( head )',
		'<p class="blue small">' . __( '* When inserting the tracking code in &lt;head&gt; tag, please write it here.', 'luxeritas' ) . '</p>' .
		'<span class="blue small">' . __( '* Recommended to add Google Analytics code (gtag.js) and other tracking code here.', 'luxeritas' ) . '</span>'
	),
	'edit_functions' => array(
		'functions.php',
		__( 'Child Theme Functions', 'luxeritas' ),
		'<span class="blue small">' . __( '* Miss writing the functions.php may lead to malfunctin of Wordpress, so be careful!!!', 'luxeritas' ) . '</span>'
	),
	'edit_amp_body' => array(
		'add-amp-body.php',
		'AMP HTML ( body )',
		'<p class="blue small">' . __( '* Please insert amp-auto-ads tag here when using Auto ads for AMP. The head tag script is unnecessary as it is automatically loaded.', 'luxeritas' ) . '</p>' .
			'<table style="background:#f5f5f5;border:1px solid #ccc"><tbody><tr style="vertical-aligin:top">' .
			'<td style="padding:6px">' . __( 'Insertion position', 'luxeritas' ) . ' :</td>' .
			'<td style="padding:6px"><input type="radio" value="top" name="amp_body_position"' . thk_value_check( 'amp_body_position', 'radio', 'top', false ) . ' />' . sprintf( __( 'Top of %s', 'luxeritas' ), '&lt;body&gt;' ) . '</td>' .
			'<td style="padding:6px"><input type="radio" value="bottom" name="amp_body_position"' . thk_value_check( 'amp_body_position', 'radio', 'bottom', false ) . ' />' . sprintf( __( 'Bottom of %s', 'luxeritas' ), '&lt;body&gt;' ) . '</td>' .
			'</tr></tbody></table>'
	),
	'edit_amp' => array(
		'style-amp.css',
		__( 'Stylesheet for AMP', 'luxeritas' ),
		''
	),
	'edit_visual' => array(
		'editor-style.css',
		__( 'Visual Editor', 'luxeritas' ),
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
	if( !isset( $_GET['active'] ) ) {
		$file = SPATH . DSEP . $files['edit_style'][0];
		$title = $files['edit_style'][1];
		$msg = $files['edit_style'][2];
	}
	else {
		foreach( $files as $key => $val ) {
			if( $_GET['active'] === $key ) {
				$file = SPATH . DSEP . $val[0];
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

	$title_sub = str_replace( SPATH . DSEP, '', $file );
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
