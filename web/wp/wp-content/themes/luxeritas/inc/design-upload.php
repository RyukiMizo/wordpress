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

if( isset( $_FILES['design-upload'] ) ) {
	require_once( INC . 'optimize.php' );
	global $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$zip_file = wp_handle_upload( $_FILES['design-upload'], array( 'test_form' => false ) );
	$zip_name = '';
	$appearance_file = 'luxe-appearance.json';

	if( isset( $zip_file['error'] ) ) {
		add_settings_error( 'luxe-custom', $_POST['option_page'], $zip_file['error'], 'error' );
	}
	else {
		if( class_exists( 'ZipArchive' ) === true ) {
			$z = new ZipArchive();
			$zopen = $z->open( $zip_file['file'], ZIPARCHIVE::CHECKCONS );

			$stat_index_first = $z->statIndex(0);	// index の最初
			$style_ok = false;
			$appearance_ok = false;

			for ( $i = 0; $i < $z->numFiles; $i++ ) {
				$stat_index = $z->statIndex($i);

				// アーカイブの最初にディレクトリ以外のファイルが含まれてたら不正なファイル
				// アーカイブの最初にディレクトリが２つ以上あったら不正なファイル
				if(
					strpos( $stat_index['name'], '/' ) === false ||
					( $i > 0 && strpos( $stat_index['name'], $stat_index_first['name'] ) === false )
				) {
					add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Invalid file', 'luxeritas' ) . ': ' . $_FILES['design-upload']['name'], 'error' );
					$err = true;
					break;
				}

				// スタイルシートが含まれてるかどうか
				if( $stat_index['name'] === $stat_index_first['name'] . 'style.css' ) {
					$style_ok = true;
				}

				// 外観カスタマイズ用 JSON ファイルが含まれてるかどうか
				if( $stat_index['name'] === $stat_index_first['name'] . $appearance_file ) {
					$appearance_ok = true;
				}
			}

			if( $style_ok === false ) {
				add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Stylesheets were not included', 'luxeritas' ) . ': ' . $_FILES['design-upload']['name'], 'error' );
				$err = true;
			}

			if( $appearance_ok === false ) {
				add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'File for customization were not included', 'luxeritas' ) . ': ' . $_FILES['design-upload']['name'], 'error' );
				$err = true;
			}

			$zip_name = rtrim( $stat_index_first['name'], '/' );
			$z->close();
			unset( $z );
		}
		else {
			// ZipArchive が使えない場合の臨時処理
			// 使えるファイル名は英数 - _
			$zip_name = preg_replace( '/(.+)(\.[^.]+$)/', '$1', basename( $zip_file['file'] ) );
			if( preg_match( '/^[0-9a-zA-Z-_]+$/i', $zip_name ) != 0 ) {
				add_settings_error( 'luxe-custom', $_POST['option_page'], 'The only file names you can use are alphanumeric characters, hyphens, and underscores.', 'error' );
				$err = true;
			}
		}

		if( $err === false ) {
			if( stripos( $zip_file['type'], '/zip' ) !== false || stripos( $zip_file['type'], '/x-zip' ) !== false || stripos( $zip_file['type'], '/octet-stream' ) !== false ) {
				$design_dir = SPATH . DSEP . 'design' . DSEP;

				// 同一ディレクトリ(ファイル)があるかの判定
				if( file_exists( $design_dir . $zip_name ) === false ) {
					// 解凍
					$unzip_error = unzip_file( $zip_file['file'], $design_dir );

					// 解凍失敗
					if( is_wp_error( $unzip_error ) ) {
						if( isset( $unzip_error->errors ) ) {
							foreach( (array)$unzip_error->errors as $value ) {
								foreach( (array)$value as $key => $val ) {
									add_settings_error( 'luxe-custom', $_POST['option_page'], 'unzip failure: ' . $val, 'error' );
								}
							}
						}
						else {
							add_settings_error( 'luxe-custom', $_POST['option_page'], 'unzip failure', 'error' );
						}
						$err = true;
					}
				}
				else {
					add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Directory with the same name already exists.', 'luxeritas' ), 'error' );
					$err = true;
				}

				// NULL チェック（スタイルシートや JSON ファイルが ASCII かどうかの確認）
				// NULL が含まれてたら、疑わしいファイルとしてインストール中断（というか削除）
				if( $err === false ) {
					$null_check = (array)glob( $design_dir . $zip_name . '/' . '*.css' );
					$null_check[] = $design_dir . $zip_name . '/' . $appearance_file;

					foreach( $null_check as $val ) {
						$css = $wp_filesystem->get_contents( $val );
						if( stripos( $css, null ) !== false ) {
							add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Installation suspended because a suspicious file was found.', 'luxeritas' ), 'error' );
							$err = true;

							$wp_filesystem->delete( $design_dir . $zip_name, true );
							break;
						}
					}
				}
			}
		}
		$wp_filesystem->delete( $zip_file['file'] );
	}
}
