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

if( function_exists( 'thk_phrase_files_restore' ) === false ):
function thk_phrase_files_restore( $code, $json_phrase_file ) {
	if( !empty( $json_phrase_file[$code] ) ) {
		require_once( INC . 'optimize.php' );
		global $wp_filesystem;

		$filesystem = new thk_filesystem();
		if( $filesystem->init_filesystem( site_url() ) === false ) return false;

		$code_dir = SPATH . DSEP . $code . DSEP;

		if( $wp_filesystem->is_dir( $code_dir ) === false ) {
			// ディレクトリが存在しなかったら作成
			if( wp_mkdir_p( $code_dir ) === false ) {
				if( $wp_filesystem->mkdir( $code_dir, FS_CHMOD_DIR ) === false && $wp_filesystem->is_dir( $code_dir ) === false ) {
					add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Could not create directory.', 'luxeritas' ), 'error' );
				}
			}
		}

		foreach( $json_phrase_file[$code] as $key => $val ) {
			if( wp_is_writable( $code_dir . $key ) === true ) {
				$code_text = preg_replace( "/\r\n|\r|\n/", "\n", unserialize( $val ) );

				if( $filesystem->file_save( $code_dir . $key, $code_text ) === false ) {
					// ファイル保存失敗
					add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Error saving file.', 'luxeritas' ), 'error' );
				}
			}
			else {
				// ディレクトリの書き込み権限がない
				add_settings_error( 'luxe-custom', $_POST['option_page'],
					__( 'You do not have permission to create and save files.', 'luxeritas' ) .
					__( 'Please check the owner and permissions of the following file or directory.', 'luxeritas' ) . '<br />' . $code_dir . $key
				, 'error' );
			}
		}
	}
}
endif;

$files_key = $_POST['option_page'] === 'restore' ? 'luxe-restore' : 'luxe-restore-appearance';

if( isset( $_FILES[$files_key] ) ) {
	require_once( INC . 'optimize.php' );
	global $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$json_file = $_FILES[$files_key]['tmp_name'];
	$file_type = $_FILES[$files_key]['type'];

	// ファイルが zip だったら解凍を試みる（解凍できないなら放置してそのまま json_decode のエラー出力に任せる）
	if( stripos( $file_type, '/zip' ) !== false || stripos( $file_type, '/x-zip' ) !== false || stripos( $file_type, '/octet-stream' ) !== false ) {
		//$temp_dir = sys_get_temp_dir() . DSEP . 'luxe-' . time();
		$temp_dir = get_temp_dir() . DSEP . 'luxe-' . time();

		if( $wp_filesystem->mkdir( $temp_dir ) === true ) {
			unzip_file( $json_file, $temp_dir );
		}
		foreach( (array)glob( $temp_dir . DSEP . '*.json' ) as $val ) {
			if( is_file( $val ) === true ) {
				$json_file = $val;
				break;
			}
		}
	}

	$jsons = $wp_filesystem->get_contents( $json_file );
	$jsons = explode( "\n", $jsons );
	$json = array();
	$json_admin = array();
	$json_phrase = array();
	$json_phrase_file = array();

	if( !empty( $jsons[0] ) ) {
		$json = (array)@json_decode( $jsons[0] );
		foreach( $json as $key => $val ) {
			if( is_array( $val ) ) unset( $json[$key] );
		}
	}
	if( !empty( $jsons[1] ) ) {
		$json_admin = (array)@json_decode( $jsons[1] );
		foreach( $json_admin as $key => $val ) {
			if( is_array( $val ) ) unset( $json_admin[$key] );
		}
	}
	if( !empty( $jsons[2] ) ) {
		$json_phrase = (array)@json_decode( $jsons[2] );
	}
	if( !empty( $jsons[3] ) ) {
		$json_phrase_file = (array)@json_decode( $jsons[3] );
	}

	$json_error = json_error_code_to_msg( json_last_error() );

	if( isset( $temp_dir ) && $wp_filesystem->is_dir( $temp_dir ) === true ) {
		$wp_filesystem->delete( $temp_dir, true );
	}

	if( $json_error === JSON_ERROR_NONE ) {
		$i = 0;

		if( $_POST['option_page'] === 'restore' ) {
			remove_theme_mods();
			foreach( (array)$json as $key => $val ) {
				if( array_key_exists( $key, $luxe_defaults ) && $luxe_defaults[$key] != $val ) {
					set_theme_mod( $key, $val );
					++$i;
				}
			}
			foreach( (array)$json_admin as $key => $val ) {
				set_theme_admin_mod( $key, $val );
				++$i;
			}
			foreach( (array)$json_phrase as $key => $val ) {
				set_theme_phrase_mod( $key, $val );
				++$i;
			}
		}
		else {
			require( INC . 'appearance-settings.php' );
			foreach( Appearance::$appearance as $key => $val ) {
				remove_theme_mod( $key );
				if( isset( $json[$key] ) ) {
					set_theme_mod( $key, $json[$key] );
					++$i;
				}
			}
		}

		thk_phrase_files_restore( 'phrases', $json_phrase_file, $err );
		thk_phrase_files_restore( 'shortcodes', $json_phrase_file, $err );

		add_settings_error( 'luxe-custom', $_POST['option_page'],  sprintf( __( 'Restored %s settings', 'luxeritas' ), $i ), 'updated' );
	}
	else {
		add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Restore failed', 'luxeritas' ) . $json_error, 'error' );
	}
}
else {
	add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Not file selected', 'luxeritas' ) . $json_error, 'error' );
}
$err = true;
