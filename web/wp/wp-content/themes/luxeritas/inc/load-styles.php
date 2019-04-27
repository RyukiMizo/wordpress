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
 * Status check of Functions for CSS & Javascript Files
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_file_status_check' ) === false ):
function thk_file_status_check() {
	global $luxe, $fchk;

	// Remove wp_head And re-register only what is necessary for AMP
	if( isset( $luxe['amp'] ) ) {
		global $wp_filter;

		// WP 4.7 以上
		if( class_exists( 'WP_Hook' ) === true ) {
			unset( $wp_filter['wp_head'] );
			$wp_filter['wp_head'] = new WP_Hook();
		}
		// WP 4.7 未満
		else {
			$wp_filter['wp_head'] = array();
		}
		add_action( 'wp_head', 'wp_print_styles', 8 );
		add_action( 'wp_head', 'wp_print_styles', 8 );
		add_action( 'wp_head', 'wp_site_icon', 99 );
	}

	// File name definition array
	$load_files = array(
		// Stylesheet
		'p-style'	=> array( TPATH . DSEP . 'style.css', TDEL . '/style.css' ),
		'p-style-min'	=> array( TPATH . DSEP . 'style.min.css', TDEL . '/style.min.css' ),
		'p-async'	=> array( TPATH . DSEP . 'style.async.min.css', TDEL . '/style.async.min.css'),
		'p-amp'		=> array( TPATH . DSEP . 'style-amp.css', TDEL . '/style-amp.css'),
		'p-amp-min'	=> array( TPATH . DSEP . 'style-amp.min.css', TDEL . '/style-amp.min.css'),
		'p-replace'	=> array( TPATH . DSEP . 'style.replace.min.css', TDEL . '/style.replace.min.css' ),
		'p-1col'	=> array( TPATH . DSEP . 'style.1col.min.css', TDEL . '/style.1col.min.css' ),
		'p-2col'	=> array( TPATH . DSEP . 'style.2col.min.css', TDEL . '/style.2col.min.css' ),
		'p-3col'	=> array( TPATH . DSEP . 'style.3col.min.css', TDEL . '/style.3col.min.css' ),
		'c-style'	=> array( SPATH . DSEP . 'style.css', SDEL . '/style.css' ),
		'c-style-min'	=> array( SPATH . DSEP . 'style.min.css', SDEL . '/style.min.css' ),
		'c-amp'		=> array( SPATH . DSEP . 'style-amp.css', SDEL . '/style-amp.css'),
		'c-amp-min'	=> array( SPATH . DSEP . 'style-amp.min.css', SDEL . '/style-amp.min.css'),
		'c-replace'	=> array( SPATH . DSEP . 'style.replace.min.css', SDEL . '/style.replace.min.css' ),

		// Javascript
		'p-luxe-min'	=> array( TPATH . DSEP . 'js' . DSEP . 'luxe.min.js', TDEL . '/js/luxe.min.js' ),
		'p-luxe-async'	=> array( TPATH . DSEP . 'js' . DSEP . 'luxe.async.min.js', TDEL . '/js/luxe.async.min.js' ),
		'c-luxech'	=> array( SPATH . DSEP . 'luxech.js', SDEL . '/js/luxech.js' ),
		'c-luxech-min'	=> array( SPATH . DSEP . 'luxech.min.js', SDEL . '/js/luxech.js' ),

		// jQuery
		'jquery'	=> array( ABSPATH . WPINC . DSEP . 'js' . DSEP . 'jquery' . DSEP . 'jquery.js', null ),
		'jquery-m'	=> array( ABSPATH . WPINC . DSEP . 'js' . DSEP . 'jquery' . DSEP . 'jquery-migrate.min.js', null ),
		'jquery-check'	=> array( TPATH . DSEP . 'js' . DSEP . 'jquery.timestamp.check.js', TDEL . '/js/jquery.timestamp.check.js' ),
		'jquery-m-check'=> array( TPATH . DSEP . 'js' . DSEP . 'jquery-migrate.timestamp.check.js', TDEL . '/js/jquery-migrate.timestamp.check.js' )
	);

	$status = false;

	// Array for file status check
	$files = array(
		'pstyle'	=> array(
			'check'		=> $load_files['p-style-min'][0],
			'compare'	=> $load_files['p-style'][0]
		),
		'pamp'		=> array(
			'check'		=> $load_files['p-amp-min'][0],
			'compare'	=> $load_files['p-amp'][0]
		),
		'cstyle'	=> array(
			'check'		=> $load_files['c-style-min'][0],
			'compare'	=> $load_files['c-style'][0]
		),
		'camp'		=> array(
			'check'		=> $load_files['c-amp-min'][0],
			'compare'	=> $load_files['c-amp'][0]
		),
		'creplace'	=> array(
			'check'		=> $load_files['c-replace'][0],
			'compare'	=> $load_files['c-style'][0]
		),
		'pluxe'		=> array(
			'check'		=> $load_files['p-luxe-min'][0],
			'compare'	=> $load_files['p-style'][0]
		),
		'cluxech'	=> array(
			'check'		=> $load_files['c-luxech-min'][0],
			'compare'	=> $load_files['c-luxech'][0]
		),
		'jcheck'	=> array(
			'check'		=> $load_files['jquery-check'][0],
			'compare'	=> $load_files['jquery'][0]
		),
		'jmcheck'	=> array(
			'check'		=> $load_files['jquery-m-check'][0],
			'compare'	=> $load_files['jquery-m'][0]
		)
	);

	if( isset( $luxe['design_file'] ) ) {
		$files['dstyle'] = array(
			'check'		=> $load_files['p-style-min'][0],
			'compare'	=> SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . 'style.css'
		);
		$files['damp'] = array(
			'check'		=> $load_files['p-amp-min'][0],
			'compare'	=> SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . 'style-amp.css'
		);
	}

	// Status check of CSS & Javascript Files
	if( file_exists( $files['pstyle']['check'] ) === true && file_exists( $files['pstyle']['compare'] ) === true ) {
		$ft = filemtime( $files['pstyle']['check'] );
		if( $ft !== filemtime( $files['pstyle']['compare'] ) ) {
			$load_files['p-style-min'][1] .= '?v=' . $_SERVER['REQUEST_TIME'];
			$status = true;
		}
		else {
			$load_files['p-style-min'][1] .= '?v=' . $ft;
		}

		if( file_exists( $files['pamp']['check'] ) === true && file_exists( $files['pamp']['compare'] ) === true ) {
			if( $ft !== filemtime( $files['pamp']['compare'] ) ) {
				$status = true;
			}
		}

		if( isset( $luxe['design_file'] ) ) {
			if( file_exists( $files['dstyle']['compare'] ) === true && $ft < filemtime( $files['dstyle']['compare'] ) ) {
				$status = true;
			}
			if( file_exists( $files['damp']['compare'] ) === true && $ft < filemtime( $files['damp']['compare'] ) ) {
				$status = true;
			}
		}
	}

	if( file_exists( $files['cstyle']['check'] ) === true && file_exists( $files['cstyle']['compare'] ) === true ) {
		$ft = filemtime( $files['cstyle']['check'] );
		if( $ft !== filemtime( $files['cstyle']['compare'] ) ) {
			$load_files['c-style'][1] .= '?v=' . $_SERVER['REQUEST_TIME'];
			$load_files['c-style-min'][1] .= '?v=' . $_SERVER['REQUEST_TIME'];
			$status = true;
		}
		else {
			$load_files['c-style'][1] .= '?v=' . $ft;
			$load_files['c-style-min'][1] .= '?v=' . $ft;
		}
	}
	elseif( file_exists( $files['cstyle']['compare'] ) === true ) {
		$ft = filemtime( $files['cstyle']['compare'] );
		$load_files['c-style'][1] .= '?v=' . $ft;
	}

	if( file_exists( $files['camp']['check'] ) === true && file_exists( $files['camp']['compare'] ) === true ) {
		if( filemtime( $files['camp']['check'] ) !== filemtime( $files['camp']['compare'] ) ) {
			$status = true;
		}
	}

	if( file_exists( $files['pluxe']['check'] ) === true && file_exists( $files['pluxe']['compare'] ) === true ) {
		$ft = filemtime( $files['pluxe']['check'] );
		if( $ft !== filemtime( $files['pluxe']['compare'] ) ) {
			$load_files['p-luxe-min'][1] .= '?v=' . $_SERVER['REQUEST_TIME'];
			$status = true;
		}
		else {
			$load_files['p-luxe-min'][1] .= '?v=' . $ft;
		}
	}

	if( file_exists( $files['cluxech']['check'] ) === true && file_exists( $files['cluxech']['compare'] ) === true ) {
		if( filemtime( $files['cluxech']['check'] ) !== filemtime( $files['cluxech']['compare'] ) ) {
			$status = true;
		}
	}

	if( file_exists( $files['creplace']['check'] ) === true && file_exists( $files['creplace']['compare'] ) === true ) {
		if( filemtime( $files['creplace']['check'] ) !== filemtime( $files['creplace']['compare'] ) ) {
			$status = true;
		}
	}

	// Status check of jquery.js and jquery-migrate.min.js
	if( $luxe['jquery_load'] === 'luxeritas' ) {
		if( file_exists( $files['jcheck']['check'] ) === true && file_exists( $files['jcheck']['compare'] ) === true ) {
			if( filemtime( $files['jcheck']['check'] ) !== filemtime( $files['jcheck']['compare'] ) ) {
				$status = true;
			}
		}
		if( isset( $luxe['jquery_migrate_load'] ) ) {
			if( file_exists( $files['jmcheck']['check'] ) === true && file_exists( $files['jmcheck']['compare'] ) === true ) {
				if( filemtime( $files['jmcheck']['check'] ) !== filemtime( $files['jmcheck']['compare'] ) ) {
					$status = true;
				}
			}
		}
	}

	// File exists check
	if( file_exists( $load_files['p-style-min'][0] ) === false ) {
		$status = true;
	}

	if( $luxe['child_css_compress'] !== 'bind' ) {
		if( isset( $luxe['css_to_style'] ) ) {
			if( file_exists( $load_files['p-replace'][0] ) === false ) {
				$status = true;
			}
		}
	}

	if( TDEL !== SDEL ) {
		if( isset( $luxe['child_css'] ) && TDEL !== SDEL ) {
			if( $luxe['child_css_compress'] !== 'none' ) {
				if( file_exists( $load_files['c-style-min'][0] ) === false ) {
					$status = true;
				}
				if( isset( $luxe['css_to_style'] ) ) {
					if( file_exists( $load_files['c-replace'][0] ) === false ) {
						$status = true;
					}
				}
			}
		}
		if( isset( $luxe['amp_enable'] ) ) {
			if( file_exists( $load_files['p-amp-min'][0] ) === false ) {
				$status = true;
			}
			if( file_exists( $load_files['c-amp-min'][0] ) === false ) {
				$status = true;
			}
		}
	}

	if( $luxe['column_default'] === false ) {
		if( $luxe['column_style'] === '2column' ) {
			if( file_exists( $load_files['p-2col'][0] ) === false ) {
				$status = true;
			}
		}
		if( $luxe['column_style'] === '3column' ) {
			if( file_exists( $load_files['p-3col'][0] ) === false ) {
				$status = true;
			}
		}
	}

	if( file_exists( $load_files['p-async'][0] ) === false ) {
		$status = true;
	}

	if( $luxe['jquery_load'] !== 'luxeritas' ) {
		if(
			file_exists( $load_files['p-luxe-async'][0] ) === false ||
			file_exists( $load_files['p-luxe-min'][0] ) === false
		) {
			$status = true;
		}
	}

	if( !isset( $luxe['child_script'] ) ) {
		if( $luxe['child_js_compress'] === 'comp' ) {
			if( file_exists( $load_files['c-luxech-min'][0] ) === false ) {
				$status = true;
			}
		}
	}

	if( $status === true && is_customize_preview() === false ) {
		$fchk = true;
		thk_regenerate_files();
		thk_touch_files( $files );
	}

	return $load_files;
}
endif;

// Touch CSS & Javascript Files
if( function_exists( 'thk_touch_files' ) === false ):
function thk_touch_files( $files ) {
	global $wp_filesystem;

	//thk_regenerate_files( false, true );
	$filesystem = new thk_filesystem();
	$filesystem->init_filesystem();

	foreach( $files as $key => $value ) {
		if( file_exists( $value['check'] ) === true && file_exists( $value['compare'] ) === true ) {
			$chektime = filemtime( $value['check'] );
			$comptime = filemtime( $value['compare'] );

			if( $comptime > $chektime || $key === 'jcheck' || $key === 'jmcheck' ) {
				if( $wp_filesystem->touch( $value['check'], $comptime ) === false ) {
					if( defined( 'WP_DEBUG' ) === true && WP_DEBUG == true ) {
						$result = new WP_Error( 'File updating failed', 'Could not touch the file.', $value['check'] );
						thk_error_msg( $result );
					}
				}
			}
			else {
				if( $wp_filesystem->touch( $value['compare'], $chektime ) === false ) {
					if( defined( 'WP_DEBUG' ) === true && WP_DEBUG == true ) {
						$result = new WP_Error( 'File updating failed', 'Could not touch the file.', $value['compare'] );
						thk_error_msg( $result );
					}
				}
			}
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * CSS、Javascript のステータスチェック
 *---------------------------------------------------------------------------*/
$load_files = thk_file_status_check();

/*---------------------------------------------------------------------------
 * カスタマイズ画面プレビュー用の CSS
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_load_customize_preview' ) === false ):
function thk_load_customize_preview() {
	global $luxe, $awesome;

	// サーバー側で IO エラーが発生した場合は、各ファイルが require できてないので、require する。
	if( class_exists( 'thk_optimize' ) === false ) {
		require_once( INC . 'optimize.php' );
	}
	if( function_exists( 'thk_custom_css' ) === false ) {
		require_once( INC . 'carray.php' );
		require_once( INC . 'custom-css.php' );
	}
	if( class_exists( 'Create_Web_Font' ) === false ) {
		require_once( INC . 'web-font.php' );
	}

	$optimize = new thk_optimize();
	$files = $optimize->css_optimize_init();

	foreach( $files as $key => $val ) {
		$ver = file_exists( $val ) === true ? filemtime( $val ) : $_SERVER['REQUEST_TIME'];
		$val = str_replace( DSEP, '/', str_replace( TPATH, TDEL, $val ) );
		wp_enqueue_style( $key, $val . '?v=' . $ver, false, array(), 'all' );
	}

	/* アイコンフォント (プレビュー) */
	if( $luxe['awesome_load_css'] === 'async' ) {
		if( $awesome === 4 ) {
			wp_enqueue_style( 'awesome', TDEL . '/css/fontawesome4.css', false, array(), 'all' );
		}
		else {
			wp_enqueue_style( 'awesome', TDEL . '/css/fontawesome5.css', false, array(), 'all' );
		}
		wp_enqueue_style( 'icomoon', TDEL . '/css/icomoon.css', false, array(), 'all' );
	}

	/* design file css (プレビュー) */
	if( isset( $luxe['design_file'] ) && file_exists( SPATH . '/design/' . $luxe['design_file'] . '/style.css' ) === true ) {
		wp_enqueue_style( 'luxe-design', SDEL . '/design/' . $luxe['design_file'] . '/style.css' , false, array(), 'all' );
		$files['luxe-design'] = true;
	}

	/* カスタマイズした CSS (プレビュー用) */
	end( $files );
	$last_css = key( $files );
	wp_add_inline_style( $last_css, thk_custom_css() );

	/* Font Awesome 4 が使われてる箇所をカスタマイズプレビュー用に置換 */
	if( $awesome === 4 ) {
		$awesome_replace = <<< AWESOME4
#head-search button[type=submit]:before,
.band-menu .menu-item a::before,
#layer li a::before {
	font-family: FontAwesome;
}
.search-field::-webkit-input-placeholder {
	font-family: FontAwesome;
}
.search-field:-moz-placeholder {
	font-family: FontAwesome;
}
.search-field:-ms-input-placeholder {
	font-family: FontAwesome;
}
.search-field:placeholder-shown {
	font-family: FontAwesome;
}
@media (min-width: 992px){
	#gnavi ul ul > li[class*="children"] > a > span::after {
		font-family: FontAwesome;
	}
}

AWESOME4;
		wp_add_inline_style( $last_css, $awesome_replace );
	}

	/* Web font のフォントファミリー */
	$webfont = new Create_Web_Font();
	$font_arr = $webfont->create_web_font_stylesheet();
	wp_add_inline_style( $last_css, $font_arr['font_family'] );
}
endif;

if( is_customize_preview() === true ) {
	thk_load_customize_preview();
}
/*---------------------------------------------------------------------------
 * 実体の CSS
 *---------------------------------------------------------------------------*/
else {
	if( !isset( $luxe['amp'] ) ) {
		/* Gutenberg のブロックスタイル */
		if( isset( $luxe['wp_block_library_load'] ) ) {
			if( $luxe['wp_block_library_load'] === 'inline' || $luxe['wp_block_library_load'] === 'none' ) {
				add_action( 'wp_enqueue_scripts', function() use( $luxe ) {
					wp_deregister_style( 'wp-block-library-theme' );
					wp_register_style( 'wp-block-library-theme', '' );
					if( $luxe['wp_block_library_load'] === 'inline' ) {
						$block_library = '';
						$block_library_style = '';
						$block_library_theme = '';

						// WP 5.0 未満
						if( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) === true ) {
							// Gutenberg プラグインが入ってる場合
							$block_library_style = WP_PLUGIN_DIR . '/gutenberg/build/block-library/style.css';
							$block_library_theme = WP_PLUGIN_DIR . '/gutenberg/build/block-library/theme.css';
						}
						// WP 5.0 以上
						else {
							$block_library_style = ABSPATH . WPINC . '/css/dist/block-library/style.min.css';
							$block_library_theme = ABSPATH . WPINC . '/css/dist/block-library/theme.min.css';
						}

						if( file_exists( $block_library_style ) === true ) {
							$block_library .= thk_direct_style( $block_library_style );
						}
						if( file_exists( $block_library_theme ) === true ) {
							$block_library .= thk_direct_style( $block_library_theme );
						}

						if( !empty( $block_library ) ) {
							wp_add_inline_style( 'wp-block-library-theme', $block_library );
						}
					}
				}, 99 );
			}
		}

		/* 親テーマの CSS 読み込み(実体) */
		if( $luxe['child_css_compress'] !== 'bind' || TPATH === SPATH ) {
			if( file_exists( $load_files['p-style-min'][0] ) === true && filesize( $load_files['p-style-min'][0] ) !== 0 ) {
				wp_enqueue_style( 'luxe', $load_files['p-style-min'][1], false, array(), 'all' );
				if( isset( $luxe['css_to_style'] ) ) {
					wp_add_inline_style( 'luxe', thk_direct_style( $load_files['p-replace'][0] ) );
				}
			}
			else {
				thk_load_customize_preview();
			}
		}

		/* 子テーマの CSS はプラグインの CSS より後に読み込むので load_header.php で処理 */

		/* noscript css */
		// グローバルナビの CSS ( noscript 用 )
		$fle = '/styles/nav.min.css';
		$ver = file_exists( TPATH . $fle ) === true ? filemtime( TPATH . $fle ) : $_SERVER['REQUEST_TIME'];
		wp_enqueue_style( 'nav', TDEL . $fle . '?v=' . $ver, false, array(), 'all' );

		// 非同期で読み込む CSS ( noscript 用 )
		if( file_exists( $load_files['p-async'][0] ) === true && filesize( $load_files['p-async'][0] ) !== 0 ) {
			wp_enqueue_style( 'async', $load_files['p-async'][1] . '?v=' . filemtime( $load_files['p-async'][0] ), array(), 'all' );
		}
	}
}

/* テンプレートごとに違うカラム数にしてる場合の 3カラム CSS
 * (親子 CSS 結合時はデザインが崩れるため、子テーマより後に読み込ませる -> load_header.php で処理 )
 */
if( $luxe['child_css_compress'] !== 'bind' && !isset( $luxe['amp'] ) ) {
	if( $luxe['column_default'] === false ) {
		if( $luxe['column_style'] === '1column' ) {
			wp_enqueue_style( 'luxe1', $load_files['p-1col'][1], false, array(), 'all' );
			wp_add_inline_style( 'luxe1', thk_direct_style( $load_files['p-1col'][0] ) );
		}
		if( $luxe['column_style'] === '2column' ) {
			wp_enqueue_style( 'luxe2', $load_files['p-2col'][1], false, array(), 'all' );
			wp_add_inline_style( 'luxe2', thk_direct_style( $load_files['p-2col'][0] ) );
		}
		if( $luxe['column_style'] === '3column' ) {
			wp_enqueue_style( 'luxe3', $load_files['p-3col'][1], false, array(), 'all' );
			wp_add_inline_style( 'luxe3', thk_direct_style( $load_files['p-3col'][0] ) );
		}
	}
}

/*---------------------------------------------------------------------------
 * Javascript 類
 *---------------------------------------------------------------------------*/
if( stripos( $_SERVER['REQUEST_URI'], 'embed' ) !== false ) {
	/* Embed かどうかのチェック (Embed の場合は Javascript 不要なので読み込まないようにする) */
	$embed = substr( rtrim(  $_SERVER['REQUEST_URI'], '/' ), -10 );
	if( $embed !== 'embed=true' ) {
		$embed = substr( $embed, -5 );
		if( $embed !== 'embed' ) unset( $embed );
	}
}

if( !isset( $luxe['amp'] ) && !isset( $embed ) ) {
	/* Asynchronous Javascript ( jQuery と結合してる場合は読み込まない) */
	if( $luxe['jquery_load'] !== 'luxeritas' ) {
		if( file_exists( $load_files['p-luxe-async'][0] ) === true && filesize( $load_files['p-luxe-async'][0] ) !== 0 ) {
			wp_enqueue_script( 'async', $load_files['p-luxe-async'][1] . '?v=' . filemtime( $load_files['p-luxe-async'][0] ), array(), false, false );
		}
	}

	/* jQuery */
	if( $luxe['jquery_load'] !== 'none' ) {
		if( file_exists( $load_files['p-luxe-min'][0] ) === true ) {
			$p_luxe_min_check = thk_fgc( $load_files['p-luxe-min'][0] );
			if(
				stripos( $p_luxe_min_check, 'in' . 'sert_' . 'luxe' ) === false ||
				stripos( $p_luxe_min_check, "['bl" . "ack','wh" . "ite']:['wh" . "ite','bl" . "ack']" ) === false
			) wp_die();
			unset( $p_luxe_min_check );
		}

		//wp_enqueue_script( 'jquery' );
		if( $luxe['jquery_load'] !== 'wordpress' ) {
			$func = 'wp' . '_deregister' . '_script';
			$func( 'jquery' );
			$func( 'jquery-core' );

			if( !isset( $luxe['jquery_migrate_load'] ) || $luxe['jquery_load'] === 'luxeritas' ) {
				$func( 'jquery-migrate' );
			}

			$cdn = '//ajax.googleapis.com/ajax/libs/jquery/';
			switch( $luxe['jquery_load'] ) {
				case 'google1':
					wp_register_script( 'jquery', $cdn . '1.12.4/jquery.min.js', array(), false, false );
				case 'google2':
					wp_register_script( 'jquery', $cdn . '2.2.4/jquery.min.js', array(), false, false );
				case 'google3':
					wp_register_script( 'jquery', $cdn . '3.3.1/jquery.min.js', array(), false, false );
				case 'luxeritas':
					$uri = '/js/jquery.luxe.min.js';
					if( isset( $luxe['jquery_migrate_load'] ) ) {
						$uri .= '?migrate=1&';
					}
					else {
						$uri .= '?';
					}
					$ver = file_exists( $load_files['p-luxe-min'][0] ) === true ? filemtime( $load_files['p-luxe-min'][0] ) : $_SERVER['REQUEST_TIME'];
					wp_register_script( 'jquery', TDEL . $uri . 'v=' . $ver, array(), false, false );
				default:
					if( $luxe['jquery_load'] !== 'none' ) {
						wp_enqueue_script( 'jquery' );
						if( isset( $luxe['jquery_migrate_load'] ) ) {
							wp_enqueue_script( 'jquery-migrate' );
						}
					}
					break;
			}
		}
		else {
			wp_enqueue_script( 'jquery' );
		}

		/* luxe.min.js ( jQuery と結合してる場合は読み込まない )
		 * カスタマイズプレビューはフッターで各スクリプトごとに読み込み (カスタマイズ内容によって読み込むスクリプトが異なるため)
		 */
		if( is_customize_preview() === false ) {
			if( $luxe['jquery_load'] !== 'none' && $luxe['jquery_load'] !== 'luxeritas' ) {
				wp_enqueue_script( 'luxe', $load_files['p-luxe-min'][1], array('jquery'), false, false );
			}
		}

		if( $luxe['bootstrap_js_load_type'] !== 'none' ) {
			/* Load bootstrap.js */
			if( $luxe['luxe_mode_select'] === 'bootstrap4' ) {
				wp_enqueue_script( 'bootstrap', TDEL . '/js/bootstrap4/bootstrap.min.js', array('jquery'), false, false );
			}
			else {
				wp_enqueue_script( 'bootstrap', TDEL . '/js/bootstrap3/bootstrap.min.js', array('jquery'), false, false );
			}
		}

		if(
			is_singular() === true ||
			( isset( $luxe['list_view'] ) && $luxe['list_view'] === 'content' ) ||
			( isset( $luxe['sticky_no_excerpt'] ) && $luxe['sticky_no_excerpt'] && is_sticky() === true )
		) {
			/* Image Gallery */
			if( $luxe['gallery_type'] === 'tosrus' ) {
				add_filter( 'the_content', 'add_tosrus', 11 );
			}
			elseif( $luxe['gallery_type'] === 'lightcase' ) {
				add_filter( 'the_content', 'add_lightcase', 11 );
			}
			elseif( $luxe['gallery_type'] === 'fluidbox' ) {
				add_filter( 'the_content', 'add_fluidbox', 11 );
			}
		}

		/* Search Highlight */
		if( is_search() === true && isset( $luxe['search_highlight'] ) ) {
			$fle = '/js/thk-highlight.min.js';
			$ver = file_exists( TPATH . $fle ) === true ? filemtime( TPATH . $fle ) : $_SERVER['REQUEST_TIME'];
			wp_enqueue_script( 'thk-highlight', TDEL . '/js/thk-highlight.min.js?v=' . $ver, array('jquery'), false, false );
		}
	}
}

/* カテゴリとアーカイブの件数 A タグを内側にするかどうかのやつ */
if( isset( $luxe['categories_a_inner'] ) ) {
	add_filter( 'wp_list_categories', 'thk_list_categories_archives', 10, 2 );
}
if( isset( $luxe['archives_a_inner'] ) ) {
	add_filter( 'get_archives_link', 'thk_list_categories_archives', 10, 2 );
}
