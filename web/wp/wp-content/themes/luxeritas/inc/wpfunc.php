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
 * default set
 *---------------------------------------------------------------------------*/
if( function_exists('thk_default_set') === false ):
function thk_default_set() {
	require_once( INC . 'defaults.php' );
	$conf = new defConfig();
	$conf->set_luxe_variable();
}
endif;

/*---------------------------------------------------------------------------
 * CSS / Javascript の圧縮・結合で必要なファイルのインクルード
 * 条件によって、load header でもインクルードするので関数化
 *---------------------------------------------------------------------------*/
if( function_exists('thk_regenerate_files') === false ):
function thk_regenerate_files( $shutdown = false, $require_only = false ) {
	require( INC . 'custom-css.php' );
	require( INC . 'compress.php' );

	if( $require_only === true ) {
		return;
	}

	if( $shutdown === false ) {
		thk_compress();
		thk_parent_css_bind();
		thk_child_js_comp();
		thk_create_inline_style();
		thk_empty_remove();
	}
	else {
		add_filter( 'shutdown', 'thk_compress', 75 );
		add_filter( 'shutdown', 'thk_parent_css_bind', 80 );
		add_filter( 'shutdown', 'thk_child_js_comp', 80 );
		add_filter( 'shutdown', 'thk_create_inline_style', 85 );
		add_filter( 'shutdown', 'thk_empty_remove', 90 );
	}
}
endif;

/*---------------------------------------------------------------------------
 * タイトル修正
 *---------------------------------------------------------------------------*/
if( function_exists('thk_title_separator') === false ):
function thk_title_separator( $sep ) {
	global $luxe;
	$sep = isset( $luxe['title_sep'] ) && $luxe['title_sep'] === 'hyphen' ? '-' : '|';
	return $sep;
}
add_filter( 'document_title_separator', 'thk_title_separator' );
endif;

add_filter( 'document_title_parts', function( $title ) {
	global $luxe;
	$ret = $title;

	/* Memo: https://developer.wordpress.org/reference/hooks/document_title_parts/
	 *
	 * $title (array) The document title parts.
	 *	'title'   (string) Title of the viewed page.
	 *	'page'    (string) Optional. Page number if paginated.
	 *	'tagline' (string) Optional. Site description when on home page.
	 * 	'site'    (string) Optional. Site title when not on home page.
	 */

	switch( true ) {
		case is_home():
			if( isset( $luxe['title_top_list'] ) && $luxe['title_top_list'] === 'site' ) {
				$ret = array( 'site' => THK_SITENAME );
				if( isset( $title['page'] ) ) $ret['page'] = $title['page'];
			}
			break;
		case is_front_page():
			if( isset( $luxe['title_front_page'] ) ) {
				if( $luxe['title_front_page'] === 'site' ) {
					$ret = array( 'site' => THK_SITENAME );
				}
				elseif( $luxe['title_front_page'] === 'site_title' ) {
					$ret = array( 'site' => THK_SITENAME, 'title' => get_the_title() );
				}
				elseif( $luxe['title_front_page'] === 'title_site' ) {
					$ret = array( 'title' => get_the_title(), 'site' => THK_SITENAME );
				}
			}
			break;
		case is_singular():
			global $post;

			$addhead = get_post_meta( $post->ID, 'addhead', true );

			if( !empty( $addhead ) ) {
				if( stripos( $addhead, '<' . 'title>' ) !== false && stripos( $addhead, '</title' . '>' ) !== false ) {
					$title = esc_html( preg_replace( '/.*?<' . 'title>(.*?)<\/title' . '>.*/ism', '$1', $addhead ) );
					$ret = array( 'title' => $title );
				}
			}

			if( isset( $luxe['title_other'] ) ) {
				if( $luxe['title_other'] === 'title' ) {
					$ret = array( 'title' => get_the_title() );
					if( isset( $title['page'] ) ) $ret['page'] = $title['page'];
				}
				elseif( $luxe['title_other'] === 'site_title' ) {
					$ret = array( 'site' => THK_SITENAME, 'title' => get_the_title() );
					if( isset( $title['page'] ) ) $ret['page'] = $title['page'];
				}
			}
			break;
		default:
			if( isset( $luxe['title_other'] ) ) {
				if( $luxe['title_other'] === 'title' ) {
					$ret = array( 'title' =>  current( $title ) );
					if( isset( $title['page'] ) ) $ret['page'] = $title['page'];
				}
				elseif( $luxe['title_other'] === 'site_title' ) {
					$ret = array( 'site' => THK_SITENAME, 'title' => current( $title ) );
					if( isset( $title['page'] ) ) $ret['page'] = $title['page'];
				}
			}
			break;
	}
	return $ret;
} );

/*---------------------------------------------------------------------------
 * グローバルナビにホームへのリンク追加
 *---------------------------------------------------------------------------*/
add_filter( 'wp_page_menu_args', function( $args ) {
	global $luxe;

	if( isset( $luxe['home_text'] ) ) {
		$args['show_home'] = $luxe['home_text'];
	}
	elseif( !isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}

	return $args;
} );

/*---------------------------------------------------------------------------
 * プロトコル消去
 *---------------------------------------------------------------------------*/
if( function_exists( 'pdel' ) === false ):
function pdel( $url ) {
	return str_replace( array( 'http:', 'https:' ), '', esc_url( $url ) );
}
endif;

/*---------------------------------------------------------------------------
 * スクリプト類に勝手に入ってくるバージョン番号消す
 *---------------------------------------------------------------------------*/
if( function_exists( 'remove_url_version' ) === false ):
function remove_url_version( $arg ) {
	if( strpos( $arg, 'ver=' ) !== false ) {
		$arg = esc_url( remove_query_arg( 'ver', $arg ) );
	}
	return $arg;
}
add_filter( 'style_loader_src', 'remove_url_version', 99 );
add_filter( 'script_loader_src', 'remove_url_version', 99 );
endif;

/*---------------------------------------------------------------------------
 * ヘッダーに canonical 追加
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_rel_canonical' ) === false ):
function thk_rel_canonical() {
	global $paged, $page, $wp_query;

	$canonical_url = null;

	switch( true ) {
		case is_home():
			if( get_option('page_for_posts') ){
				$canonical_url = canonical_paged_uri( get_page_link( get_option('page_for_posts') ) );
			}
			else {
				$canonical_url = canonical_paged_uri( THK_HOME_URL );
			}
			break;
		case is_front_page():
			$canonical_url = canonical_paged_uri( THK_HOME_URL );
			break;
		case is_category():
			$canonical_url = canonical_paged_uri( get_category_link( get_query_var('cat') ) );
			break;
		case is_tag():
			$canonical_url = canonical_paged_uri( get_tag_link( get_query_var('tag_id') ) );
			break;
		case is_author():
			$canonical_url = canonical_paged_uri( get_author_posts_url( get_query_var( 'author' ), get_query_var( 'author_name' ) ) );
			break;
		case is_year():
			$canonical_url = canonical_paged_uri( get_year_link( get_the_time('Y') ) );
			break;
		case is_month():
			$canonical_url = canonical_paged_uri( get_month_link( get_the_time('Y'), get_the_time('m') ) );
			break;
		case is_day():
			$canonical_url = canonical_paged_uri( get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) );
			break;
		case is_post_type_archive() :
			$post_type = get_query_var( 'post_type' );
			if( is_array( $post_type ) === true ) { $post_type = reset( $post_type ); }
			$canonical_url = canonical_paged_uri( get_post_type_archive_link( $post_type ) );
			break;
		default:
			break;
	}

	if( $canonical_url !== null ):
?>
<link rel="canonical" href="<?php echo esc_url( $canonical_url ); ?>" />
<?php
	endif;
}
endif;

if( function_exists( 'canonical_paged_uri' ) === false ):
function canonical_paged_uri( $canonical_url ) {
	global $paged, $page, $wp_rewrite;

	if( $paged >= 2 || $page >= 2 ) {
		// パーマリンクが設定されてる場合
		if( is_object( $wp_rewrite ) === true && $wp_rewrite->using_permalinks() ) {
			if( substr( $canonical_url, -1 ) === '/' ) {
				$canonical_url .= 'page/' . max( $paged, $page ) . '/';
			}
			else {
				$canonical_url .= '/page/' . max( $paged, $page );
			}
		}
		// パーマリンクがデフォルト設定(動的URL)の場合
		else {
			if( is_front_page() === true ) {
				$canonical_url .= '?paged=' . max( $paged, $page );
			}
			else {
				$canonical_url .= '&amp;paged=' . max( $paged, $page );
			}
		}
	}
	return $canonical_url;
}
endif;

/*---------------------------------------------------------------------------
 * ヘッダーに next / prev 追加
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_rel_next_prev' ) === false ):
function thk_rel_next_prev() {
	global $paged, $post, $wp_query;

	if( is_singular() === false ) {
		$max_page = (int)$wp_query->max_num_pages;

		if( empty( $paged ) ) {
			$paged = 1;
		}
		$nextpage = (int)$paged + 1;
		if( $nextpage <= $max_page ) {
?>
<link rel="next" href="<?php echo next_posts( $max_page, false ); ?>" />
<?php
		}
		if( $paged > 1 ) {
?>
<link rel="prev" href="<?php echo previous_posts( false ); ?>" />
<?php
		}
	}
	else {
		$pages = count( explode('<!--nextpage-->', $post->post_content) );

		if( $pages > 1 ) {
			$prev = singular_nextpage_link( 'prev', $pages );
			$next = singular_nextpage_link( 'next', $pages );

			if( !empty( $prev ) ) {
?>
<link rel="prev" href="<?php echo $prev; ?>" />
<?php
			}
			if( !empty( $next ) ) {
?>
<link rel="next" href="<?php echo $next; ?>" />
<?php
			}
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * 投稿・固定ページを <!--nextpage--> で分割した場合の next / prev 追加関数
 *---------------------------------------------------------------------------*/
if( function_exists( 'singular_nextpage_link' ) === false ):
function singular_nextpage_link( $rel = 'prev', $pages ) {
	global $post, $page;
	$url = '';

	if( $pages > 1 ) {
		$i = $rel === 'prev' ? $page - 1 : $page + 1;
		if( $i >= 0 && $i <= $pages ) {
			if( 1 === $i ) {
				if( $rel === 'prev' ) {
					$url = get_permalink();
				}
				else {
					$url = trailingslashit( get_permalink() ) . user_trailingslashit( $i + 1, 'single_paged' );
				}
			}
			else {
				$opt = get_option('permalink_structure');
				if( empty( $opt ) || in_array( $post->post_status, array('draft', 'pending') ) ) {
					$url = add_query_arg( 'page', $i, get_permalink() );
				}
				else {
					$url = trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' );
				}
			}
		}
	}
	return $url;
}
endif;

/*---------------------------------------------------------------------------
 * サイドバーのカラム数を決めて、サイドバーを呼び出す
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_call_sidebar' ) === false ):
function thk_call_sidebar() {
	global $luxe;

	if( wp_is_mobile() === true && isset( $luxe['hide_mobile_sidebar'] ) ) {
		if( $luxe['column_style'] === '3column' && !isset( $luxe['amp'] ) ) {
?>
</div><!--/#field-->
<?php
		}
		return true;
	}

	if( isset( $luxe['buffering_enable'] ) ) {
		thk_flash();
	}

	// 1カラムの時はサイドバー表示しない
	if( $luxe['column_style'] === '1column' ) return true;

	if( $luxe['column_style'] === '3column' && !isset( $luxe['amp'] ) ) {
		if( isset( $luxe['column3_reverse'] ) ) {
			echo apply_filters( 'thk_sidebar', '' );
		}
		else {
			echo apply_filters( 'thk_sidebar', 'col3' );
		}
?>
</div><!--/#field-->
<?php
		if( !isset( $luxe['column3_reverse'] ) ) {
			echo apply_filters( 'thk_sidebar', '' );
		}
		else {
			echo apply_filters( 'thk_sidebar', 'col3' );
		}
	}
	else {
		echo apply_filters( 'thk_sidebar', '' );
	}

	if( isset( $luxe['buffering_enable'] ) ) {
		thk_flash();
	}
}
endif;

/*---------------------------------------------------------------------------
 * ヘッダー、サイドバー、その他の書き換え
 *---------------------------------------------------------------------------*/
// common
if( function_exists( 'thk_html_format' ) === false ):
function thk_html_format( $contents ) {
	global $luxe;

	// 連続改行削除
	$contents = preg_replace( '/(\n|\r|\r\n)+/us',"\n", $contents );
	// 行頭の余計な空白削除
	$contents = preg_replace( '/\n+\s*</', "\n".'<', $contents );

	// タグ間の余計な空白や改行の削除
	if( $luxe['html_compress'] === 'low' ) {
		$contents = preg_replace( '/>[\t| ]+?</', '><', $contents );
		$contents = preg_replace( '/\n+<\/([^b|^h])/', '</$1', $contents );
	}
	elseif( $luxe['html_compress'] === 'high' ) {
		$contents = preg_replace( '/>\s*?</', '><', $contents );
	}

	return $contents;
}
add_filter( 'wp_nav_menu', 'thk_html_format', 10, 2 );
endif;

/*---------------------------------------------------------------------------
 * スクリプト書き換え
 *---------------------------------------------------------------------------*/
add_filter( 'script_loader_tag', function( $ret ) {
	if(
		is_feed() === true ||
		is_admin() === true ||
		is_customize_preview() === true
	) return $ret;

	global $luxe;

	//$ret = str_replace( "'", '"', $ret );

	// dummy.js
	if( stripos( $ret, '/thk-dummy.js' ) ) {
		$ret = ltrim( substr( $ret, stripos( $ret, "\n" ), strlen( $ret ) ) );
	}

	// jquery migrate
	if( isset( $luxe['jquery_load'] ) && $luxe['jquery_load'] === 'wordpress' ) {
		if( !isset( $luxe['jquery_migrate_load'] ) ) {
			if( stripos( $ret, 'jquery/jquery-migrate.min.js' ) !== false ) {
				$ret = null;
			}
		}
	}

	// bootstrap.min.js
	if(
		isset( $luxe['jquery_load'] ) && $luxe['jquery_load'] !== 'none' &&
		isset( $luxe['bootstrap_js_load_type'] ) && $luxe['bootstrap_js_load_type'] !== 'none'
	) {
		if( stripos( $ret, 'bootstrap.min.js' ) !== false ) {
			if( $luxe['bootstrap_js_load_type'] === 'sync' ) {
				$bootstrap_js = '';
			}
			elseif( $luxe['bootstrap_js_load_type'] === 'asyncdefer' ) {
				$bootstrap_js = ' async defer';
			}
			else {
				$bootstrap_js = ' ' . $luxe['bootstrap_js_load_type'];
			}
			$ret = str_replace( '><', $bootstrap_js . '><', $ret );
		}
	}

	// luxe.async.min.js
	if( stripos( $ret, 'luxe.async.min.js' ) !== false ) {
		$ret = str_replace( '><', ' async defer><', $ret );
	}

	// jquery defer
	if( isset( $luxe['jquery_defer'] ) && stripos( $ret, 'async' ) === false && stripos( $ret, 'defer' ) === false ) {
		global $post;
		$thk_disable_async_jquery = isset( $post->ID ) ? get_post_meta( $post->ID, 'thk_disable_async_jquery', true ) : '';

		if( $thk_disable_async_jquery !== 'disable') {
			if( stripos( $ret, '/js/jquery.luxe.min.js' ) !== false ) {
				$ret = str_replace( '><', ' async defer><', $ret );
			}
			elseif( stripos( $ret, '/recaptcha/api.js?render=' ) !== false ) {
				// reCAPTCHA v3 は非同期にすると動かないのでスルー
			}
			elseif( stripos( $ret, '/js/jquery.bind.min.js' ) !== false ) {
				$ret = str_replace( '><', ' async defer><', $ret );
			}
			else {
				$ret = str_replace( '><', ' defer><', $ret );
			}
		}
	}
	elseif( stripos( $ret, '/js/luxe.min.js' ) !== false ) {
		$ret = str_replace( '><', ' async defer><', $ret );
	}

	$ret = str_replace( array( "src='http:", "src='https:" ), "src='", $ret );
	$ret = str_replace( array( 'src="http:', 'src="https:' ), 'src="', $ret );

	return str_replace( '  ', ' ', $ret );
} );

/*---------------------------------------------------------------------------
 * スタイルシート書き換え
 *---------------------------------------------------------------------------*/
add_filter( 'style_loader_tag', function( $ret ) {
	global $luxe;

	if( isset( $luxe['amp'] ) ) return;

	if(
		is_feed() === true ||
		is_admin() === true ||
		is_customize_preview() === true
	) return $ret;

	$ret = str_replace( array( 'http:', 'https:' ), '', $ret );
	$ret = str_replace( "'", '"', $ret );

	if( strpos( $ret, 'id="async-css"' ) !== false ) {
		$ret = '<noscript>' . trim( $ret ) . '</noscript>' . "\n";
	}

	if( strpos( $ret, 'id="nav-css"' ) !== false ) {
		$ret = '<noscript>' . trim( $ret ) . '</noscript>' . "\n";
	}

	if( isset( $luxe['wp_block_library_load'] ) && ( $luxe['wp_block_library_load'] === 'inline' || $luxe['wp_block_library_load'] === 'none' ) ) {
		if( stripos( $ret, 'id="wp-block-library-css"' ) !== false || stripos( $ret, 'id="wp-block-library-css"' ) !== false ) {
			$ret = null;
		}
	}
	if( isset( $luxe['css_to_style'] ) ) {
		if( stripos( $ret, 'id="luxe-css"' ) !== false || stripos( $ret, 'id="luxech-css"' ) !== false ) {
			$ret = null;
		}
	}
	if( isset( $luxe['css_to_plugin_style'] ) ) {
		if( stripos( $ret, 'id="plugin-styles-css"' ) !== false ) {
			$ret = null;
		}
	}

	if( strpos( $ret, 'id="luxe1-css"' ) !== false || strpos( $ret, 'id="luxe2-css"' ) !== false || strpos( $ret, 'id="luxe3-css"' ) !== false ) {
		$ret = null;
	}

	return str_replace( '  ', ' ', $ret );
} );

/*---------------------------------------------------------------------------
 * Intersection Observer 用の img タグ置換
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_intersection_observer_replace_all' ) === false ):
function thk_intersection_observer_replace_all( $content ) {
	if( empty( $content ) ) return $content;

	$rs = array();

	preg_match_all( '#<(img)([^>]+?)(>(.*?)</\\1>|[\/]?>)#is', $content, $m );
	$i = 0;

	if( isset( $m[0] ) ) {
		foreach( (array)$m[0] as $value ) {
			if( $i < 1 ) {
				$rs[$value] = thk_intersection_observer_replace( $value, true );
			}
			else {
				$rs[$value] = thk_intersection_observer_replace( $value );
			}
			++$i;
		}
	}
	unset( $m );

	foreach( $rs as $key => $val ) {
		$content = str_replace( $key, $val, $content );
	}
	return $content;
}
endif;

if( function_exists( 'thk_intersection_observer_replace' ) === false ):
function thk_intersection_observer_replace( $content, $script = false ) {
	if( empty( $content ) ) return $content;

	global $luxe;

	$org = $content;
	if( stripos( $content, 'data-src=' ) === false  ) {
		if( stripos( $content, 'class=' ) !== false ) {
			$content = str_replace( 'src=', 'src="' . $luxe['trans_image'] . '" data-src=', $content );
			$content = preg_replace( '/(class=[\'|\"]*)/', '$1lazy ', $content );
		}
		else {
			$content = str_replace( 'src=', 'src="' . $luxe['trans_image'] . '" class="lazy" data-src=', $content );
		}
		$content = str_replace( 'srcset=', 'data-srcset=', $content );

		if( $script === true ) {
			$content .= '<script>thklazy()</script>';
		}
		if( isset( $luxe['lazyload_noscript'] ) ) {
			$content .= '<noscript>' . $org . '</noscript>';
		}
	}
	return $content;
}
endif;

/*---------------------------------------------------------------------------
 * Tosrus 用の a タグ置換
 *---------------------------------------------------------------------------*/
if( function_exists( 'add_tosrus' ) === false ):
function add_tosrus( $content ) {
	if( is_feed() === true ) return $content;

	if( stripos( $content, 'data-rel="tosrus"' ) !== false ) {
		return $content;
	}

	$content = preg_replace(
		'/(<a[^>]+?href[^>]+?(\.jpg|\.jpe|\.jpeg|\.png|\.gif|\.bmp|\.webp)[\'\"][^>]*?)>\s*(<img[^>]+?(alt=[\'\"](.*?)[\'\"]|[^>]+?)+[^>]+?>)\s*<\/a>/i',
		'${1} data-rel="tosrus" data-title="${5}">${3}</a>',
		$content
	);

	return $content;
}
endif;

/*---------------------------------------------------------------------------
 * Lightcase 用の a タグ置換
 *---------------------------------------------------------------------------*/
if( function_exists( 'add_lightcase' ) === false ):
function add_lightcase( $content ) {
	if( is_feed() === true ) return $content;

	if( stripos( $content, 'data-rel="lightcase"' ) !== false ) {
		return $content;
	}

	$content = preg_replace(
		'/(<a[^>]+?href[^>]+?(\.jpg|\.jpe|\.jpeg|\.png|\.gif|\.bmp|\.webp)[\'\"][^>]*?)>\s*(<img[^>]+?>)\s*<\/a>/i',
		'${1} data-rel="lightcase:myCollection">${3}</a>',
		$content
	);

	return $content;
}
endif;

/*---------------------------------------------------------------------------
 * Fluidbox 用の a タグ置換
 *---------------------------------------------------------------------------*/
if( function_exists( 'add_fluidbox' ) === false ):
function add_fluidbox( $content ) {
	if( is_feed() === true ) return $content;

	if( stripos( $content, 'data-fluidbox' ) !== false ) {
		return $content;
	}

	$content = preg_replace(
		'/(<a[^>]+?href[^>]+?(\.jpg|\.jpe|\.jpeg|\.png|\.gif|\.bmp|\.webp)[\'\"][^>]*?)>\s*(<img[^>]+?>)\s*<\/a>/i',
		'${1} data-fluidbox>${3}</a>',
		$content
	);

	return $content;
}
endif;

/*---------------------------------------------------------------------------
 * 「記事を読む」の後ろに短いタイトル追加
 *---------------------------------------------------------------------------*/
if( function_exists( 'read_more_title_add' ) === false ):
function read_more_title_add( $word = '', $length = 16 ) {
	$more_title = the_title_attribute('echo=0');

	if( is_int( $length ) === false ) {
		$length = 16;
	}
	if( mb_strlen( $more_title ) > $length ) {
		$more_title = mb_strimwidth( $more_title, 0, $length ) . ' ...';
	}
	return $word . ' <i class="fa fas fa-angle-double-right"></i>&nbsp; ' . $more_title;
}
endif;

/*---------------------------------------------------------------------------
 * more タグ除去（オリジナルのものに変えるので要らない）
 *---------------------------------------------------------------------------*/
add_filter( 'the_content_more_link', function( $more ) {
	return null;
} );

/*---------------------------------------------------------------------------
 * インラインフレーム (Youtube とか Google Map 等) の responsive 対応
 * 外部リンクに external や icon 追加
 * AMP 用の置換
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_the_content' ) === false ):
function thk_the_content( $contents ) {
	global $luxe;

	if( !empty( $contents ) ) {
	 	/***
		 * 目次挿入
		 ***/
		// 目次の自動挿入か目次ウィジェットが有効な場合のみ処理
		if( isset( $luxe['toc_auto_insert'] ) || is_active_widget( false, false, 'thk_toc_widget' ) !== false ) {
			if( ( is_single() === true && isset( $luxe['toc_single_enable'] ) ) || ( is_page() === true && isset( $luxe['toc_page_enable'] ) ) ) {
				if( !isset( $luxe['amp'] ) || ( isset( $luxe['amp'] ) && isset( $luxe['toc_amp'] ) ) ) {
					$toc_array = thk_create_toc( $contents, true );

					if( isset( $luxe['toc_auto_insert'] ) && !empty( $toc_array[1] ) ) {
						// 目次の自動挿入が有効な場合
						$toc_title = isset( $luxe['toc_title'] ) ? $luxe['toc_title'] : __( 'Table of Contents', 'luxeritas' );

						// 目次本体
						$toc_body = '<div id="toc_container"><span class="toc_title">' . $toc_title . '</span>';
						if( !isset( $luxe['amp'] ) ) {
							$toc_body .= '<input id="toc_toggle" type="checkbox" checked="checked"><label class="toc_toggle" for="toc_toggle"></label>';
						}
						$toc_body .= $toc_array[1] . '</div><!--/#toc_container-->' . "\n";

						// 目次挿入
						$contents = substr( $toc_array[0], 0, $toc_array[2] ) . $toc_body . substr( $toc_array[0], $toc_array[2] );
					}
					else {
						// 目次の自動挿入が無効だけど目次ウィジェットが使われてる場合
						$contents = $toc_array[0];
					}
					unset( $toc_array );
				}
			}
		}

	 	/***
		 * H2 タグ上のウィジェット挿入
		 ***/
		if( function_exists('dynamic_sidebar') === true && is_active_sidebar('post-h2-upper') === true ) {
			if( stripos( $contents, '<h2>' ) !== false || stripos( $contents, '<h2 ' ) !== false ) {
				ob_start();
				if( !isset( $luxe['amp'] ) ) {
					dynamic_sidebar( 'post-h2-upper' );
				}
				else {
					dynamic_sidebar( 'post-h2-upper-amp' );
				}
				$widget = ob_get_clean();
				$widget = str_replace( "\t", '', $widget );
				$contents = preg_replace( '/(<h2.*?>)/i', $widget . "\n$1", $contents, 1 );
			}
		}

	 	/***
		 * AMP 置換 (その1)
		 ***/
		if( isset( $luxe['amp'] ) ) {
			$contents = thk_amp_not_allowed_tag_replace( $contents );
		}

	 	/***
		 * インラインフレーム
		 ***/
		// インラインフレームで、且つ embed を含むものを探す
		$i_frame = 'i' . 'frame';

		if( stripos( $contents, $i_frame ) !== false && stripos( $contents, 'embed' ) !== false ) {
			preg_match_all( "/<\s*${i_frame}[^>]+?embed[^>]+?>[^<]*?<\/${i_frame}>/i", $contents, $frame_array );

			// 置換する
			foreach( array_unique( $frame_array[0] ) as $value ) {
				$replaced = '';

				// WordPress だと、ほぼ自動で p で囲まれるため、div でなく、あえて span (display:block) を使う
				if( stripos( $value, 'youtube.com' ) !== false || stripos( $value, '.google.com/maps' ) !== false ) {
					$replaced = str_replace( "<$i_frame", "<span class=\"i-video\"><$i_frame", $value );
					$replaced = str_replace( "</$i_frame>", "</$i_frame></span>", $replaced );
				}
				else {
					$replaced = str_replace( "<$i_frame", "<span class=\"i-embed\"><$i_frame", $value );
					$replaced = str_replace( "</$i_frame>", "</$i_frame></span>", $replaced );
				}
				$contents = str_replace( $value, $replaced, $contents );
			}
		}
		// インラインフレームで、且つ player.vimeo.com/ を含むものを探す
		if( stripos( $contents, $i_frame ) !== false && stripos( $contents, 'player.vimeo.com/' ) !== false ) {
			preg_match_all( "/<\s*${i_frame}[^>]+?player.vimeo.com[^>]+?>[^<]*?<\/${i_frame}>/i", $contents, $frame_array );

			// 置換する
			foreach( array_unique( $frame_array[0] ) as $value ) {
				$replaced = '';

				// WordPress だと、ほぼ自動で p で囲まれるため、div でなく、あえて span (display:block) を使う
				if( stripos( $value, '.vimeo.com/' ) !== false ) {
					$replaced = str_replace( "<$i_frame", "<span class=\"i-video\"><$i_frame", $value );
					$replaced = str_replace( "</$i_frame>", "</$i_frame></span>", $replaced );
				}
				$contents = str_replace( $value, $replaced, $contents );
			}
		}

	 	/***
		 * AMP 置換 (その2)
		 ***/
		if( isset( $luxe['amp'] ) ) {
			$contents = thk_amp_tag_replace( $contents );
		}

	 	/***
		 * 外部リンクに external や icon 追加
		 ***/
		if(
			isset( $luxe['add_target_blank'] ) ||
			isset( $luxe['add_rel_nofollow'] ) ||
			isset( $luxe['add_class_external'] ) ||
			isset( $luxe['add_external_icon'] )
		) {
			preg_match_all( '/<a[^>]+?href[^>]+?>.+?<\/a>/i', $contents, $link_array );
			//$my_url = preg_quote( rtrim( THK_HOME_URL, '/' ) . '/', '/' );

			foreach( array_unique( $link_array[0] ) as $link ) {
				$replaced = '';
				$last = '';

				$compare = str_replace( array( "'", '"', ' ' ), '', $link );

				if( stripos( $compare, '://' ) === false && stripos( $compare, 'href=//' ) === false ) continue;
				if( stripos( $compare, '\\' ) !== false ) continue;
				if( stripos( $compare, 'data-blogcard' ) !== false || stripos( $compare, 'blogcard-href' ) !== false ) continue;

				//if( !preg_match( '/href=[\'|\"]?\s?' . $my_url . '[^>]+?[\'|\"]/i', $link ) ) {
				if( stripos( $compare, 'href=' . THK_HOME_URL ) === false ) {
					$atag = preg_split( '/>/i', $link );
					$atag = array_filter( $atag );

					// target="_blank"
					if( isset( $luxe['add_target_blank'] ) && stripos( $atag[0], 'target' ) === false ) {
						$atag[0] .= ' target="_blank"';
					}
					// rel="nofollow"
					if( isset( $luxe['add_rel_nofollow'] ) && stripos( $atag[0], 'nofollow' ) === false ) {
						$atag[0] .= ' rel="nofollow"';
					}
					// class="external"
					if( isset( $luxe['add_class_external'] ) ) {
						$atag[0] .= ' class="external"';
					}

					foreach( $atag as $key => $value ) $atag[$key] = $value . '>';

					// external icon
					if( isset( $luxe['add_external_icon'] ) && !isset( $luxe['amp'] ) ) {
						$last = end( $atag );
						$last .= '<span class="ext_icon"></span>';
						array_pop( $atag );

					}

					foreach( $atag as $value ) $replaced .= $value;

					// external 付与によって class が重複した場合は1つにまとめる(元から class が重複しちゃってた場合は無理)
					if( isset( $luxe['add_class_external'] ) ) {
						if( preg_match( '/<a [^>]*class[\s]*=[^>]+?class[\s]*=[^>]*?>/', $replaced ) === 1 ) {
							$replaced = str_replace( ' class="external"', '', $replaced );
							$replaced = preg_replace( '/(<a [^>]*?)class[\s]*=["\']+([^"\']+)["\']+([^>]*)>(.+)/im', '$1class="$2 external"$3>$4', $replaced );

							if( stripos( $replaced, 'class="' ) === false && stripos( $replaced, "class='" ) === false ) {
								$replaced = preg_replace( '/(<a [^>]*?)class[\s]*=([^\s]+)\s([^>]*)>(.+)/im', '$1class="$2 external" $3>$4', $replaced );
							}
						}
					}

					$replaced = str_replace( '  ', ' ', $replaced );
					$replaced .= $last;

					$contents = str_replace( $link, $replaced, $contents );

					if( isset( $luxe['add_external_icon'] ) ) {
						// img の時はアイコン消す（class="external" は残す）
						$contents = preg_replace(
							'/(<a[^>]+?href[^>]+?external[^>]+?>.*?<img[^>]+?src.+?>.*?<\/a>)<span class=\"ext_icon\"><\/span>/im',
							'$1', $contents
						);
					}
				}
			}
		}
	}
	return $contents;
}
add_filter( 'thk_content', 'thk_the_content', 1073741824 );
//add_filter( 'the_content', 'thk_the_content', 2147483647 );
endif;

/*---------------------------------------------------------------------------
 * 目次生成関数（ウィジェットでも使用するので、thk_the_content から分離）
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_toc' ) === false ):
function thk_create_toc( $contents, $contents_replace = false ) {
	$toc = '';
	$pos = '';

	// 少なくとも H2 か h3 がある場合だけ
	if( stripos( $contents, '<h2' ) !== false || stripos( $contents, '<h3' ) !== false ) {
		global $luxe;

		// H2 が無いにも関わらず、いきなり H3 から始まってる場合でも一応処理はする
		if( stripos( $contents, '<h2' ) === false ) {
			if( substr_count( $contents, '<h3' ) < $luxe['toc_number_of_headings'] ) return array( $contents, $toc );
		}
		else {
			if( substr_count( $contents, '<h2' ) < $luxe['toc_number_of_headings'] ) return array( $contents, $toc );
		}

		$h = isset( $luxe['toc_hierarchy'] ) ? $luxe['toc_hierarchy'] : '3';

		if( preg_match_all( '/<h([2-' . $h . ']{1})[^>]*?>(.*?)<\/h\1>/ism', $contents, $matches, PREG_SET_ORDER ) ) {
			if( empty( $matches ) ) return $contents;
			$pos = strpos( $contents, $matches[0][0] );

			$deps_array = array();
			foreach( (array)$matches as $m ) {
				if( isset( $m[1] ) ) $deps_array[] = $m[1];
			}
			if( empty( $deps_array ) ) return array( $contents, $toc );

			$min_deps = min( $deps_array ); unset( $deps_array );
			$current_deps = $min_deps - 1;
			$sub_deps = array( '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0 );
			$a = 0;

			foreach( (array)$matches as $m ) {
				$deps = (int)$m[1];
				$text = $m[2];

				$temp = mb_substr_replace( $text, mb_substr( $text, 0, 1 ) . "#*\t" . $a . "\t*#", 0 , 1 );

				$contents = preg_replace( '/<(h[2-6]{1}[^>]*?)>' . preg_quote( $text, '/' ) . '(<\/h[2-6]>)/i', '<$1>' . $temp . '$2', $contents, 1 );

				while( $current_deps > $deps ) {
					$toc .= '</li></ul>';
					--$current_deps;
				}
				if( $current_deps === $deps ) {
					$toc .= '</li><li>';
				}
				else {
					while( $current_deps < $deps ) {
						$toc .= '<ul class="toc_list"><li>';
						++$current_deps;
					}
					for( $i = $current_deps; $i < count( $sub_deps ); ++$i ) {
						$sub_deps[$i] = 0;
					}
				}
				++$sub_deps[$current_deps];

				$full_deps = array();
				for( $i = $min_deps; $i <= $deps; ++$i ) {
					$full_deps[] = $sub_deps[$i];
				}

				$target = 'toc_id_' . implode( '_', $full_deps );
				$full_deps_number = implode( '.', $full_deps );

				end( $full_deps );
				$parent_deps = prev( $full_deps );
				if( empty( $parent_deps ) ) $parent_deps = 1;

				$toc .= '<a href="#' . $target . '"><span class="toc_number toc_depth_' . $parent_deps . '">' . $full_deps_number . '.</span> ' . $text . '</a>';

				if( $contents_replace === true ) {
					// 投稿本文置換
					$quote_text = preg_quote( $temp, '/' );
					preg_match( '/<h[2-6]{1}[^>]*?><span id=["\'\s]*>' . $quote_text . '<\/span><\/h[2-6]{1}>/im', $contents, $already );

					if( !isset( $already[1] ) ) {
						$contents = preg_replace( '/(<h[2-6]{1}[^>]*?>)' . $quote_text . '(<\/h[2-6]{1}>)/im', '$1<span id="' . $target . '">' . $temp . '</span>$2', $contents, 1 );
					}
					else {
						$toc = str_replace( '<a href="#' . $target . '">', '<a href="#' . $already[1] . '">', $toc );
					}
				}
				++$a;
			}
			while( $current_deps >= $min_deps ) {
				$toc .= '</li></ul>';
				--$current_deps;
			}
			$contents = preg_replace( '/<(h[2-6]{1}[^>]*?)>(.+?)' . '#\*\t[0-9]+?\t\*#' . '(.*?<\/h[2-6]{1}>)/ism', '<$1>$2$3', $contents );
		}
	}
	return array( $contents, $toc, $pos );
}
endif;

/*---------------------------------------------------------------------------
 * コピーライト生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_copyright' ) === false ):
function thk_create_copyright( $type, $auth, $since = null, $text = null ) {
	$ret = '';

	if( $type !== 'free' || ( $type === 'free' && !empty( $text ) ) ) {
		$ret .= '<p class="copy">';
	}

	switch( $type ) {
		case 'ccsra':
			$ret .= 'Copyright &copy; <span itemprop="copyrightYear">' . $since . '</span>-' . date('Y') . ' <span itemprop="copyrightHolder name">' . $auth . '</span> All Rights Reserved.';
			break;
		case 'ccsa':
			$ret .= 'Copyright &copy; <span itemprop="copyrightYear">' . $since . '</span>&nbsp;<span itemprop="copyrightHolder name">' . $auth . '</span> All Rights Reserved.';
			break;
		case 'cca':
			$ret .= 'Copyright &copy; <span itemprop="copyrightHolder name">' . $auth . '</span> All Rights Reserved.';
			break;
		case 'ccsr':
			$ret .= 'Copyright &copy; <span itemprop="copyrightYear">' . $since . '</span>-' . date('Y') . ' <span itemprop="copyrightHolder name">' . $auth . '</span>';
			break;
		case 'ccs':
			$ret .= 'Copyright &copy; <span itemprop="copyrightYear">' . $since . '</span>&nbsp;<span itemprop="copyrightHolder name">' . $auth . '</span>';
			break;
		case 'cc':
			$ret .= 'Copyright &copy; <span itemprop="copyrightHolder name">' . $auth . '</span>';
			break;
		case 'csr':
			$ret .= '&copy; <span itemprop="copyrightYear">' . $since . '</span>-' . date('Y') . ' <span itemprop="copyrightHolder name">' . $auth . '</span>';
			break;
		case 'cs':
			$ret .= '&copy; <span itemprop="copyrightYear">' . $since . '</span>&nbsp;<span itemprop="copyrightHolder name">' . $auth . '</span>';
			break;
		case 'c':
			$ret .= '&copy; <span itemprop="copyrightHolder name">' . $auth . '</span>';
			break;
		case 'free':
			if( !empty( $text ) ) {
				$ret .= $text;
			}
			break;
		default:
			$ret .= 'Copyright &copy; <span itemprop="copyrightYear">' . $since . '</span> <span itemprop="copyrightHolder name">' . $auth . '</span>. All Rights Reserved.';
			break;
	}

	if( $type !== 'free' || ( $type === 'free' && !empty( $text ) ) ) {
		$ret .= '</p>';
	}

	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * カスタマイズで hentry 削除にチェックがついてたら hentry 削除
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_remove_hentry' ) === false ):
function thk_remove_hentry( $ret ) {
	$ret = array_diff( $ret, array('hentry') );
	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * 全体イメージの CSS ファイル名取得
 *---------------------------------------------------------------------------*/
if( function_exists( 'get_overall_image' ) === false ):
function get_overall_image() {
	global $luxe;

	$overall = isset( $luxe['overall_image'] ) ? $luxe['overall_image'] : 'white';
	if( $overall !== 'white' ) {
		$overall = 'styles/style-' . $overall . '.css';
	}
	else {
		$overall = 'style.css';
	}
	return $overall;
}
endif;

/*---------------------------------------------------------------------------
 * CSS を HTML に直接埋め込む場合 (パス変換済みの CSS を require する)
 * または、テンプレートごとにカラム数が違う場合
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_direct_style' ) === false ):
function thk_direct_style( $require_file ) {
	if( file_exists( $require_file ) === false ) return;
	return thk_fgc( $require_file );
}
endif;

/*---------------------------------------------------------------------------
 * Web フォントの preload
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_preload_web_font' ) === false ):
function thk_preload_web_font( $font_name = null ) {
	if( !empty( $font_name ) ) {
		if( file_exists( TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP . $font_name ) ) {
			ob_start();
			require( TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP . $font_name );
			$href = trim( ob_get_clean() );
			$type = substr( $href, strripos( $href, '.' ) + 1 );
			if( stripos( $href, '//' ) !== false && !empty( $type ) ) {
?>
<link rel="preload" as="font" type="font/<?php echo $type; ?>" href="<?php echo $href; ?>" crossorigin />
<?php
			}
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * ブログカードキャッシュ削除処理
 *---------------------------------------------------------------------------*/
/* 削除処理 */
if( function_exists( 'blogcard_cache_cleanup' ) === false ):
function blogcard_cache_cleanup( $rm_dir = false, $del_transient_only = false ) {
	global $wp_filesystem, $wpdb;

	if( $del_transient_only === false ) {
		require_once( INC . 'optimize.php' );

		$filesystem = new thk_filesystem();
		if( $filesystem->init_filesystem( site_url() ) === false ) return false;

		$wp_upload_dir = wp_upload_dir();
		$cache_dir = $wp_upload_dir['basedir'] . '/luxe-blogcard/';

		if( $wp_filesystem->is_dir( $cache_dir ) === true ) {
			if( $rm_dir === true ) {
				// ディレクトリごと消す場合
				if( $wp_filesystem->delete( $cache_dir, true ) === false ) {
					if( is_admin() === true ) {
						add_settings_error( 'luxe-custom', '', __( 'Could not delete cache directory.', 'luxeritas' ) . '<br />' . $cache_dir );
					}
					elseif( defined( 'WP_DEBUG' ) === true && WP_DEBUG == true ) {
						$result = new WP_Error( 'rmdir failed', __( 'Could not delete cache directory.', 'luxeritas' ), $cache_dir );
						thk_error_msg( $result );
					}
				}
			}
			else {
				// ファイルだけ消す場合
				$dirlist = $wp_filesystem->dirlist( $cache_dir );
				foreach( (array)$dirlist as $filename => $fileinfo ) {
					$wp_filesystem->delete( $cache_dir . $filename, true );
				}
			}
		}
	}

	// transient を消す
	$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_luxe-bc-%')" );
	$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_timeout_luxe-bc-%')" );
}
endif;

/*---------------------------------------------------------------------------
 * 1週間に1度 SNS のカウントキャッシュを全クリア ( transient に登録)
 *---------------------------------------------------------------------------*/
if( function_exists( 'set_transient_sns_count_cache_weekly_cleanup' ) === false ):
function set_transient_sns_count_cache_weekly_cleanup() {
	if( get_transient( 'sns_count_cache_weekly_cleanup' ) === false ) {
		global $wpdb;

		$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_luxe-sns-%')" );
		$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_timeout_luxe-sns-%')" );
		delete_transient( 'sns_count_cache_weekly_cleanup' );
		set_transient( 'sns_count_cache_weekly_cleanup', 1, WEEK_IN_SECONDS );

		sns_count_cache_cleanup( false, false, true );
	}
}
endif;

/*---------------------------------------------------------------------------
 * SNS のカウントキャッシュ削除処理
 *---------------------------------------------------------------------------*/
/* 削除処理 */
if( function_exists( 'sns_count_cache_cleanup' ) === false ):
function sns_count_cache_cleanup( $rm_dir = false, $del_transient = false, $weekly = true ) {
	require_once( INC . 'optimize.php' );
	global $wp_filesystem;

	$target = $weekly === true ? get_theme_mod( 'sns_count_weekly_cleanup', 'dust' ) : 'all';

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$wp_upload_dir = wp_upload_dir();
	$cache_dir = $wp_upload_dir['basedir'] . '/luxe-sns/';

	if( $wp_filesystem->is_dir( $cache_dir ) === true ) {
		if( $rm_dir === true ) {
			// ディレクトリごと消す場合
			if( $wp_filesystem->delete( $cache_dir, true ) === false ) {
				if( defined( 'WP_DEBUG' ) === true && WP_DEBUG == true ) {
					$result = new WP_Error( 'rmdir failed', __( 'Could not delete cache directory.', 'luxeritas' ), $cache_dir );
					thk_error_msg( $result );
				}
			}
		}
		else {
			// ファイルだけ消す場合
			$dirlist = $wp_filesystem->dirlist( $cache_dir );

			if( $target === 'dust' ) {
				// 明らかなゴミだけ削除する場合
				foreach( (array)$dirlist as $filename => $fileinfo ) {
					$size = filesize( $cache_dir . $filename );
					if( ctype_xdigit( $filename ) === false || strlen( $filename ) !== 32 || $size < 14 || $size > 8200 ) {
						$wp_filesystem->delete( $cache_dir . $filename );
					}
				}
			}
			elseif( $target === 'all' ) {
				// 全ファイル削除する場合
				foreach( (array)$dirlist as $filename => $fileinfo ) {
					$wp_filesystem->delete( $cache_dir . $filename );
				}
			}
		}
	}

	// transient も全部消す場合
	if( $del_transient === true || $target === 'all' ) {
		global $wpdb;
		$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_luxe-sns-%')" );
		$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_timeout_luxe-sns-%')" );
		delete_transient( 'sns_count_cache_weekly_cleanup' );
	}
}
add_action( 'sns_count_cache_weekly_cleanup', 'sns_count_cache_cleanup' );
endif;

/*---------------------------------------------------------------------------
 * SNS カウントキャッシュの transient 登録
 *---------------------------------------------------------------------------*/
/* 空ファイル作成 (template_redirect に add_filter) */
if( function_exists( 'touch_sns_count_cache' ) === false ):
function touch_sns_count_cache() {
	$url = is_front_page() === true ? THK_HOME_URL : get_permalink();
	$sns = new sns_cache();
	$sns->touch_sns_count_cache( esc_url( $url ) );
}
endif;

/* transient 登録 (shutdown に add_filter) */
if( function_exists( 'set_transient_sns_count_cache' ) === false ):
function set_transient_sns_count_cache() {
	$url = is_front_page() === true ? THK_HOME_URL : get_permalink();
	$sns = new sns_cache();
	$sns->set_transient_sns_count_cache( 'sns_count_cache', esc_url( $url ) );
}
endif;

/* カウント数取得 (shutdown に add_filter) */
add_action( 'sns_count_cache', function( $url = null ){
	$sns = new sns_cache();
	$sns->create_sns_cache( esc_url( $url ) );
} );

/*---------------------------------------------------------------------------
 * Feedly カウントキャッシュの transient 登録
 *---------------------------------------------------------------------------*/
/* 空ファイル作成 (template_redirect に add_filter) */
if( function_exists( 'touch_feedly_cache' ) === false ):
function touch_feedly_cache() {
	$sns = new sns_cache();
	$sns->touch_sns_count_cache( esc_url( get_bloginfo( 'rss2_url' ) ) );
}
endif;

/* transient 登録 (shutdown に add_filter) */
if( function_exists( 'transient_register_feedly_cache' ) === false ):
function transient_register_feedly_cache() {
	$sns = new sns_cache();
	$sns->set_transient_sns_count_cache( 'feedly_count_cache', esc_url( get_bloginfo( 'rss2_url' ) ) );
}
endif;

/* カウント数取得 (shutdown に add_filter) */
add_action( 'feedly_count_cache', function( $url = null ){
	$sns = new sns_cache();
	$sns->create_feedly_cache();
} );

/*---------------------------------------------------------------------------
 * SNS カウントキャッシュの中身取得 (初回と失敗時は ajax で取得)
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_get_sns_count_cache' ) === false ):
function thk_get_sns_count_cache() {
	$id_cnt = array( 'f' => '', 'g' => '', 'h' => '', 'l' => '', 't' => '', 'p' => '' );

	foreach( $id_cnt as $key => $val ) {
		$id_cnt[$key] = '<i class="fa fas fa-spinner fa-spin"></i>';
	}

	$url = is_front_page() === true ? esc_url( THK_HOME_URL ) : esc_url( get_permalink() );

	$wp_upload_dir = wp_upload_dir();
	$cache_dir = $wp_upload_dir['basedir'] . '/luxe-sns/';
	$sns_count_cache = $cache_dir . md5( $url );

	if( file_exists( $sns_count_cache ) === true ) {
		global $wp_filesystem;

		$cache = '';
		if( method_exists( $wp_filesystem, 'get_contents' ) === true ) {
			$cache = $wp_filesystem->get_contents( $sns_count_cache );
		}

		if( !empty( $cache ) && strpos( $cache, $url ) !== false ) {
			$ids = explode( "\n", $cache );
			array_shift( $ids );
			foreach( (array)$ids as $value ) {
				foreach( (array)$id_cnt as $key => $val ) {
					if( strpos( $value, $key . ':' ) !== false ) {
						$value = trim( $value, $key . ':' );
						if( ctype_digit( $value ) === true ) {
							$id_cnt[$key] = $value;
						}
					}
				}
			}
		}
	}
	return $id_cnt;
}
endif;

/*---------------------------------------------------------------------------
 * Feedly カウントキャッシュの中身取得 (初回と失敗時は ajax で取得)
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_get_feedly_count_cache' ) === false ):
function thk_get_feedly_count_cache() {
	$feedly_count = '<i class="fa fas fa-spinner fa-spin"></i>';

	$url = esc_url( get_bloginfo( 'rss2_url' ) );

	$wp_upload_dir = wp_upload_dir();
	$cache_dir = $wp_upload_dir['basedir'] . '/luxe-sns/';
	$feedly_count_cache = $cache_dir . md5( $url );

	if( file_exists( $feedly_count_cache ) === true ) {
		global $wp_filesystem;

		$cache = '';
		if( method_exists( $wp_filesystem, 'get_contents' ) === true ) {
			$cache = $wp_filesystem->get_contents( $feedly_count_cache );
		}

		if( !empty( $cache ) && strpos( $cache, $url ) !== false ) {
			$cnt = explode( "\nr:", $cache );
			if( ctype_digit( trim( $cnt[1] ) ) === true ) {
				$feedly_count = trim( $cnt[1] );
			}
		}
	}
	return $feedly_count;
}
endif;

/*---------------------------------------------------------------------------
 * SNS カウントのリアルタイムでの取得 (ajax で取得)
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_sns_real' ) === false ):
function thk_sns_real() {
	$sns = new sns_real();
	$sns->thk_sns_real();
	exit;
}
endif;

/*---------------------------------------------------------------------------
 * AMP 用のパーマリンク取得
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_get_amp_permalink' ) === false ):
function thk_get_amp_permalink( $post_id ) {
	$paged = get_query_var('page');
	if( empty( $paged ) ) $paged = 1;

	if( $paged > 1 ) {
		$amplink = wp_get_canonical_url( $post_id );
		$amplink = add_query_arg( 'amp', 1, $amplink );
	}
	elseif( get_option( 'permalink_structure' ) != '' ) {
		$amplink = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( 'amp' );
	}
	else {
		$amplink = add_query_arg( 'amp', 1, get_permalink( $post_id ) );
	}
	return $amplink;
}
endif;

/*---------------------------------------------------------------------------
 * AMP の固定フロントページ ENDPOINT (FAKE)
 *---------------------------------------------------------------------------*/
if ( function_exists( 'set_fake_root_endpoint_for_amp' ) === false ):
function set_fake_root_endpoint_for_amp() {
	$page_on_front = wp_cache_get( 'page_on_front', 'luxe' );

	if( $page_on_front === false ) {
		$opts = wp_cache_get( 'alloptions', 'options' );
		wp_cache_set( 'page_on_front', $opts['page_on_front'], 'luxe' );

		$opts['show_on_front'] = 'posts';
		$opts['page_on_front'] = 0;
		wp_cache_replace( 'alloptions', $opts, 'options' );
	}
}
endif;

if ( function_exists( 'remove_fake_root_endpoint_for_amp' ) === false ):
function remove_fake_root_endpoint_for_amp( $page_on_front ) {
	$opts = wp_cache_get( 'alloptions', 'options' );
	$opts['show_on_front'] = 'page';
	$opts['page_on_front'] = $page_on_front;
	wp_cache_replace( 'alloptions', $opts, 'options' );
}
endif;

/*---------------------------------------------------------------------------
 * 画像の URL から attachemnt_id を取得する
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_get_image_id_from_url' ) === false ):
function thk_get_image_id_from_url( $attachment_url = '' ) {
	global $wpdb;

	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_url ) );

	if( empty( $attachment[0] ) ) {
		/***
		 Source: https://wpshout.com/links/get-wordpress-images-attachment-id-url-php-function-pippin-williamson/
		 ***/
		$attachment_id = false;

		// If there is no url, return.
		if( empty( $attachment_url ) ) {
			return false;
		}
		else {
			$attachment_url = str_replace( array( 'http:', 'https:'), '', $attachment_url );
		}

		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();
		$baseurl = str_replace( array( 'http:', 'https:'), '', $upload_dir_paths['baseurl'] );

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if( false !== strpos( $attachment_url, $baseurl ) ) {
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpe|jpeg|png|gif|bmp|webp)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace( $baseurl . '/', '', $attachment_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
		}
		return $attachment_id;
	}
       	return $attachment[0];
}
endif;

/*---------------------------------------------------------------------------
 * 画像の URL から画像情報を取得する
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_get_image_size' ) === false ):
function thk_get_image_size( $src ){
	$ret = false;

	if( stripos( $src, WP_CONTENT_URL ) !== false ) {
		$src = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $src );
	}
	else {
		return $ret;
	}

	$up_dir = wp_upload_dir();

	if( is_callable( 'getimagesize' ) === true ) {
		if( isset( $up_dir['baseurl'] ) && isset( $up_dir['basedir'] ) ) {
			$replace = str_replace( $up_dir['baseurl'], $up_dir['basedir'], $src );
			if( file_exists( $replace ) === true ) {
				$ret = getimagesize( $replace );
			}
		}
	}
	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * 画像の URL から srcset 付きの img タグを生成する
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_srcset_img_tag' ) === false ):
function thk_create_srcset_img_tag( $url, $alt = null, $cls = null, $prop_img = false, $prop_logo = false ) {
	global $luxe;

	$aid  = thk_get_image_id_from_url( $url );
	$meta = wp_get_attachment_metadata( $aid );

	if( $alt === null ) $alt = get_post( $aid )->post_title;
	$width = isset( $meta['width'] ) ? $meta['width'] : '';
	$height = isset( $meta['height'] ) ? $meta['height'] : '';

	if( empty( $width ) || empty( $height ) ) {
		if( function_exists( 'getimagesize' ) ) {
			$wp_upload_dir = wp_upload_dir();
			$image_path = str_replace( $wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $url );

			if( is_callable( 'getimagesize' ) === true && file_exists( $image_path ) === true ) {
				$sizes = getimagesize( $image_path );

				if( isset( $sizes[0] ) || isset( $sizes[1] ) ) {
					$width  = $sizes[0];
					$height = $sizes[1];
				}
			}
		}
	}

	$content = '<img src="' . $url . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" ';

	if( !empty( $cls ) ) {
		$content .= 'class="' . $cls . '" ';
	}

	if( $prop_img === true || $prop_logo === true ) {
		if( $prop_img === true && $prop_logo === true ) {
			$content .= 'itemprop="image logo" />';
		}
		elseif( $prop_logo === true ) {
			$content .= 'itemprop="logo" />';
		}
		else {
			$content .= 'itemprop="image" />';
		}
	}
	else {
		$content .= '/>';
	}

	$ret = wp_image_add_srcset_and_sizes( $content, $meta, $aid );

	if( isset( $luxe['amp'] ) ) {
		if( stripos( $ret, ' sizes=' ) === false ) {
			$ret = preg_replace( '/<img ([^>]+?)\s*\/*>/', '<amp-img layout="responsive" $1 sizes="(max-width:' . $width . 'px) 100vw,' . $width .'px"></amp-img>', $ret );
		}
		else {
			$ret = preg_replace( '/<img ([^>]+?)\s*\/*>/', '<amp-img layout="responsive" $1></amp-img>', $ret );
		}
	}
	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * 登録されてるサムネイルサイズの width と height の配列取得
 *---------------------------------------------------------------------------*/
/***
 Source: https://developer.wordpress.org/reference/functions/get_intermediate_image_sizes/
 ***/
function thk_get_image_sizes( $size = '' ) {
	require_once( INC . 'thumbnail-images.php' );
	thk_custom_image_sizes::custom_image_sizes( false );
	global $_wp_additional_image_sizes;

	$sizes = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {
		if( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
			$sizes[$_size]['width']  = (int)get_option( $_size . '_size_w' );
			$sizes[$_size]['height'] = (int)get_option( $_size . '_size_h' );
		}
		elseif( isset( $_wp_additional_image_sizes[$_size] ) ) {
			$sizes[ $_size ] = array( 
				'width'  => (int)$_wp_additional_image_sizes[$_size]['width'],
				'height' => (int)$_wp_additional_image_sizes[$_size]['height'],
			);
		}
	}

	// Get only 1 size if found
	if( !empty( $size ) ) {
		if( isset( $sizes[$size] ) ) {
			return $sizes[$size];
		}
		else {
			return false;
		}
	}
	return $sizes;
}

/*---------------------------------------------------------------------------
 * サムネイルが存在してるかどうかの判別
 * 存在しなかったら ajax 経由で thk_regenerate_thumbnails をコールして自動再作成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_thumbnail_exists' ) === false ):
function thk_thumbnail_exists( $attachment_id, $thumb = 'thumbnail' ) {
	$image_meta = wp_get_attachment_metadata( $attachment_id );

	if( !isset( $image_meta['sizes'][$thumb]['file'] ) ) {
		$exists = false;
		$image_sizes = thk_get_image_sizes();

		foreach( $image_sizes as $key => $val ) {
			if(
				( isset( $image_meta['width'] ) && isset( $val['width'] ) && (int)$image_meta['width'] === (int)$val['width'] ) && 
				( isset( $image_meta['height'] ) && isset( $val['height'] ) && (int)$image_meta['height'] === (int)$val['height'] )
			) $exists = true;
		}

		if( $exists === false ) {
			global $luxe;

			if( $luxe['jquery_load'] !== 'none' ) {
				// jQuery が有効な場合は ajax 経由でバックグラウンド処理
				add_filter( 'wp_footer', function() use( $attachment_id ) {
					thk_regenthumb_background_script_insert( $attachment_id );
				}, 999 );
				return false;
			}
			else {
				// jQuery が無効化されてる場合
				if( is_customize_preview() === true ) {
					thk_regenerate_thumbnails( $attachment_id );
					thk_flash();
				}
				else {
					add_action( 'shutdown', function() use( $attachment_id ) {
						thk_regenerate_thumbnails( $attachment_id );
						thk_flash();
					});
				}
			}
		}
	}
	else {
		// attachment_metadata が空っぽの場合
		$_wp_upload_dir = wp_upload_dir();
		if( isset( $_wp_upload_dir['basedir'] ) && isset( $image_meta['file'] ) ) {
			$thumb_file = $_wp_upload_dir['basedir'] . '/' . $image_meta['file'];
			$thumb_file = substr( $thumb_file, 0, strrpos( $thumb_file, '/' ) );
			$thumb_file .= '/' . $image_meta['sizes'][$thumb]['file'];

			if( file_exists( $thumb_file ) === false ) {
				global $luxe;

				if( $luxe['jquery_load'] !== 'none' ) {
					// jQuery が有効な場合は ajax 経由でバックグラウンド処理
					add_filter( 'wp_footer', function() use( $attachment_id ) {
						thk_regenthumb_background_script_insert( $attachment_id );
					}, 999 );
					return false;
				}
				else {
					// jQuery が無効化されてる場合
					if( is_customize_preview() === true ) {
						thk_regenerate_thumbnails( $attachment_id );
						thk_flash();
					}
					else {
						add_action( 'shutdown', function() use( $attachment_id ) {
							thk_regenerate_thumbnails( $attachment_id );
							thk_flash();
						});
					}
				}
			}
		}
	}
	return true;
}
endif;

/*---------------------------------------------------------------------------
 * サムネイルが存在しない場合の自動再作成
 *---------------------------------------------------------------------------*/
// ajax スクリプトを HTML に埋め込む
if( function_exists( 'thk_regenthumb_background_script_insert' ) === false ):
function thk_regenthumb_background_script_insert( $attachment_id ) {
	$attachment_nonce = wp_create_nonce( 'sec_' . $attachment_id );
?><script>var Regenthumb_jCheck=function(a){if(window.jQuery){a(jQuery)}else{window.setTimeout(function(){Regenthumb_jCheck(a)},100)}};Regenthumb_jCheck(function(a){jQuery(function($){$.ajax({type:'POST',cache:false,url:'<?php echo admin_url( "admin-ajax.php" ); ?>',data:{action:'regenthumb_background',id:<?php echo $attachment_id; ?>,attachment_nonce:'<?php echo $attachment_nonce; ?>'}});});});</script><?php
}
endif;

// ajax のアクションフック登録
if( function_exists( 'thk_ajax_regenthumb_background' ) === false ):
function thk_ajax_regenthumb_background() {
	if( isset( $_POST['attachment_nonce'] ) ) {
		$id = isset( $_POST['id'] ) ? (int)$_POST['id'] : null;
		if( empty( $id ) ) exit;

		// nonce チェック
		check_ajax_referer( 'sec_' . $id, 'attachment_nonce' );
		thk_regenerate_thumbnails( $id );
	}
	exit;
}
add_action( 'wp_ajax_regenthumb_background', 'thk_ajax_regenthumb_background' );
add_action( 'wp_ajax_nopriv_regenthumb_background', 'thk_ajax_regenthumb_background' );
endif;

// サムネイルの自動再作成処理
if( function_exists( 'thk_regenerate_thumbnails' ) === false ):
function thk_regenerate_thumbnails( $attachment_id ) {
	require_once( INC . 'thumbnail-images.php' );
	thk_custom_image_sizes::custom_image_sizes( false );

	if( function_exists( 'wp_generate_attachment_metadata' ) === false ) {
		require( ABSPATH . 'wp-admin/includes/image.php' );
	}
	$path = get_attached_file( $attachment_id );
	$meta = wp_generate_attachment_metadata( $attachment_id, $path );

	if( !empty( $meta ) && is_wp_error( $meta ) === false ) {
		wp_update_attachment_metadata( $attachment_id, $meta );
	}
}
endif;

/*---------------------------------------------------------------------------
 * ちっちゃいアイコン作成
 *---------------------------------------------------------------------------*/
if( function_exists('thk_create_icon') === false ):
function thk_create_icon() {
	$theme_path = TPATH === SPATH ? TPATH : SPATH;

	$ico_file = $theme_path . DSEP . 'images' . DSEP . 'favicon-min.png';
	$icon_url = has_site_icon() === true ? get_site_icon_url() : '';

	if( !empty( $icon_url ) ) {
		$icon_path = str_replace( home_url('/'), thk_get_home_path(), $icon_url );

		$image = wp_get_image_editor( $icon_path ); // Return an implementation that extends WP_Image_Editor

		if( is_wp_error( $image ) === false ) {
			$image->resize( 18, 18, true );
			$image->save( $ico_file );
		}
	}
}
add_action( 'customize_save_after', function() {
	// 外観カスタマイズに変更があった場合
	$theme_path = TPATH === SPATH ? TPATH : SPATH;
	$del_func = 'un' . 'link';
	@$del_func( $theme_path . DSEP . 'images' . DSEP . 'favicon-min.png' );
	thk_create_icon();
}, 70 );
endif;

/*---------------------------------------------------------------------------
 * シンタックスハイライターのショートコード一覧
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_syntax_highlighter_list' ) === false ):
function thk_syntax_highlighter_list() {
	return array(
		'highlight_markup'	=> 'HTML / XHTML',
		'highlight_apacheconf'	=> 'Apache Config',
		'highlight_aspnet'	=> 'ASP.NET',
		'highlight_autohotkey'	=> 'autoHotkey',
		'highlight_bash'	=> 'Bash',
		'highlight_basic'	=> 'Basic',
		'highlight_clike'	=> 'Clike',
		'highlight_c'		=> 'C',
		'highlight_cpp'		=> 'C++',
		'highlight_csharp'	=> 'C#',
		'highlight_css'		=> 'CSS',
		'highlight_diff'	=> 'Diff',
		'highlight_git'		=> 'Git',
		'highlight_java'	=> 'Java',
		'highlight_javascript'	=> 'Javascript',
		'highlight_json'	=> 'JSON',
		'highlight_nginx'	=> 'nginx',
		'highlight_perl'	=> 'Perl',
		'highlight_php'		=> 'PHP',
		'highlight_plsql'	=> 'PL/SQL',
		'highlight_python'	=> 'Python',
		'highlight_ruby'	=> 'Ruby',
		'highlight_sass'	=> 'Sass',
		'highlight_sql'		=> 'SQL',
		'highlight_vbnet'	=> 'VB.NET',
		'highlight_vim'		=> 'Vim',
	);
}
endif;

/*---------------------------------------------------------------------------
 * flash
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_flash' ) === false ):
function thk_flash() {
	if( ob_get_level() < 1 || ob_get_length() === false ) ob_start();
	if( ob_get_length() !== false ) {
	       	ob_flush();
	       	flush();
		ob_end_flush();
	}
}
endif;

/*---------------------------------------------------------------------------
 * CSSMin を使わない簡易 CSS 圧縮（動的に圧縮する必要がある時に使う）
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_simple_css_minify' ) === false ):
function thk_simple_css_minify( $css ){
	if( !empty( $css ) ) {
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
		$css = str_replace( '{ ', '{', str_replace( ' {', '{', str_replace( '} ', '}', str_replace( ' }', '}', str_replace( '; ', ';', str_replace( ';}', '}', $css ) ) ) ) ) );
	}
	return $css;
}
endif;

/*---------------------------------------------------------------------------
 * remote request ( wp_remote_request -> wp_filesystem )
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_remote_request' ) === false ):
function thk_remote_request( $url, $sslverify = false, $agent = null ){
	// 2段階で取得を試みる ( wp_remote_request -> wp_filesystem )

	$ret  = false;
	$code = 0;
	if( $agent === null ) $agent = $_SERVER['HTTP_USER_AGENT'];

	$results = wp_remote_request( $url, array(
		'timeout'	=> 30,
		'redirection'	=> 5,
		'compress'	=> true,  // 文字化け対策
		'sslverify'	=> $sslverify, // 悩ましい
		'user-agent'	=> $agent
	) );
	if( is_wp_error( $results ) === false ) {
		$code = wp_remote_retrieve_response_code( $results );

		if( $code !== 200 ) {
			$msg = wp_remote_retrieve_response_message( $results );
			$ret = array( $code, $msg );
		}
		else {
			$ret = wp_remote_retrieve_body( $results );
		}
	}

	/* この処理に来ることは、ほぼあり得ないけど、一応 $wp_filesystem->get_contents での取得も入れておく*/
	if( $ret === false ) {
		require_once( INC . 'optimize.php' );
		global $wp_filesystem;

		$filesystem = new thk_filesystem();
		if( $filesystem->init_filesystem( site_url() ) !== false ) {
			$ret = $wp_filesystem->get_contents( $url );
		}
	}

	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * thk_get_home_path ( get_home_path だと FULLPATH 取れないので )
 *---------------------------------------------------------------------------*/
if( function_exists('thk_get_home_path') === false ):
function thk_get_home_path() {
	$ret = str_replace( '/', DSEP, ABSPATH );

	$home_url = home_url('/');
	$site_url = site_url('/');

	if( !empty( $home_url ) && strcasecmp( $home_url, $site_url ) !== 0 ) {
		$home_path = str_replace( '/', DSEP, parse_url( $home_url, PHP_URL_PATH ) );
		$site_path = str_replace( '/', DSEP, parse_url( $site_url, PHP_URL_PATH ) );

		$pos = strripos( $ret, $site_path );
		$ret = substr( $ret, 0, $pos ) . $home_path;
	}

	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * remove URL
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_remove_url' ) === false ):
function thk_remove_url( $value ){
	$url_reg = '/(https?|ftp|HTTPS?|FTP)(:\/\/[-_\.!~*\'()a-zA-Z0-9;\/?:\@&;=+\$,%#]+)/';
	return  preg_replace( $url_reg, '', $value );
}
endif;

/*---------------------------------------------------------------------------
 * URL Encode と Convert
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_encode' ) === false ):
function thk_encode( $value ){
	return rawurlencode( thk_convert( $value ) );
}
endif;

if( function_exists( 'thk_convert' ) === false ):
function thk_convert( $value ){
	if( empty( $value ) ) return;
	if( stripos( $value, null ) !== false ) return;
	mb_language( 'Japanese' );
	$charcode = check_charcode( $value );
	if( $charcode !== null && $charcode !== 'UTF-8' ) {
		$value = mb_convert_encoding( $value, 'UTF-8', $charcode );
	}
	$detect = mb_detect_encoding( $value, 'ASCII,JIS,UTF-8,CP51932,SJIS-win', true );
	if( $detect !== false ) {
		return mb_convert_encoding( $value, 'UTF-8', $detect );
	}
	return $value;
}
endif;

// mb_detect_encoding でうまくいかない場合用
if( function_exists( 'check_charcode' ) === false ):
function check_charcode( $value ) {
	if( empty( $value ) ) return;
	$codes = array( 'UTF-8','SJIS-win','eucJP-win','ASCII','JIS','ISO-2022-JP-MS' );
	foreach( $codes as $charcode ){
		if( mb_convert_encoding( $value, $charcode, $charcode ) === $value ) {
			return $charcode;
		}
	}
	return null;
}
endif;

/*---------------------------------------------------------------------------
 * URL Decode
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_decode' ) === false ):
function thk_decode( $value ){
	while( $value !== rawurldecode( $value ) ) {
		$value = rawurldecode( $value );
	}
	return $value;
}
endif;

/*---------------------------------------------------------------------------
 * Punycode Encode
 *---------------------------------------------------------------------------*/
if( function_exists( 'puny_encode' ) === false ):
function puny_encode( $value ) {
	if( version_compare( PHP_VERSION, '5.4', '<' ) === true ) {
		return $value;
	}

	if( class_exists('Punycode') === true ) {
		$Punycode = new Punycode();

		if( method_exists( $Punycode, 'encode' ) === true ) {
			$parse = parse_url( $value );

			if( isset( $parse['host'] ) ) {
				$parse['host'] = $Punycode->encode( $parse['host'] );
				$value = http_build_url( $value, $parse );
			}
			else {
				$value = $Punycode->encode( $value );
			}
		}
	}

	return $value;
}
endif;

/*---------------------------------------------------------------------------
 * Punycode Decode
 *---------------------------------------------------------------------------*/
if( function_exists( 'puny_decode' ) === false ):
function puny_decode( $value ) {
	if( version_compare( PHP_VERSION, '5.4', '<' ) === true ) {
		return $value;
	}

	if( class_exists('Punycode') === true ) {
		$Punycode = new Punycode();

		if( method_exists( $Punycode, 'decode' ) === true ) {
			$parse = parse_url( $value );

			if( isset( $parse['host'] ) ) {
				$parse['host'] = $Punycode->decode( $parse['host'] );
				$value = http_build_url( $value, $parse );
			}
			else {
				$value = $Punycode->decode( $value );
			}
		}
	}

	return $value;
}
endif;

/*---------------------------------------------------------------------------
 * Error message
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_error_msg' ) === false ):
function thk_error_msg( $result ) {
	echo	'<div style="margin:50px 100px;font-weight:bold">'
	,	'<p>' . $result->get_error_message() . '</p>'
	,	'<p>' . $result->get_error_data() . '</p>'
	,	'</div>';
}
endif;

/*---------------------------------------------------------------------------
 * mb_substr_replace
 *---------------------------------------------------------------------------*/
if( function_exists( 'mb_substr_replace' ) === false ):
function mb_substr_replace( $str, $replace, $start, $length ){
	return mb_substr( $str, 0, $start ) . $replace . mb_substr( $str, $start + $length );
}
endif;

/*---------------------------------------------------------------------------
 * URLを組み立て(PECL の http_build_url 代替版)
 *---------------------------------------------------------------------------*/
if( function_exists( 'http_build_url' ) === false || function_exists( 'http_build_str') === false ) {
	require( INC . 'http-build-url.php' );
}
