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

global $post;

$json = array();
$sc_mods = get_phrase_list( 'shortcode', true, true );

if( !empty( $sc_mods ) ) {
	foreach( (array)$sc_mods as $key => $val ) {
		// 投稿内に該当するショートコードが書かれてなければショートコードそのものを登録しない
		if( strpos( $post->post_content, '[' . $key ) !== false ) {
			// functions.php 等ですでに同名のショートコードが登録済みの場合も登録しない
			if( shortcode_exists( $key ) === false ) {
				$json = array( 'label' => '', 'php' => false, 'close' => false, 'hide' => false, 'active' => false );
				$json = wp_parse_args( @json_decode( $val ), $json );

				if( $json['active'] !== false && $json['hide'] === false ) {
					if( file_exists( SPATH . DSEP . 'shortcodes' . DSEP . $key . '.inc' ) ) {
						require( SPATH . DSEP . 'shortcodes' . DSEP . $key . '.inc' );
					}
				}
				// ショートコード非表示設定の時
				if( $json['hide'] !== false ) {
					add_filter( 'the_content', function( $content = null ) use( $key, $val ) {
						$content = preg_replace( '/\[' . $key . '[^\]]*?\].+?\[\/' . $key . '\]/ism', '', $content );
						$content = preg_replace( '/\[' . $key . '[^\]]*?\]/im', '', $content );
						return $content;
					}, 9 );
				}
			}
		}
	}

	// シンタックスハイライター用の特殊処理（wpautop を回避するために <p> や <br /> はハッシュ化する。表示する時に元に戻す）
	add_filter( 'the_content', function( $content ) {
		$highlighter_list = thk_syntax_highlighter_list();

		foreach( $highlighter_list as $key => $value ) {
			if( stripos( $content, '[/' . $key . ']' ) !== false ) {
				preg_match_all( '#\[' . $key . '\].+?\[/' . $key . '\]#ism', $content, $m );
				if( isset( $m[0] ) ) {
					foreach( (array)$m[0] as $val ) {
						$tmp = str_replace( '<br />', crc32( '<br />' ), $val );
						$tmp = str_replace( '<p>', crc32( '<p>' ), $tmp );
						$tmp = str_replace( '</p>', crc32( '</p>' ), $tmp );
						$content = str_replace( $val, $tmp, $content );
					}
				}
			}
		}
		return $content;
	}, 1 );
}
