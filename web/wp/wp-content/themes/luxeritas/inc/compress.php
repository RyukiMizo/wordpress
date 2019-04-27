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
require_once( INC . 'optimize.php' );
require_once( INC . 'web-font.php' );

/*---------------------------------------------------------------------------
 * CSS and Javascript 圧縮・結合
 *---------------------------------------------------------------------------*/
if( function_exists('thk_compress') === false ):
function thk_compress() {
	global $luxe, $wp_filesystem;

	require_once( INC . 'carray.php' );
	thk_default_set();

	thk_cleanup( true );
	thk_php_strip();

	$conf = new defConfig();
	$conf->set_luxe_variable();

	$optimize = new thk_optimize();
	$optimize->css_optimize( $optimize->css_optimize_init(), 'style.min.css', true );
	$optimize->css_async_optimize( $optimize->css_async_optimize_init(), true );

	$optimize->js_async_optimize();
	$optimize->js_search_highlight();

	thk_create_template_style();
	thk_create_editor_style();

	thk_create_manifest();
	thk_create_service_worker();

	if( isset( $luxe['amp_enable'] ) ) {
		thk_create_amp_style();
	}

	// jQuery 使用しないならここで終わり (同梱の Javascript が全て jQuery 依存なので、これ以降の処理は意味ない)
	if( $luxe['jquery_load'] === 'none' ) return;

	$optimize->js_defer_optimize();
	$optimize->jquery_optimize();

	return;
}
add_action( 'customize_save_after', 'thk_compress', 75 );
endif;

/*---------------------------------------------------------------------------
 * 親テーマのスタイルシートを子テーマに結合
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_parent_css_bind' ) === false ):
function thk_parent_css_bind() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$parent_css = TPATH . DSEP . 'style.min.css';
	$child_css  = SPATH . DSEP . 'style.css';
	$child_min  = SPATH . DSEP . 'style.min.css';

	$css    = '';
	$parent = '';
	$child  = '';

	if( is_child_theme() === false || get_theme_admin_mod( 'all_clear', false ) === true || $luxe['child_css_compress'] === 'none' ) {
		return;
	}
	elseif( $luxe['child_css_compress'] !== 'bind' ) {
		return thk_child_css_min( '' );
	}

	if( file_exists( $parent_css ) === true ) $parent = $wp_filesystem->get_contents( $parent_css );
	if( file_exists( $child_css  ) === true ) $child  = $wp_filesystem->get_contents( $child_css  );

	$css = trim( $parent ) . "\n/*! luxe child css */" . trim( $child );

	return thk_child_css_min( $css );
}
add_action( 'customize_save_after', 'thk_parent_css_bind', 80 );
endif;

/*---------------------------------------------------------------------------
 * 子テーマの CSS 圧縮・最適化 (カスタマイズ画面のプレビューでは圧縮されてない方を読み込む)
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_child_css_min' ) === false ):
function thk_child_css_min( $css = '' ) {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$style_min = SPATH . DSEP . 'style.min.css';

	if( empty( $css ) ) {
		$style_css = SPATH . DSEP . 'style.css';
		$css = $wp_filesystem->get_contents( $style_css );
	}

	$css = thk_cssmin( $css );

	$filesystem->file_save( $style_min, $css );

	return;
}
endif;

/*---------------------------------------------------------------------------
 * 子テーマの Javascript を圧縮・結合
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_child_js_comp' ) === false ):
function thk_child_js_comp() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	if( is_child_theme() === false || $luxe['child_js_compress'] === 'none' || $luxe['child_js_compress'] === 'noload' ) {
		$child_min = SPATH . DSEP . 'luxech.min.js';
		if( file_exists( $child_min ) === true ) {
			if( $wp_filesystem->delete( $child_min ) === false ) {
				$filesystem->file_save( $child_min, null );
			}
		}
		return;
	}

	$js = '';
	$child_js = SPATH . DSEP . 'luxech.js';

	if( file_exists( $child_js ) === true ) {
		$js .= $wp_filesystem->get_contents( $child_js );
		$js .= "\n";
	}

	$files = array();
	if( isset( $luxe['child_js_file_1'] ) ) $files[] = $luxe['child_js_file_1'];
	if( isset( $luxe['child_js_file_2'] ) ) $files[] = $luxe['child_js_file_2'];
	if( isset( $luxe['child_js_file_3'] ) ) $files[] = $luxe['child_js_file_3'];

	foreach( (array)$files as $value ) {
		if( strpos( $value, DSEP ) !== false || strpos( $value, '/' ) !== false ) continue;
		if( file_exists( SPATH . DSEP . $value . '.js' ) === true ) {
			$js .= $wp_filesystem->get_contents( SPATH . DSEP . $value . '.js' );
			$js .= "\n";
		}
	}
	$js = thk_jsmin( $js );

	$filesystem->file_save( SPATH . DSEP . 'luxech.min.js', $js );

	return ;
}
add_action( 'customize_save_after', 'thk_child_js_comp', 80 );
endif;

/*---------------------------------------------------------------------------
 * CSS をインラインで直接読み込む場合用の PATH 置換済み CSS を生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_inline_style' ) === false ):
function thk_create_inline_style() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$styles = array(
		TPATH . DSEP . 'style.css'	=> '',
		TPATH . DSEP . 'style.min.css'	=> '',
		SPATH . DSEP . 'style.css'	=> '',
		SPATH . DSEP . 'style.min.css'	=> ''
	);

	if( $luxe['child_css_compress'] !== 'bind' || TPATH === SPATH ) {
		if( isset( $luxe['parent_css_uncompress'] ) ) {
			$styles[TPATH . DSEP . 'style.css'] = TPATH . DSEP . 'style.replace.min.css';
		}
		else {
			$styles[TPATH . DSEP . 'style.min.css'] = TPATH . DSEP . 'style.replace.min.css';
		}
	}

	if( isset( $luxe['child_css'] ) && TPATH !== SPATH ) {
		if( $luxe['child_css_compress'] !== 'none' ) {
			$styles[SPATH . DSEP . 'style.min.css'] = SPATH . DSEP . 'style.replace.min.css';
		}
		else {
			$styles[SPATH . DSEP . 'style.css'] = SPATH . DSEP . 'style.replace.min.css';
		}
	}

	foreach( $styles as $in => $out ) {
		if( empty( $out ) ) continue;

		if( isset( $luxe['css_to_style'] ) ) {
			$conf = new defConfig();
			$save = '';
			$save = $wp_filesystem->get_contents( $in );

			if( stripos( $in, TPATH . DSEP ) !== false ) {
				$save = thk_path_to_root( $save, TDEL );
			}
			else {
				$save = thk_path_to_root( $save, SDEL );
			}
			$save = str_replace( '@charset "UTF-8";', '', $save );

			if( $filesystem->file_save( $out, $save ) === false ) return false;
		}
	}

	return true;
}
add_action( 'customize_save_after', 'thk_create_inline_style', 85 );
endif;

/*---------------------------------------------------------------------------
 * Amp 用 CSS 生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_amp_style' ) === false ):
function thk_create_amp_style() {
	global $luxe, $awesome, $wp_filesystem;

	$optimize = new thk_optimize();
	$contents = $optimize->css_amp_optimize( $optimize->css_amp_optimize_init(), true );

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$save = '';

	foreach( (array)$contents as $key => $val ) {
		$save .= $val;
	}

	// create web fonts stylesheet
	/*
	$webfont = new Create_Web_Font();
	$font_arr = $webfont->create_web_font_stylesheet();
	$save .= $font_arr['font_family'] . "\n";
	*/

	// design file css
	$save .= thk_read_design_style( 'style-amp.css' );

	// 管理画面でのカスタマイズ内容
	$luxe['amp_css'] = true;
	if( $luxe['column_style'] === '3column' ) {
		$luxe['column_style'] = '2column';
	}

	$css = trim( str_replace( array( '<style>', '</style>' ), '', thk_custom_css() ) );
	if( $css === '/*! luxe customizer css */' ) {
		$save .= '';
	}
	else {
		$css = str_replace( '/*! luxe customizer css */' . "\n", '/*! luxe customizer css */', $css );
		$css = str_replace( '!important', '', $css );
		$save .= $css;
	}

	$save = thk_path_to_root( $save, TDEL );
	$save = str_replace( '@charset "UTF-8";', '', $save );

	// Font Awesome version replace
	if( $awesome === 4 ) {
		$save = str_replace( array(
				'Font Awesome 5 Free',
				'Font Awesome 5 Brands',
			), 'Fontawesome', $save
		);
	}

	$save = thk_cssmin( $save );

	if( $filesystem->file_save( TPATH . DSEP . 'style-amp.min.css', $save ) === false ) return false;

	if( TDEL !== SDEL ) {
		$save = str_replace( '../', './', $wp_filesystem->get_contents( SPATH . DSEP . 'style-amp.css' ) );
		$save = thk_path_to_root( $save, SDEL );
		$save = thk_cssmin( $save );
		$save = "/*! luxe child css */" . trim( $save );

		if( $filesystem->file_save( SPATH . DSEP . 'style-amp.min.css', $save ) === false ) return false;
	}

	return true;
}
add_action( 'customize_save_after', 'thk_create_amp_style', 100 );
endif;

/*---------------------------------------------------------------------------
 * Editor CSS 生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_editor_style' ) === false ):
function thk_create_editor_style() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$save = '';
	$org  = '';

	if( function_exists( 'thk_custom_css' ) === false ) {
		require_once( INC . 'files.php' );
		require_once( INC . 'custom-css.php' );
	}

	if( isset( $luxe['luxe_mode_select'] ) ) {
		$mode_css_file = '';
		$thk_files = new thk_files();
		$files = $thk_files->styles();

		if( $luxe['luxe_mode_select'] === 'bootstrap' ) {
			$mode_css_file = $files['bootstrap'];
		}
		elseif( $luxe['luxe_mode_select'] === 'bootstrap4' ) {
			$mode_css_file = $files['bootstrap4'];
		}
		else {
			$mode_css_file = $files['luxe-mode'];
		}
	}
	else {
		$mode_css_file = $files['luxe-mode'];
	}

	$org .= $wp_filesystem->get_contents( $mode_css_file );

	// balloon css
	$contents = $wp_filesystem->get_contents( $files['balloon'] );
	require_once( INC . 'balloon-css-replace.php' );
	$org .= $contents;

	//$org .= $wp_filesystem->get_contents( TPATH . DSEP . 'style.css' );
	$org .= $wp_filesystem->get_contents( TPATH . DSEP . 'editor-style.css' );

	$org .= thk_custom_css();

	if( TPATH !== SPATH ) {
		if( isset( $luxe['design_file'] ) ) {
			$design_css = 'design' . DSEP . $luxe['design_file'] . DSEP . 'style.css';
			$design_editor_css = 'design' . DSEP . $luxe['design_file'] . DSEP . 'editor-style.css';

			if( file_exists( SPATH . DSEP . $design_css ) === true ) {
				$org .= $wp_filesystem->get_contents( SPATH . DSEP . $design_css );
			}

			if( file_exists( SPATH . DSEP . $design_editor_css ) === true ) {
				$org .= $wp_filesystem->get_contents( SPATH . DSEP . $design_editor_css );
			}
		}
	}

	if( TPATH !== SPATH ) {
		$org .= $wp_filesystem->get_contents( SPATH . DSEP . 'style.css' );
	}
	$org = thk_cssmin( $org );

	if( TPATH !== SPATH ) {
		$save .= $wp_filesystem->get_contents( SPATH . DSEP . 'editor-style.css' );
	}

	$save .= <<<EDITOR
body {
	color: #000;
	background: #fff;
	margin: 9px 10px;
}
body::before {
	width: 0;
	height: 0;
}
EDITOR;

	$save = $org . "\n/*! luxe editor css */" . thk_cssmin( $save );

	$path = TPATH === SPATH ? TPATH : SPATH;
	if( $filesystem->file_save( $path . DSEP . 'editor-style.min.css', $save ) === false ) return false;

	/*
	 * Gutenberg 用 CSS 生成
	 */
	$save = '';

	$webfont = new Create_Web_Font();
	$font_arr = $webfont->create_web_font_stylesheet();

	if( isset( $font_arr['font_family'] ) ) $font_family = $font_arr['font_family'];

	// 最大幅を実際のブログのコンテンツ幅に近づける
	$max_width = '100%';
	if( isset( $luxe['container_max_width'] ) && $luxe['container_max_width'] !== 0 ) {
		$max_width = (int)$luxe['container_max_width'];
		if( isset( $luxe['column_style'] ) && ( $luxe['column_style'] === '2column' || $luxe['column_style'] === '3column' ) ) {
			if( isset( $luxe['side_1_width'] ) && $luxe['side_1_width'] !== 0 ) {
				$max_width -= (int)$luxe['side_1_width'];
			}
			if( $luxe['column_style'] === '3column' && isset( $luxe['side_2_width'] ) && $luxe['side_2_width'] !== 0 ) {
				$max_width -= (int)$luxe['side_2_width'];
			}
		}
		if( isset( $luxe['cont_padding_left'] ) && $luxe['cont_padding_left'] !== 0 ) {
			$max_width -= (int)$luxe['cont_padding_left'];
		}
		if( isset( $luxe['cont_padding_right'] ) && $luxe['cont_padding_right'] !== 0 ) {
			$max_width -= (int)$luxe['cont_padding_right'];
		}
	}

	if( $max_width !== '100%' ) {
		if( $max_width < 610 ) $max_width = 610; // Gutenberg のデフォルト max-width: 610px より小さくはしない
		$max_width .= 'px';
	}

	$save .= <<<EDITOR
body {
	margin: 0;
	overflow: auto;
}
[type=submit], svg {
	max-width: unset;
	height: auto;
}
[type=submit].components-icon-button {
	display: flex;
	padding: 8px;
}
.wp-block {
	max-width: {$max_width};
}
.edit-post-visual-editor,
.edit-post-visual-editor .mce-content-body,
.edit-post-visual-editor .editor-block-list__block,
.edit-post-visual-editor .editor-block-list__block-edit,
.edit-post-visual-editor .editor-post-title__block,
.edit-post-visual-editor .editor-post-title__input {
	{$font_family}
}
.editor-post-title__block .editor-post-title__input {
	font-size: 24px; font-size: 2.4rem;
}
.wp-block-freeform.core-blocks-rich-text__tinymce {
	overflow: visible;
}
.edit-post-visual-editor .mce-content-body ul,
.edit-post-visual-editor .mce-content-body ol,
.edit-post-visual-editor .mce-content-body pre {
	margin: 0 0 1.6em;
}
.edit-post-visual-editor .mce-content-body ul,
.edit-post-visual-editor .mce-content-body ol {
	padding: 0 0 0 30px;
}
.edit-post-visual-editor .mce-content-body blockquote {
	border-left-color: #dddcd9;
}
p.meta-options {
	margin: 1em 0;
}
@media (min-width: 782px) {
	.edit-post-layout.is-sidebar-opened .edit-post-layout__content {
		margin-right: 320px;
	}
	.edit-post-layout.is-sidebar-opened .edit-post-plugin-sidebar__sidebar-layout, .edit-post-layout.is-sidebar-opened .edit-post-sidebar {
		width: 320px;
	}
	.edit-post-layout.is-sidebar-opened .components-notice-list {
		right: 320px;
	}
}

@media screen and ( max-width: 782px ) {
	.edit-post-layout__metaboxes:not(:empty) .edit-post-meta-boxes-area {
		margin: auto 0;
	}
}
EDITOR;

	$save = "/*! luxeritas gutenberg css */" . thk_cssmin( $save );
	if( $filesystem->file_save( TPATH . DSEP . 'editor-style-gutenberg.min.css', $save ) === false ) return false;

	return true;
}
add_action( 'customize_save_after', 'thk_create_editor_style', 110 );
endif;

/*---------------------------------------------------------------------------
 * manifest 生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_manifest' ) === false ):
function thk_create_manifest() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$file = THK_HOME_PATH . 'luxe-manifest.json';

	if( isset( $luxe['pwa_manifest'] ) ) {
		if( wp_is_writable( THK_HOME_PATH ) === true ) {
			if( file_exists( $file ) === true && wp_is_writable( $file ) === false ) {
				if( is_admin() === true ) {
					add_settings_error( 'luxe-custom', 'manifest', _is_writable_error_msg( $file, false ), 'error' );
				}
			}
			else {
				if( class_exists( 'create_pwd_files' ) === false ) {
					require( INC . 'create-pwd-files.php' );
				}

				$create = new create_pwd_files();
				$save = $create->create_manifest();

				if( $filesystem->file_save( $file, $save ) === false ) return false;
			}
		}
		else {
			if( is_admin() === true ) {
				add_settings_error( 'luxe-custom', 'manifest', _is_writable_error_msg( THK_HOME_PATH, false ), 'error' );
			}
		}
	}
	else {
		if( file_exists( $file ) === true ) {
			$wp_filesystem->delete( $file );
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * service worker 生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_service_worker' ) === false ):
function thk_create_service_worker() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$sw_file  = THK_HOME_PATH . 'luxe-serviceworker.js';
	$swr_file = TPATH . DSEP . 'js' . DSEP . 'luxe-serviceworker-regist.js';

	if( isset( $luxe['pwa_enable'] ) && is_ssl() === true ) {
		$credit   = '/*! Service Worker script for Wordpress Luxeritas Theme */' . "\n";

		if( wp_is_writable( THK_HOME_PATH ) === true ) {
			if( file_exists( $sw_file ) === true && wp_is_writable( $sw_file ) === false ) {
				if( is_admin() === true ) {
					add_settings_error( 'luxe-custom', 'serviceworker', _is_writable_error_msg( $sw_file, false ), 'error' );
				}
			}
			else {
				if( class_exists( 'create_pwd_files' ) === false ) {
					require( INC . 'create-pwd-files.php' );
				}

				$create = new create_pwd_files();

				$sw_save = $create->create_service_worker();
				$sw_save = $credit . thk_jsmin( $sw_save );

				if( $filesystem->file_save( $sw_file, $sw_save ) === false ) return false;

				if( file_exists( $swr_file ) === true && wp_is_writable( $swr_file ) === false ) {
					if( is_admin() === true ) {
						add_settings_error( 'luxe-custom', 'serviceworker', _is_writable_error_msg( $swr_file, false ), 'error' );
					}
				}
				else {
					$swr_save = $create->create_register_service_worker();
					$swr_save = $credit . thk_jsmin( $swr_save );
					if( $filesystem->file_save( $swr_file, $swr_save ) === false ) return false;
				}
			}
		}
		else {
			if( is_admin() === true ) {
				add_settings_error( 'luxe-custom', 'serviceworker', _is_writable_error_msg( THK_HOME_PATH, false ), 'error' );
			}
		}
	}
	else {
		if( file_exists( $sw_file ) === true ) $wp_filesystem->delete( $sw_file );
		if( file_exists( $swr_file ) === true ) $wp_filesystem->delete( $swr_file );
	}
}
endif;

/*---------------------------------------------------------------------------
 * Read design file
 *---------------------------------------------------------------------------*/
if( function_exists('thk_read_design_style') === false ):
function thk_read_design_style( $css_file_name ) {
	global $luxe, $wp_filesystem;

	$ret = '';

	if( isset( $luxe['design_file'] ) ) {
		$design_file  = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . $css_file_name;
		if( file_exists( $design_file ) === true ) {
			$design_style_contents = trim( $wp_filesystem->get_contents( $design_file ) );

			if( !empty( $design_style_contents ) ){
				// binary check
				if( stripos( $design_style_contents, null ) === false ) {;
					$ret .= '/*! luxe design file css */';
					$design_style_contents = thk_path_to_root( $design_style_contents, SDEL . '/design/' . $luxe['design_file'] );
					$ret .= $design_style_contents;
				}
			}
			unset( $design_style_contents );
		}
	}
	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * thk_php_strip
 *---------------------------------------------------------------------------*/
if( function_exists('thk_php_strip') === false ):
function thk_php_strip() {
	if( is_admin() === false ) {
		$cjphp = php_strip_whitespace( INC . 'create' . '-' . 'java' . 'script' . '.php' );
		$cjphp = preg_replace( '/\/\*.+?\*\//ism', '', $cjphp );
		$cjphp = preg_replace( '/\/\/.+?\n/im', '', $cjphp );

		if( substr_count( $cjphp, '{$ins' . '_func}') < 5 ) thk_shutdown();
		if( substr_count( $cjphp, '{$wt_' . 'txt[1]}') < 1 ) thk_shutdown();
	}
}
endif;

/*---------------------------------------------------------------------------
 * CSS 内の相対パスをルートから始まるURIに変換する処理
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_path_to_root' ) === false ):
function thk_path_to_root( $css, $theme_path ) {
	// url(data:～); url(http://～); url(https://～); の形を url のパス変換処理にかけないよう退避
	preg_match_all( "/url\(\s*([\"|']?)(data\:|http\:\/\/|https\:\/\/)[^\)]+?\)[^;|\}]*?[;|\}]/i", $css, $data_array );

	foreach( array_unique( $data_array[0] ) as $data ) {
		$css = str_replace( $data, md5( $data ), $css );
	}

	// css 内で ../ の形式で書かれた相対パスをルートから始まるURIに変換する
	$css_dir = str_replace( '//' . $_SERVER['HTTP_HOST'], '', $theme_path );
	$dir_explode = array_filter( explode( '/', $css_dir ) );

	$relative = '';
	$relative_array = array();

	foreach( $dir_explode as $val ) {
		$relative .= '/' . $val;
		$relative_array = array_merge( $relative_array, array( $relative => null ) );
	}

	$sep = '';
	$tmp_array = array();

	foreach( array_reverse( $relative_array ) as $key => $val ) {
		$tmp_array = array_merge( $tmp_array, array( $key => $sep ) );
		$sep .= '../';
	}

	$path = '';
	$relative_array = array_reverse( $tmp_array );

	foreach( $relative_array as $path => $val ) {
		$css = str_replace( $val, $path . '/', $css );
	}

	$css = str_replace( './', '', $css );

	// css 内で ../ の形式以外の相対パスをルートから始まるURIに変換する
	$css = preg_replace( "/(url\([\"|']?)((?:[^\/][A-z0-9]|\.\/).+?)([\"|']*\))/i", '${1}' . $path . '/' . '${2}${3}', $css );

	// url(data:～); url(http://～); url(https://～);  の形を元に戻す
	foreach( array_unique( $data_array[0] ) as $data ) {
		$css = str_replace( md5( $data ), $data, $css );
	}

	return $css;
}
endif;

/*---------------------------------------------------------------------------
 * テンプレートごとにカラム数が違う場合の3カラム用 CSS 生成
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_create_template_style' ) === false ):
function thk_create_template_style() {
	global $luxe, $wp_filesystem;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	$styles = array(
		'1column' => 'style.1col.min.css',
		'2column' => 'style.2col.min.css',
		'3column' => 'style.3col.min.css'
	);

	foreach( $styles as $key => $style ) {
		if(
			$luxe['column_home'] === '1column' || $luxe['column_post'] === '1column' || $luxe['column_page'] === '1column' || $luxe['column_archive'] === '1column' ||
			$luxe['column_home'] === '3column' || $luxe['column_post'] === '3column' || $luxe['column_page'] === '3column' || $luxe['column_archive'] === '3column' ||
			( $luxe['column3'] === '1column' && ( $luxe['column_home'] !== 'default' || $luxe['column_post'] !== 'default' || $luxe['column_page'] !== 'default' || $luxe['column_archive'] !== 'default' ) ) ||
			( $luxe['column3'] === '3column' && ( $luxe['column_home'] !== 'default' || $luxe['column_post'] !== 'default' || $luxe['column_page'] !== 'default' || $luxe['column_archive'] !== 'default' ) )
		) {
			require_once( INC . 'colors.php' );

			$conf = new defConfig();
			$colors_class = new thk_colors();
			$defaults = $conf->default_variables();
			$default_colors = $conf->over_all_default_colors();

			$save = format_media_query( thk_adjust_column_css( array(), $key, $defaults, $default_colors, $colors_class ), $defaults );

			if( $filesystem->file_save( TPATH . DSEP . $style, thk_cssmin( $save ) ) === false ) return false;
		}
	}
	return true;
}
endif;

/*---------------------------------------------------------------------------
 * CSS Compress
 *---------------------------------------------------------------------------*/
if( function_exists('thk_cssmin') === false ):
function thk_cssmin( $css ) {
	global $wp_filesystem;

	// get version number
	$ver = '1.00';
	$curent = wp_get_theme();
	$copyright = '';

	if( TDEL !== SDEL ) {
		$parent = wp_get_theme( $curent->get('Template') );
		$ver = $parent->get('Version');
	}
	else {
		$ver = $curent->get('Version');
	}

	$css = preg_replace( '/(\.woff|\.woff2|\.otf|\.eot|\.ttf|\.svg)\?[^\'|\)]+?([\'|\)])/ism', "$1$2", $css );
	$css = str_replace( '/*! luxe', '/* luxe', $css );
	$css = str_replace( '/*!', '/*', $css );
	$css = str_replace( '/* luxe', '/*! luxe', $css );

	if( class_exists('CSSminMinifier') === false ) {
		require( INC . 'cssmin.php' );
	}

	$minify = new CSSminMinifier();
	if( method_exists( $minify, 'run' ) === true ) {
		$css = trim( $minify->run( thk_convert( $css ) ) );
		$css = str_replace( array( "\r\n", "\r", "\n" ), '', $css );
		$css = str_replace( '/*!', "\n/*!", $css );
	}

	if( !empty( $css ) && stripos( $css, '/*!' ) !== false ) {
		$copyright = <<< COPYRIGHT
/*! Luxeritas WordPress Theme {$ver} - free/libre wordpress platform
 * @copyright Copyright (C) 2015 Thought is free. */
COPYRIGHT;
	}

	return $copyright . $css;
}
endif;

/*---------------------------------------------------------------------------
 * Javascript Compress
 *---------------------------------------------------------------------------*/
if( function_exists('thk_jsmin') === false ):
function thk_jsmin( $js ) {
	if( class_exists('JSMin') === false ) {
		require( INC . 'jsmin.php' );
	}
	$js = trim( JSMin::minify( thk_convert( $js ) ) );
	$js = str_replace( array("\r\n", "\r", "\n"), "\n", $js );
	return $js;
}
endif;

/*---------------------------------------------------------------------------
 * delete theme_mod that is no longer necessary
 *---------------------------------------------------------------------------*/
if( function_exists('thk_empty_remove') === false ):
function thk_empty_remove() {
	$conf = new defConfig();
	$luxe_defaults = $conf->default_variables();
	//$luxe_defaults = $conf->set_luxe_variable();

	//$mods = get_theme_mods();
	$mods = get_option( 'theme_mods_' . THEME );
	if( is_array( $mods ) === true ) {
		foreach( $mods as $key => $val) {
			if( $val === null ) remove_theme_mod( $key );
			if(
				( array_key_exists( $key, $luxe_defaults ) === false && is_array( $val ) === false ) ||
				( array_key_exists( $key, $luxe_defaults ) === true && $luxe_defaults[$key] == $val )
			) {
				remove_theme_mod( $key );
			}

			// theme_admin_mod に移行したので存在してたら消す（当面の間、残しとく）
			if( $key === 'thk_sidebars_widgets' ) {
				remove_theme_mod( $key );
			}
		}
	}
}
add_action( 'customize_save_after', 'thk_empty_remove', 90 );
endif;

/*---------------------------------------------------------------------------
 * thk_shutdown
 *---------------------------------------------------------------------------*/
if( function_exists('thk_shutdown') === false ):
function thk_shutdown() {
	if( is_admin() === false ) exit;
}
endif;

/*---------------------------------------------------------------------------
 * cleanup
 *---------------------------------------------------------------------------*/
if( function_exists('thk_cleanup') === false ):
function thk_cleanup( $file_only = false ) {
	global $wp_filesystem, $wpdb;

	$filesystem = new thk_filesystem();
	if( $filesystem->init_filesystem( site_url() ) === false ) return false;

	if( get_theme_admin_mod( 'all_clear', false ) !== false || $file_only === true ) {
		$del_files = array(
			TPATH . DSEP . 'style.min.css',
			TPATH . DSEP . 'style.async.min.css',
			TPATH . DSEP . 'style-amp.min.css',
			TPATH . DSEP . 'style.replace.min.css',
			TPATH . DSEP . 'style.1col.min.css',
			TPATH . DSEP . 'style.2col.min.css',
			TPATH . DSEP . 'style.3col.min.css',
			TPATH . DSEP . 'editor-style-gutenberg.min.css',
			TPATH . DSEP . 'plugins.min.css',

			TPATH . DSEP . 'js' . DSEP . 'luxe.min.js',
			TPATH . DSEP . 'js' . DSEP . 'luxe.async.min.js',

			TPATH . DSEP . 'js' . DSEP . 'jquery.luxe-migrate.min.js',	// ver2.5.3 以降未使用
			TPATH . DSEP . 'js' . DSEP . 'jquery.luxe.min.js',
			TPATH . DSEP . 'js' . DSEP . 'thk-highlight.min.js',
			TPATH . DSEP . 'js' . DSEP . 'luxe-serviceworker-regist.js',

			SPATH . DSEP . 'style.min.css',
			SPATH . DSEP . 'style-amp.min.css',
			SPATH . DSEP . 'style.replace.min.css',
			SPATH . DSEP . 'editor-style.min.css',
			SPATH . DSEP . 'luxech.min.js',

			ABSPATH . 'luxe-manifest.json',		// ver3.2.2 以降未使用
			ABSPATH . 'luxe-serviceworker.js',	// ver3.2.2 以降未使用

			THK_HOME_PATH . 'luxe-manifest.json',
			THK_HOME_PATH . 'luxe-serviceworker.js',
		);

		foreach( $del_files as $del_file ) {
			if( file_exists( $del_file ) === true ) {
				$wp_filesystem->delete( $del_file );
			}
		}

		// webfonts
		foreach( (array)glob( TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP . '*' ) as $del_file ) {
			if( stripos( $del_file, 'index.php' ) === false ) {
				$wp_filesystem->delete( $del_file );
			}
		}

		if( isset( $_POST['all_clear'] ) ) {
			// phrases
			foreach( (array)glob( SPATH . DSEP . 'phrases' . DSEP . '*.txt' ) as $del_file ) {
				$wp_filesystem->delete( $del_file );
			}

			// shortcodes
			foreach( (array)glob( SPATH . DSEP . 'shortcodes' . DSEP . '*.inc' ) as $del_file ) {
				$wp_filesystem->delete( $del_file );
			}
		}

		if( $file_only === true ) return;

		remove_theme_mods();
		remove_theme_admin_mods();
		remove_theme_phrase_mods();

		sns_count_cache_cleanup( true, true, false );
		blogcard_cache_cleanup( true, false );
	}
	else {
		if( get_theme_mod( 'sns_count_cache_cleanup', false ) !== false ) {
			remove_theme_mod( 'sns_count_cache_cleanup' );
			sns_count_cache_cleanup( false, true, false );
		}

		if( get_theme_mod( 'blogcard_cache_cleanup', false ) !== false ) {
			remove_theme_mod( 'blogcard_cache_cleanup' );
			remove_theme_mod( 'blogcard_cache_expire_cleanup' );
			blogcard_cache_cleanup( false, false );
		}
		elseif( get_theme_mod( 'blogcard_cache_expire_cleanup', false ) !== false ) {
			remove_theme_mod( 'blogcard_cache_expire_cleanup' );
			blogcard_cache_cleanup( false, true );
		}
	}
}
add_action( 'customize_save_after', 'thk_cleanup', 99 );
endif;
