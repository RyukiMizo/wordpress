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
 * AMP の拡張スクリプトを読み込むかどうかを判定するグローバル変数の追加
 *---------------------------------------------------------------------------*/
global $luxe;

$content = '';
// 投稿内容
if( have_posts() === true ) {
	while( have_posts() === true ) {
		the_post();
		$content .= apply_filters( 'thk_content', '' );
	}
}

// ウィジェット類
$widgets = array(
	'head-under-amp',
	'post-title-upper-amp',
	'post-title-under-amp',
	'post-h2-upper-amp',
	'related-upper-amp',
	'related-under-amp',
	'post-under-1-amp',
	'post-under-2-amp',
	'side-amp',
);
foreach( $widgets as $val ) { $content .= thk_amp_dynamic_sidebar( $val ); }
unset( $widgets );

// AMP HTML ( body )
if( TPATH !== SPATH ) {
	$content .= thk_fgc( SPATH . DSEP . 'add-amp-body.php' );
}
else {
	$content .= thk_fgc( TPATH . DSEP . 'add-amp-body.php' );
}

// アナリティクス
require_once( INC . 'analytics.php' );
$analytics = new thk_analytics();
$content .= $analytics->analytics( 'add-analytics.php' );
$content .= $analytics->analytics( 'add-analytics-head.php' );

// AMP の拡張スクリプト が必要かどうかの判定
$amp_extensions = thk_amp_extensions();

// 必要となる AMP の拡張スクリプトがある場合、そのエクステンションのキーをグローバル変数に設定
foreach( $amp_extensions as $key => $val ) {
	if( stripos( $content, '<' . $key . ' ' ) !== false ) $luxe[$key] = true;
}
if( stripos( $content, '</form>' ) !== false ) $luxe['amp-form'] = true;

unset( $content, $amp_extensions );
