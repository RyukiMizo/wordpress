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
 *
 * This library has been developed on the basis of the Stinger5.
 */

/**
 * Stinger5 WordPress Theme
 * @link http://wp-fun.com
 * @author enji
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */

//---------------------------------------------------------------------------
// WordPress の投稿スラッグを自動的に生成する
//---------------------------------------------------------------------------
add_action( 'wp_unique_post_slug', function( $slug, $post_ID, $post_status, $post_type ) {
	global $luxe;
	// マルチバイト文字を許可する場合の処理追加
	if( isset( $luxe['enable_mb_slug'] ) ) {
		return $slug;
	}
	elseif( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
		$slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
	}
	return $slug;
}, 10, 4 );

//---------------------------------------------------------------------------
// セルフピンバック禁止
//---------------------------------------------------------------------------
add_action( 'pre_ping', function( &$links ) {
	$home = home_url();
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset( $links[$l] );
		}
	}
} );
