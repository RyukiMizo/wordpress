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

/*---------------------------------------------------------------------------
 * thk_phrase_regist
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_phrase_regist' ) === false ):
function thk_phrase_regist( $regist_name, $code_text, $code_close = false, $code_text_close = '', $new_or_edit = 'new' ) {
	global $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$ret = false;
	$phrases_dir = SPATH . DSEP . 'phrases' . DSEP;
	$regist_file = strlen( $regist_name ) . '-' . md5( $regist_name );

	// 登録済みのラベルかをチェック
	if( $ret !== true && $new_or_edit === 'new' ) {
		$registed = get_theme_phrase_mods();

		if( isset( $registed['fp-' . $regist_name] ) ) {
			add_settings_error( 'luxe-custom', $_POST['option_page'], sprintf( '[' . $regist_name . '] ' . __( 'This %s has already been registered.', 'luxeritas' ), __( 'label', 'luxeritas' ) ), 'error' );
			$ret = true;
		}
		unset( $registed );
	}

	if( $ret !== true ) {
		if( ( !empty( $code_text ) && $code_text != 1 ) || ( $code_close === true && !empty( $code_text_close ) && $code_text_close != 1 ) ) {
			if( $wp_filesystem->is_dir( $phrases_dir ) === false ) {
				// ディレクトリが存在しなかったら作成
				if( wp_mkdir_p( $phrases_dir ) === false ) {
					if( $wp_filesystem->mkdir( $phrases_dir, FS_CHMOD_DIR ) === false && $wp_filesystem->is_dir( $phrases_dir ) === false ) {
						add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Could not create directory.', 'luxeritas' ), 'error' );
						$ret = true;
					}
				}
			}
			if( wp_is_writable( $phrases_dir ) === true ) {
				if( $code_close === true && !empty( $code_text_close ) && $code_text_close != 1 ) {
					$code_text .= "\n<!--" . $regist_file . "-->\n" . $code_text_close;
				}

				$code_text = preg_replace( "/\r\n|\r|\n/", "\n", $code_text );

				if( $filesystem->file_save( $phrases_dir . $regist_file . '.txt', $code_text ) === false ) {
					// ファイル保存失敗
					add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Error saving file.', 'luxeritas' ), 'error' );
					$ret = true;
				}
			}
			else {
				// ディレクトリの書き込み権限がない
				add_settings_error( 'luxe-custom', $_POST['option_page'],
					__( 'You do not have permission to create and save files.', 'luxeritas' ) .
					__( 'Please check the owner and permissions of the following file or directory.', 'luxeritas' ) . '<br />' . $phrases_dir . $regist_file . '.txt'
				, 'error' );
				$ret = true;
			}
		}
		else {
			if( file_exists( $phrases_dir . $regist_file . '.txt' ) === true ) {
				$wp_filesystem->delete( $phrases_dir . $regist_file . '.txt' );
			}
		}

		if( $ret === false ) {
			if( set_theme_phrase_mod( 'fp-' . $regist_name, json_encode( array( 'close' => $code_close ) ) ) === false ) {
				$ret = true;
			}
		}
	}
	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * conditional execution
 *---------------------------------------------------------------------------*/
$_POST = stripslashes_deep( $_POST );

require_once( INC . 'optimize.php' );
global $wp_filesystem, $filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

if( isset( $_FILES['add-file-phrase']['name'] ) && isset( $_FILES['add-file-phrase']['tmp_name'] ) ) {
	$json_file = $_FILES['add-file-phrase']['tmp_name'];
	$json = $wp_filesystem->get_contents( $json_file );
	$a = (array)@json_decode( $json );

	if( !empty( $a ) ) {
		foreach( $a as $key => $val ) {
			$regist_name = $key;
			$code_text   = unserialize( $val );
			$code_close  = false;

			$sep = "\n<!--" . strlen( $regist_name ) . '-' . md5( $regist_name ) . "-->\n";
			if( strpos( $code_text, $sep ) !== false ) {
				$code_close = true;
			}

			break;
		}
		$err = thk_phrase_regist( $regist_name, $code_text, $code_close );
	}
}
elseif( isset( $_POST['code_save'] ) && isset( $_POST['code_save_item'] ) ) {
	$save = trim( esc_attr( stripslashes( $_POST['code_save_item'] ) ) );
	$save_file = substr( $save, strpos( $save, '-' ), strlen( $save ) );
	$save_file = strlen( $save_file ) . '-' . md5( $save_file );

	$contents = '';

	if( file_exists( SPATH . DSEP . 'phrases' . DSEP . $save_file . '.txt' ) === true ) {
		$contents = $wp_filesystem->get_contents( SPATH . DSEP . 'phrases' . DSEP . $save_file . '.txt' );
	}

	$json = json_encode( array( $save => serialize( preg_replace( "/\r\n|\r|\n/", "\n", $contents ) ) ) );

	//$file = $_POST['code_save_item'] . '.json';
	$file = str_replace( array( '.', ',', '"', '/', '\\', '[', ']', ':', ';', '|', '=' ), '', $_POST['code_save_item'] ) . '.json';
	@ob_start();
	@header( 'Content-Description: File Transfer' );
	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	@header( 'Content-Disposition: attachment; filename=' . $file );
	echo $json;
	@ob_end_flush();
	exit;
}
elseif( isset( $_POST['code_delete'] ) && isset( $_POST['code_delete_item'] ) ) {
	$del = trim( esc_attr( stripslashes( $_POST['code_delete_item'] ) ) );
	$file_del = substr( $del, strpos( $del, '-' ), strlen( $del ) );
	$file_del = strlen( $file_del ) . '-' . md5( $file_del );

	remove_theme_phrase_mod( 'fp-' . $del );

	if( file_exists( SPATH . DSEP . 'phrases' . DSEP . $file_del . '.txt' ) === true ) {
		$wp_filesystem->delete( SPATH . DSEP . 'phrases' . DSEP . $file_del . '.txt' );
	}
}
else {
	if( isset( $_POST['code_name'] ) ) {
		$regist_name = trim( esc_attr( $_POST['code_name'] ) );
		$code_text = isset( $_POST['code_text'] ) ? $_POST['code_text'] : '';
		$code_close = false;
		$code_text_close = '';

		if( isset( $_POST['code_close'] ) ) {
			$code_close = true;
			$code_text_close = isset( $_POST['code_text_close'] ) ? $_POST['code_text_close'] : '';
		}
		$new_or_edit = isset( $_POST['code_new'] ) && $_POST['code_new'] == 1 ? 'new' : 'edit';

		$err = thk_phrase_regist( $regist_name, $code_text, $code_close, $code_text_close, $new_or_edit );
	}
}
