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

define( 'PHP_LEAST_VER', '5.4' );
define( 'WP_LEAST_VER', '4.4' );

load_theme_textdomain( 'luxeritas', TPATH . DSEP . 'languages' . DSEP . 'admin' );

$msg = array(
	'php' => sprintf( __( 'Luxeritas requires at least %s version %s. You are running version %s. Please upgrade and try again.', 'luxeritas' ), 'PHP', PHP_LEAST_VER, PHP_VERSION ),
	'wp'  => sprintf( __( 'Luxeritas requires at least %s version %s. You are running version %s. Please upgrade and try again.', 'luxeritas' ), 'WordPress', WP_LEAST_VER, $GLOBALS['wp_version'] ),
);

function thk_after_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'thk_upgrade_notice' );
}
add_action( 'after_switch_theme', 'thk_after_switch_theme' );

function thk_load_customize() {
	global $msg;

	if( version_compare( PHP_VERSION, PHP_LEAST_VER, '<' ) ) {
		wp_die( $msg['php'], '', array( 'back_link' => true ) );
	}
	else {
		wp_die( $msg['wp'], '', array( 'back_link' => true ) );
	}
}
add_action( 'load-customize.php', 'thk_load_customize' );

function thk_preview() {
	global $msg;

	if ( isset( $_GET['preview'] ) ) {
		if( version_compare( PHP_VERSION, PHP_LEAST_VER, '<' ) ) {
			wp_die( $msg['php'], '', array( 'back_link' => true ) );
		}
		else {
			wp_die( $msg['wp'], '', array( 'back_link' => true ) );
		}
	}
}
add_action( 'template_redirect', 'thk_preview' );

function thk_upgrade_notice() {
	global $msg;
	$message = '';

	if( version_compare( PHP_VERSION, PHP_LEAST_VER, '<' ) ) {
		$message = $msg['php'];
	}
	else {
		$message = $msg['wp'];
	}

	printf( '<div class="error"><p>%s</p></div>', $message );
}
