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
 * シンタックスハイライター
 * 投稿内で使用されてるショートコード用のスクリプトだけをロードする
 *---------------------------------------------------------------------------*/
if( function_exists('thk_highlighter_load') === false ):
function thk_highlighter_load( $loads, $list, $active ) {
	global $luxe, $post;

	foreach( $list as $key => $val ) {
		// has_shortcode() は使えないので strpos で探す
		if( isset( $luxe[$key] ) && strpos( $post->post_content, '[' . $key ) !== false ) {
			$active = true;
			break;
		}
	}
	if( $active === true ) {
		$jsdir  = TPATH . DSEP . 'js' . DSEP . 'prism' . DSEP;
		$cssdir = TPATH . DSEP . 'css' . DSEP . 'prism' . DSEP;

		if( !isset( $loads[1]['prism'] ) ) {
			$loads[0] .= thk_fgc( $jsdir . 'prism.js' );
			$loads[1]['prism'] = true;
		}

		// CSS
		if( isset( $luxe['highlighter_css'] ) && $luxe['highlighter_css'] !== 'none' ) {
			$highlighter_css = trim( thk_fgc( $cssdir . 'prism-' . $luxe['highlighter_css'] . '.min.css' ) );
			$highlighter_css .= 'pre[class*="language-"]{margin:20px 0 30px 0}';
			if( TDEL !== SDEL ) {
				wp_add_inline_style( 'luxech', $highlighter_css );
			}
			else {
				wp_add_inline_style( 'luxe', $highlighter_css );
			}
		}

		// Javascript
		foreach( $list as $key => $val ) {
			// has_shortcode() は使えないので strpos で探す
			if( isset( $luxe[$key] ) && strpos( $post->post_content, '[' . $key ) !== false ) {
				$lang = str_replace( 'highlight_', '', $key );

				if( !isset( $loads[1][$key] ) ) {
					/*
					 * 他言語の依存チェック
					*/
					// markup
					if(
						!isset( $loads[1]['markup'] ) &&
						( $lang === 'php' || $lang === 'aspnet' )
					) {
						$loads[0] .= thk_fgc( $jsdir . 'markup.js' );
						$loads[1]['markup'] = true;
					}
					// css
					if(
						!isset( $loads[1]['css'] ) &&
						( $lang === 'markup' || $lang === 'php' || $lang === 'aspnet' || $lang === 'sass' )
					) {
						$loads[0] .= thk_fgc( $jsdir . 'css.js' );
						$loads[1]['css'] = true;
					}
					// clike
					if(
						!isset( $loads[1]['clike'] ) &&
						( $lang === 'markup' || $lang === 'javascript' || $lang === 'java' || $lang === 'php' || $lang === 'aspnet' || $lang === 'c' || $lang === 'cpp' || $lang === 'csharp' || $lang === 'ruby' || $lang === 'nginx' )
					) {
						$loads[0] .= thk_fgc( $jsdir . 'clike.js' );
						$loads[1]['clike'] = true;
					}
					// javascript
					if(
						!isset( $loads[1]['javascript'] ) &&
						( $lang === 'markup' || $lang === 'php' || $lang === 'aspnet' )
					) {
						$loads[0] .= thk_fgc( $jsdir . 'javascript.js' );
						$loads[1]['javascript'] = true;
					}
					// c
					if(
						!isset( $loads[1]['c'] ) &&
						$lang === 'cpp'
					) {
						$loads[0] .= thk_fgc( $jsdir . 'c.js' );
						$loads[1]['c'] = true;
					}
					// basic
					if(
						!isset( $loads[1]['basic'] ) &&
						$lang === 'vbnet' 
					) {
						$loads[0] .= thk_fgc( $jsdir . 'basic.js' );
						$loads[1]['basic'] = true;
					}
					// sql
					if(
						!isset( $loads[1]['sql'] ) &&
						$lang === 'plsql' 
					) {
						$loads[0] .= thk_fgc( $jsdir . 'sql.js' );
						$loads[1]['sql'] = true;
					}

					// 言語ごとの読み込み
					$loads[0] .= thk_fgc( $jsdir . $lang . '.js' );
					$loads[1][$key] = true;
				}
			}
		}

		if( !isset( $loads[1]['options'] ) ) {
			$loads[0] .= thk_fgc( $jsdir . 'prism-options.js' );
			$loads[1]['options'] = true;
		}
	}
	return $loads;
}
endif;

/*---------------------------------------------------------------------------
 * サイトマップ用インラインスタイル
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_sitemap_inline_style' ) === false ):
function thk_sitemap_inline_style() {
	return <<< STYLE
#sitemap .sitemap-home {
	margin: 0 0 0 20px;
}
#sitemap ul {
	margin: 0 0 30px 0x;
}
#sitemap ul ul,
#sitemap ul ul ul,
#sitemap ul ul ul ul {
	margin: 0 0 0 3px;
	padding: 0;
}
#sitemap li {
	line-height: 1.7;
	margin-left: 10px;
	padding: 0 0 0 22px;
	border-left: 1px solid #000;
	list-style-type: none;
}
#sitemap li:before {
	content: "-----";
	font-size: 14px; font-size: 1.4rem;
	margin-left: -23px;
	margin-right: 12px;
	letter-spacing: -3px;
}
#sitemap .sitemap-home a,
#sitemap li a {
	text-decoration: none;
}
STYLE;
}
endif;

/*---------------------------------------------------------------------------
 * インラインスクリプトの読み込み
 *---------------------------------------------------------------------------*/
call_user_func( function() use( $_is_singular ) {
	global $luxe;

	// 検索結果のハイライト用インラインスタイル
	if( is_search() === true && isset( $luxe['search_highlight'] ) ) {
		if( isset( $luxe['child_css'] ) && TDEL !== SDEL ) {
			wp_add_inline_style( 'luxech', thk_search_highlight_inline_style() );
		}
		else {
			wp_add_inline_style( 'luxe', thk_search_highlight_inline_style() );
		}
	}

	// サイトマップ用インラインスタイル
	if( is_page_template( 'pages/sitemap.php' ) === true ) {
		if( isset( $luxe['child_css'] ) && TDEL !== SDEL ) {
			wp_add_inline_style( 'luxech', thk_sitemap_inline_style() );
		}
		else {
			wp_add_inline_style( 'luxe', thk_sitemap_inline_style() );
		}
	}

	// シンタックスハイライター
	$loads = array( '', array() );
	$highlighter_list = thk_syntax_highlighter_list();
	$highlighter_active = false;

	if( $_is_singular === true ) {
		$loads = thk_highlighter_load( $loads, $highlighter_list, $highlighter_active );
	}
	else {
		if( have_posts() === true ) {
			while( have_posts() === true ) {
				the_post();
				if(
					( isset( $luxe['list_view'] ) && $luxe['list_view'] === 'content' ) ||
					( isset( $luxe['sticky_no_excerpt'] ) && $luxe['sticky_no_excerpt'] && is_sticky() === true )
				) {
					$loads = thk_highlighter_load( $loads, $highlighter_list, $highlighter_active );
				}
			}
		}
	}

	if( !empty( $loads[0] ) ) {
		wp_enqueue_script( 'luxe-inline-script', TURI . '/js/thk-dummy.js', array( 'jquery' ), false );
		$loads[0] = '(function(){var jqueryCheck=function(b){if(window.jQuery){b(jQuery)}else{window.setTimeout(function(){jqueryCheck(b)},100)}};jqueryCheck(function(a){;' . "\n" . $loads[0] . '});}());';
		wp_add_inline_script( 'luxe-inline-script', $loads[0] );
	}
});

