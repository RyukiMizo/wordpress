<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 *   Plugin Name: AMP for Luxeritas WordPress Theme (MU)
 *   Plugin URI: https://thk.kanzae.net/wp/
 *   Description: AMP plugin for Luxeritas WordPress Theme.
 *   Author: LunaNuko
 *   Author URI: https://thk.kanzae.net/
 *   Text Domain: 
 *   License: GNU General Public License v2 or later
 *   License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *   Since: 20170510
 *   Modify: 20170510
 *   Version: 1.0.0
 */

class luxeritas_amp {
	public function __construct() {
	}

	/*---------------------------------------------------------------------------
	 * load plugins for AMP
	 *---------------------------------------------------------------------------*/
	public function load_plugins() {
		$_is_admin = is_admin();

		if( $_is_admin === false ) {
			$amp = false;

			if( stripos( $_SERVER['QUERY_STRING'], 'amp=1' ) !== false ) {
				$amp = true;
			}
			else {
				$uri = array_filter( explode( '/', $_SERVER['REQUEST_URI'] ) );
				$last_uri = end( $uri );
				if( $last_uri === 'amp' ) {
					$amp = true;
				}
			}

			if( $amp === false ) return false;
		}

		$curent = wp_get_theme();
		$parent = wp_get_theme( $curent->get('Template') );

		if( $parent->get('Name') === 'Luxeritas' ) {
			$mods = get_theme_mods();
			if( isset( $mods['amp_enable'] ) ) {
				if( $_is_admin === false ) {
					if( function_exists( 'get_plugins' ) === false ) {
						require_once ABSPATH . 'wp-admin/includes/plugin.php';
					}
					$all_plugins = get_plugins();
					$active_plugins = array();

					foreach( (array)$all_plugins as $key => $val ) {
						if( array_key_exists( 'amp_plugin_' . strlen( $key ) . '_' . md5( $key ), $mods ) ) {
							if( stripos( $key, 'wp-multibyte-patch' ) !== false ) {
								$active_plugins[] = $key;
							}
							elseif( in_array( $key, $active_plugins ) === false ) {
								$active_plugins[] = $key;
							}
						}
					}

					add_filter( 'pre_option_active_plugins', function() use( $active_plugins ) {
						return $active_plugins;
					}, 10, 1 );
				}
			}
			else {
				$this->self_delete();
			}
		}
		else {
			$this->self_delete();
		}
	}

	/*---------------------------------------------------------------------------
	 * filesystem
	 *---------------------------------------------------------------------------*/
	private function init_filesystem( $url = null ) {
		global $wp_filesystem;
		require_once( ABSPATH . 'wp-admin/includes/file.php' );

		if( $url === null ) {
			$url = wp_nonce_url( 'customize.php?return=' . urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
		}
		$creds = request_filesystem_credentials( $url, '', false, false, null );

		// Writable or Check
		if( false === ( $creds = request_filesystem_credentials( $url, '', false, false, null ) ) ) {
			return false;
		}
		// WP_Filesystem_Base init
		if( false === WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( $url, '', true, false, null );
			return false;
		}
		return;
	}

	/*---------------------------------------------------------------------------
	 * self delete
	 *---------------------------------------------------------------------------*/
	private function self_delete() {
		global $wp_filesystem;
		if( $this->init_filesystem( site_url() ) === false ) return false;

		if( file_exists( __FILE__ ) === true ) {
			if( $wp_filesystem->delete( __FILE__, false ) === false ) {
				// When it failed to delete itself
				add_action( 'admin_notices', function() {
					echo '<div class="notice notice-error is-dismissible"><p>';
					echo sprintf(
						__( 'File deletion failed. Please remove <code>%s</code>.', 'luxeritas' ),
						__FILE__
					);
					echo '</p></div>' . "\n";
				}, 10, 1 );
			}
		}
	}
}

$luxeritas_amp = new luxeritas_amp();
$luxeritas_amp->load_plugins();
unset( $luxeritas_amp );
