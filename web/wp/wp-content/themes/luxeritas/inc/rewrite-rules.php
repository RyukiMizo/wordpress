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
 * 以下のアクションが発生した時、AMP が有効な設定なら AMP のリライトルール追加
 *  1. カスタマイザーの「Head タグ」の設定変更
 *  2. テーマ有効化
 *  3. WordPress アップグレード
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_add_endpoint' ) === false ):
function thk_add_endpoint() {
	global $wp_rewrite;

	$amp_enable = false;

	if( isset( $_POST['option_page'] ) && isset( $_POST['amp_enable'] ) ) {
		$amp_enable = true;
	}
	elseif( !isset( $_POST['option_page'] ) && get_theme_mod( 'amp_enable', false ) === true ) {
		$amp_enable = true;
	}

	if( $amp_enable === true ) {
		add_rewrite_endpoint( 'amp', EP_PERMALINK | EP_PAGES );
		add_rewrite_rule( '^amp/?', 'index.php?page_id=' . get_option('page_on_front'), 'top' );
   		$wp_rewrite->flush_rules( false );
	}
	else {
   		$wp_rewrite->flush_rules();
	}
}
add_action( 'after_switch_theme', 'thk_add_endpoint' );
endif;
