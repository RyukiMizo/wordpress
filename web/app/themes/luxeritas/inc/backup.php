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

// バックアップ時のヘッダー出力
if( $_POST['option_page'] === 'backup' ) {
	$mods = get_option( 'theme_mods_' . THEME );
	foreach( (array)$mods as $key => $val ) {
		if(
			is_array( $val )	||
			is_numeric( $key )	||
			$key === 'custom_css_post_id'
		) unset( $mods[$key] );
	}
	$json = json_encode( $mods );

	$admin_mods = get_theme_admin_mods();

	foreach( $admin_mods as $key => $val ) {
		if( is_array( $val ) ) unset( $admin_mods[$key] );
	}

	if( !empty( $admin_mods ) ) {
		$json .= "\n" . json_encode( $admin_mods );
	}
	else {
		$json .= "\n";
	}

	$phrase_mods = get_theme_phrase_mods();

	if( !empty( $phrase_mods ) ) {
		$json .= "\n" . json_encode( $phrase_mods );

		if( is_dir( SPATH . DSEP . 'shortcodes' . DSEP ) ) {
			require_once( INC . 'optimize.php' );
			global $wp_filesystem;

			$filesystem = new thk_filesystem();
			if( $filesystem->init_filesystem( site_url() ) === false ) return false;

			$phrase_dirs = glob( SPATH . DSEP . 'phrases' . DSEP . '*.txt' );
			foreach( (array)$phrase_dirs as $val ) {
				$file_name = basename( $val );
				$contents['phrases'][$file_name] = serialize( $wp_filesystem->get_contents( $val ) );
			}

			$shortcode_dirs = glob( SPATH . DSEP . 'shortcodes' . DSEP . '*.inc' );
			foreach( (array)$shortcode_dirs as $val ) {
				$file_name = basename( $val );
				$contents['shortcodes'][$file_name] = serialize( preg_replace( "/\r\n|\r|\n/", "\n", $wp_filesystem->get_contents( $val ) ) );
			}

			if( !empty( $contents['phrases'] ) && !empty( $contents['shortcodes'] ) ) {
				$json .= "\n" . json_encode( $contents );
			}
			else {
				$json .= "\n";
			}
		}
		else {
			$json .= "\n";
		}
	}
	else {
		$json .= "\n\n";
	}

	if( $json === false || $json === 'false' ) $json = '';
	$file = 'luxe-customize.json';
	@ob_start();
	@header( 'Content-Description: File Transfer' );
	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	@header( 'Content-Disposition: attachment; filename=' . basename( $file ) );
	echo $json;
	@ob_end_flush();
	//wp_send_json( $mods );
	exit;
}
// 外観デザインバックアップ時のヘッダー出力
if( $_POST['option_page'] === 'backup_appearance' ) {
	require( INC . 'appearance-settings.php' );
	$mods = get_option( 'theme_mods_' . THEME );
	foreach( (array)$mods as $key => $val ) {
		if(
			!isset( Appearance::$appearance[$key] )	||
			is_array( $val )			||
			is_numeric( $key )			||
			$key === 'custom_css_post_id'
		) unset( $mods[$key] );
	}
	$json = json_encode( $mods );
	if( $json === false || $json === 'false' ) $json = '';
	$file = 'luxe-appearance.json';
	@ob_start();
	@header( 'Content-Description: File Transfer' );
	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	@header( 'Content-Disposition: attachment; filename=' . basename( $file ) );
	echo $json;
	@ob_end_flush();
	//wp_send_json( $mods );
	exit;
}
// 子テーマバックアップ
if( $_POST['option_page'] === 'backup_child' ) {
	if( TPATH !== SPATH && class_exists('ZipArchive') === true ) {
		thk_zip_file_download( SPATH, basename( SPATH ) . '.zip' );
	}
}
