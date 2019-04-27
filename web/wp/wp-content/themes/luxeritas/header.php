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

global $luxe;

if( !isset( $content_width ) ) $content_width = 1280;	// これ無いとチェックで怒られる

$cls = '';
if( isset( $luxe['lazyload_thumbs'] ) || isset( $luxe['lazyload_contents'] ) || isset( $luxe['lazyload_sidebar'] ) || isset( $luxe['lazyload_footer'] ) ) {
	$cls = 'class="no-js" ';
}
?>
<!DOCTYPE html>
<html <?php echo isset( $luxe['amp'] ) ? 'amp ' : $cls; language_attributes(); ?> itemscope itemtype="https://schema.org/WebPage">
<?php
if( isset( $luxe['facebook_ogp_enable'] ) && !isset( $luxe['amp'] ) ) {
?>
<head prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# fb: http://ogp.me/ns/fb#">
<?php
}
else {
?>
<head>
<?php
}
?>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php
if( !isset( $luxe['amp'] ) ) {
?>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=<?php echo $luxe['user_scalable']; ?>" />
<?php
}
else {
?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
<?php
	$title = '';

	if( is_singular() === true ) {
		$addhead = get_post_meta( $post->ID, 'addhead', true );

		if( !empty( $addhead ) ) {
			if( stripos( $addhead, '<' . 'title>' ) !== false && stripos( $addhead, '</title' . '>' ) !== false ) {
				$title = esc_html( preg_replace( '/.*?<' . 'title>(.*?)<\/title' . '>.*/ism', '$1', $addhead ) );
			}
		}
	}

	if( empty( $title ) ) $title = wp_get_document_title();
	echo '<', 'title>', $title, '</', 'title>', "\n";
}

$_is_tag = is_tag();
$_is_archive = is_archive();
$_is_category = is_category();
$_is_singular = is_singular();

$noindex	= '';		// インデクスさせるかどうか
$next_index	= false;	// <!--!nextpage--> で分割してる場合の判別
$cpage = (int)get_query_var('cpage');	// コメントをページ分割してる場合の判別

// カスタマイズ画面で設定されている <!--nextpage--> の2ページ目以降のインデクス有無によって分岐
if( $_is_singular === true ) {
	// <!--!nextpage--> で分割してる場合の判別
	if(  isset( $luxe['nextpage_index'] ) ) {
		if( stripos( $post->post_content, '<!--nextpage-->' ) !== 0 ) {
			$paged = get_query_var('page');
			if( empty( $paged ) ) $paged = 1;
			if( $paged > 1 ) $next_index = true;
		}
	}

	$robots = get_post_meta( $post->ID, 'thk_robots', true );

	if( !empty( $robots ) || $next_index === true ) {
		$robots = explode( ',', $robots );
		if( $next_index === true ) {
			$noindex .= 'noindex,';
		}
		else {
			$noindex .= isset( $robots[0] ) && $robots[0] == 1 ? 'noindex,' : 'index,';
		}
		$noindex .= isset( $robots[1] ) && $robots[1] == 1 ? 'nofollow,' : 'follow,';

		if( $noindex === 'index,follow,' ) $noindex = '';

		$noindex .= isset( $robots[2] ) && $robots[2] == 1 ? 'noarchive,'    : '';
		$noindex .= isset( $robots[3] ) && $robots[3] == 1 ? 'noimageindex,' : '';
		$noindex = rtrim( $noindex, ',' );
	}

}
// カテゴリとタグのインデクス状態
if( isset( $luxe['category_or_tag_index'] ) ) {
	if(
		$_is_tag === true && $luxe['category_or_tag_index'] !== 'tag' ||
		$_is_category === true && $luxe['category_or_tag_index'] !== 'category'
	) {
		$noindex = 'noindex,follow';
	}
}

if(
	( $_is_archive === true && $_is_category === false && $_is_tag === false ) ||
	is_search()	=== true ||
	is_paged()	=== true ||
	is_404()	=== true ||
	$cpage > 0		 ||
	is_page_template( 'pages/sitemap.php' ) === true
) {
	$noindex = 'noindex,follow';
}

if( !empty( $noindex ) ) {
?>
<meta name="robots" content="<?php echo $noindex; ?>" />
<?php
}

echo apply_filters( 'thk_head', '' );	// load header

if( isset( $luxe['buffering_enable'] ) ) {
	thk_flash();
}

require( INC . 'json-ld.php' );
echo apply_filters( 'thk_json_ld', '' ); // load json-ld

if( !isset( $luxe['amp'] ) ) {
	// Intersection Observer
	if( isset( $luxe['lazyload_thumbs'] ) || isset( $luxe['lazyload_contents'] ) || isset( $luxe['lazyload_sidebar'] ) || isset( $luxe['lazyload_footer'] ) ) {
?>
<script><?php
		echo	'(function(html){html.className=html.className.replace(/\bno-js\b/,"js")})(document.documentElement);'
		,	thk_simple_css_minify( thk_fgc( TPATH . DSEP . 'js' . DSEP . 'lozad.min.js' ) . thk_fgc( TPATH . DSEP . 'js' . DSEP . 'thk-intersection-observer.min.js' ) );
?></script>
<?php
	}

	get_template_part('add-header'); // ユーザーヘッダー追加用

	// カスタムヘッダー
	if( $_is_singular === true ) {
		$addhead = get_post_meta( $post->ID, 'addhead', true );
		if( stripos( $addhead, '<' . 'title>' ) !== false && stripos( $addhead, '</title' . '>' ) !== false ) {
			$addhead = trim( preg_replace( '/(.*?)<' . 'title>.*?<\/title' . '>(.*)/im', '$1$2', $addhead ) );
			$addhead = str_replace( array( "\n\n", "\r\n\r\n" ), "\n", $addhead );
		}
		if( !empty( $addhead ) ) echo $addhead, "\n";
	}

}
?>
</head>
<body <?php body_class(); ?>>
<?php
require_once( INC . 'analytics.php' );
$analytics = new thk_analytics();

if( isset( $luxe['amp'] ) ) {
	/***
	 アクセス解析追加用( Headタグに設定されてる場合 )
	 ※ AMP の時はヘッダー内に置けないので body 直下配置
	 */
	echo $analytics->analytics( 'add-analytics-head.php' );

	// AMP HTML ( body )
	if( isset( $luxe['amp_body_position'] ) && $luxe['amp_body_position'] === 'top' ) {
		get_template_part( 'add-amp-body' );
	}
}
// アクセス解析追加用( Bodyタグ最上部に設定されてる場合 )
if( isset( $luxe['analytics_position'] ) && $luxe['analytics_position'] === 'top' ) {
	echo $analytics->analytics( 'add-analytics.php' );
}

// bootstrap container Inner
if( $luxe['bootstrap_header'] !== 'out' ) {
?>
<div class="container">
<?php
}
?>
<header id="header" itemscope itemtype="https://schema.org/WPHeader"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="banner"'; ?>>
<?php
// Global Navi Upper
if(
	( !isset( $luxe['global_navi_visible'] ) && isset( $luxe['head_band_visible'] ) ) ||
	( isset( $luxe['global_navi_visible'] ) && $luxe['global_navi_position'] === 'upper' )
) {
	get_template_part('navigation');
}

?>
<div id="head-in">
<div class="head-cover">
<div class="info" itemscope itemtype="https://schema.org/Website">
<?php
$_is_front_page = is_front_page();

if( $_is_front_page === true || ( $_is_archive === true && isset( $luxe['breadcrumb_view'] ) && $luxe['breadcrumb_view'] === 'none' ) ) {
	// フロントページは H1
?><h1 id="sitename"><a href="<?php echo THK_HOME_URL; ?>" itemprop="url"><?php
}
else {
?><p id="sitename"><a href="<?php echo THK_HOME_URL; ?>" itemprop="url"><?php
}

// One point logo Image
if( isset( $luxe['one_point_img'] ) ) {
	echo thk_create_srcset_img_tag( $luxe['one_point_img'], '', 'onepoint', true, false );
}

// Title Image
if( isset( $luxe['title_img'] ) ) {
	echo thk_create_srcset_img_tag( $luxe['title_img'], THK_SITENAME, null, true, false );
}
else {
	echo '<span itemprop="name about">', THK_SITENAME, '</span>';
}
?></a><?php
if( $_is_front_page === true || ( $_is_archive === true && isset( $luxe['breadcrumb_view'] ) && $luxe['breadcrumb_view'] === 'none' ) ) {
	// フロントページは H1 (閉じタグ)
?></h1>
<?php
}
else {
?></p>
<?php
}
if( isset( $luxe['title_img'] ) ) {
	echo '<meta itemprop="name about" content="', THK_SITENAME, '"></meta>';
}

// Catchphrase
if( isset( $luxe['header_catchphrase_visible'] ) ) {
?>
<p class="desc" itemprop="alternativeHeadline"><?php echo isset( $luxe['header_catchphrase_change'] ) ? $luxe['header_catchphrase_change'] : THK_DESCRIPTION; ?></p>
<?php
}
elseif( !empty( $luxe['header_catchphrase_change'] ) ) {
?>
<meta itemprop="alternativeHeadline" content="<?php echo $luxe['header_catchphrase_change']; ?>"></meta>
<?php
}
elseif( THK_DESCRIPTION !== '' ) {
?>
<meta itemprop="alternativeHeadline" content="<?php echo THK_DESCRIPTION; ?>"></meta>
<?php
}
?>
</div><!--/.info-->
<?php
// Logo Image
if( isset( $luxe['logo_img_up'] ) && isset( $luxe['logo_img'] ) ) {
	?><div class="logo<?php if( isset( $luxe['logo_img_up'] ) ) echo '-up'; ?>"><?php echo thk_create_srcset_img_tag( $luxe['logo_img'] ); ?></div>
<?php
}
?>
</div><!--/.head-cover-->
<?php
// Global Navi Under
if( isset( $luxe['global_navi_visible'] ) && $luxe['global_navi_position'] === 'under' ) {
	get_template_part('navigation');
}
?>
</div><!--/#head-in-->
<?php
// Logo Image
if( !isset( $luxe['logo_img_up'] ) && isset( $luxe['logo_img'] ) ) {
	?><div class="logo<?php if( isset( $luxe['logo_img_up'] ) ) echo '-up'; ?>"><?php echo thk_create_srcset_img_tag( $luxe['logo_img'] ); ?></div>
<?php
}
echo apply_filters( 'thk_header_under', '' );
?>
</header>
<?php
// bootstrap container Outer
if( $luxe['bootstrap_header'] === 'out' ) {
?>
<div class="container">
<?php
}

if( $luxe['breadcrumb_view'] === 'outer' ) get_template_part( 'breadcrumb' );

if( function_exists('dynamic_sidebar') === true ) {
	if( isset( $luxe['amp'] ) && is_active_sidebar('head-under-amp') === true ) {
		$amp_widget = thk_amp_dynamic_sidebar( 'head-under-amp' );
		if( !empty( $amp_widget ) ) echo $amp_widget;
	}
	elseif( !isset( $luxe['amp'] ) && is_active_sidebar('head-under') === true ) {
		dynamic_sidebar( 'head-under' );
	}
}

if( isset( $luxe['buffering_enable'] ) ) {
	thk_flash();
}

?>
<div id="primary" class="clearfix">
<?php
// 3 Column
if( $luxe['column_style'] === '3column' && !isset( $luxe['amp'] ) ) echo '<div id="field">', "\n";
?>
<main id="main"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="main"'; ?>>
