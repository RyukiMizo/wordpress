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

/*
 * TinyMCE ボタン登録
 */

/* TinyMCE Plugin CDN */
//cdn.tinymce.com/4/plugins/table/plugin.min.js
//cdn.tinymce.com/4/plugins/visualblocks/plugin.min.js
//cdn.tinymce.com/4/plugins/searchreplace/plugin.min.js

if( get_user_option( 'rich_editing' ) === 'true' ) {
	// TinyMCE のボタンをセットする関数
	if( function_exists( 'thk_mce_bottons_set' ) === false ):
	function thk_mce_bottons_set( $buttons, $buttons_array, $buttons_default, $buttons_all, $wp_adv = false ) {
		$buttons_new = array();

		// 返り値の $buttons_new にボタン配列を入れる
		foreach( $buttons_array as $key => $val ) {
			$buttons_new[] = $key;
		}

		/*
		foreach( $buttons_default as $key => $val ) {
			$search_key = array_search( $key, $buttons );
			if( $search_key !== false ) {
				unset( $buttons[$search_key] );
			}
		}
		*/

		// $buttons の value を key にした配列に変換 ( 上記の array_search がマイクロ秒単位だけど遅っせーから)
		$buttons_key_array = array();
		foreach( $buttons as $val ) {
			$buttons_key_array[$val] = true;
		}
		foreach( $buttons_default as $key => $val ) {
			if( isset( $buttons_key_array[$key] ) ) {
				unset( $buttons_key_array[$key] );
			}
		}
		// $buttons に含まれていて、$buttons_all にはないものを後ろに追加
		foreach( $buttons_key_array as $key => $val ) {
			if( $key === "wp_adv" || $key === "kitchensink" ) continue;
			if( !isset( $buttons_all[$key] ) ) $buttons_new[] = $key;
		}
		if( $wp_adv !== false ) $buttons_new[] = "wp_adv";

		return $buttons_new;
	}
	endif;

	$buttons_1 = get_theme_admin_mod( 'veditor_buttons_1' );
	$buttons_1_default = thk_mce_buttons_1();
	if( $buttons_1 === false ) {
		$buttons_1 = $buttons_1_default;
	}

	$buttons_2 = get_theme_admin_mod( 'veditor_buttons_2' );
	$buttons_2_default = thk_mce_buttons_2();
	if( $buttons_2 === false ) {
		$buttons_2 = $buttons_2_default;
	}

	$buttons_12  = (array)$buttons_1 + (array)$buttons_2;
	$buttons_all = $buttons_1_default + $buttons_2_default + thk_mce_buttons_d();

	// TinyMCE プラグインロード
	add_filter( 'mce_external_plugins', function( $plugins ) use( $buttons_12 ) {
		$plugins_key = array();	// in_array() 使わない対策
		foreach( $plugins as $val ) {
			$plugins_key[$val] = true;
		}

		// 定型文、ショートコード、ブログカード、TinyMCE 設定
		$thk_buttons = array(
			'thk-phrase-button',
			'thk-shortcode-button',
			'thk-blogcard-button',
			'thk-mce-settings-button',
		);
		foreach( $thk_buttons as $val ) {
			if( isset( $buttons_12[$val] ) ) {
				$plugins[$val] = TDEL . '/js/thk-dummy.js';	// 空っぽじゃダメらしいです
			}
		}

		// Luxeritas オリジナル絵文字
		if( isset( $buttons_12['thk-phrase-button'] ) ) {
			$plugins['thk_emoji'] = TDEL . '/js/tinymce/thk-emoji.min.js';
		}

		// RTL (右から左) と LTR (左から右)
		if( isset( $buttons_12['ltr'] ) || isset( $buttons_12['rtl'] ) ) {
			$plugins['directionality'] = TDEL . '/js/tinymce/directionality.min.js';
		}

		// その他
		foreach( $buttons_12 as $key => $val ) {
			if( isset( $buttons_12[$key] ) && !isset( $plugins_key[$key] ) ) {
				if( file_exists( TPATH . '/js/tinymce/' . $key . '.min.js' ) === true ) {
					$plugins[$key] = TDEL . '/js/tinymce/' . $key . '.min.js';
				}
			}
		}

		return $plugins;
	}, 536870912 );

	// TinyMCE 1段目フック
	add_filter( 'mce_buttons', function( $buttons ) use( $buttons_1, $buttons_1_default, $buttons_all ) {
		return thk_mce_bottons_set( $buttons, $buttons_1, $buttons_1_default, $buttons_all, true );
	}, 536870912 );

	// TinyMCE 2段目フック
	add_filter( 'mce_buttons_2', function( $buttons ) use( $buttons_2, $buttons_2_default, $buttons_all ) {
		return thk_mce_bottons_set( $buttons, $buttons_2, $buttons_2_default, $buttons_all );
	}, 536870912 );

	// 絵文字ボタン用ローカライゼーション
	add_action( 'admin_print_scripts', function() {
		wp_localize_script( 'mce-view', '_thkMceViewL10n', array( 'localize' => __( 'Emoji', 'luxeritas' ) ) );
	});

	// TinyMCE の初期化処理
	add_filter( 'tiny_mce_before_init', function( $settings ) {
		global $luxe;

		$settings['block_formats'] =
			  __( 'Paragraph <p>', 'luxeritas' ) . '=p;'
			. __( 'Block <div>', 'luxeritas' ) . '=div;'
			. __( 'Heading 2 <h2>', 'luxeritas' ) . '=h2;'
			. __( 'Heading 3 <h3>', 'luxeritas' ) . '=h3;'
			. __( 'Heading 4 <h4>', 'luxeritas' ) . '=h4;'
			. __( 'Heading 5 <h5>', 'luxeritas' ) . '=h5;'
			. __( 'Heading 6 <h6>', 'luxeritas' ) . '=h6;'
			. __( 'Blockquote <blockquote>', 'luxeritas' ) . '=blockquote;'
			. __( 'Preformatted <pre>', 'luxeritas' ) . '=pre;'
			. __( 'Address <address>', 'luxeritas' ) . '=address;'
		;

		$settings['fontsize_formats'] =
			  '10px 12px 14px 16px 18px 20px 24px 28px 32px 36px 42px '
			. '0.8em 0.9em 1.0em 1.1em 1.2em 1.3em 1.4em 1.5em 1.6em 1.7em 1.8em 1.9em 2.0em 2.1em 2.2em 2.3em 2.4em';

		$settings['font_formats'] =
			  __( 'Sans-serif', 'luxeritas' ) . '=sans-serif;'
			. __( 'serif', 'luxeritas' ) . '=serif;'
			. __( 'Monospaced font', 'luxeritas' ) . '=Consolas,Courier New,Courier,Lucida Console,Consolas,Inconsolata,Monaco,monospace,MS Gothic,Osaka-Mono;'
			. __( 'Yu Gothic', 'luxeritas' ) . '=Yu Gothic,YuGothic,YuGothicM,sans-serif;'
			. __( 'Yu Mincho', 'luxeritas' ) . '=Yu Mincho,YuMincho,serif;'
			. 'Andale Mono=andale mono,times;'
			. 'Arial=arial,helvetica,sans-serif;'
			. 'Arial Black=arial black,avant garde;'
			. 'Book Antiqua=book antiqua,palatino;'
			. 'Comic Sans MS=comic sans ms,sans-serif;'
			. 'Courier New=courier new,courier;'
			. 'Georgia=georgia,palatino;'
			. 'Helvetica=helvetica;'
			. 'Impact=impact,chicago;'
			. 'Tahoma=tahoma,arial,helvetica,sans-serif;'
			. 'Terminal=terminal,monaco;'
			. 'Times New Roman=times new roman,times;'
			. 'Trebuchet MS=trebuchet ms,geneva;'
			. 'Verdana=verdana,geneva;'
			. 'Webdings=webdings;'
			. 'Wingdings=wingdings,zapf dingbats;'
		;

		//$settings['theme']	= 'modern';
		//$settings['skin']	= 'lightgray';
		//$settings['indent']	= false;
		//$settings['keep_styles']	= false;
		//$settings['wpautop']	= true;
		//$settings['branding']	= false;
		//$settings['wp_autoresize_on'] = true;
		//$settings['wp_keep_scroll_position'] = false;
		//$settings['resize']	= false;
		if( isset( $luxe['mce_menubar'] ) ) {
			$settings['menubar'] = true;
		}
		if( isset( $luxe['mce_enter_key'] ) && $luxe['mce_enter_key'] === 'linefeed' ) {
			$settings['forced_root_block'] = false;
		}
		$settings['body_class']	= 'post';
		$settings['cache_suffix'] = 'v=' . $_SERVER['REQUEST_TIME'];
		$maxwidth = isset( $luxe['mce_max_width'] ) && ctype_digit( (string)$luxe['mce_max_width'] ) && $luxe['mce_max_width'] !== 0 ? $luxe['mce_max_width'] . 'px' : '100%';
		$bg_color = isset( $luxe['mce_bg_color'] ) ? $luxe['mce_bg_color'] : '#fff';
		$color    = isset( $luxe['mce_color'] ) ? $luxe['mce_color'] : '#000';
		$settings['content_style'] = 'body.mceContentBody{max-width:' . $maxwidth . ';background:' . $bg_color . ';color:' . $color . '}';

		return $settings;
	});

	$path = TDEL === SDEL ? TDEL : SDEL;

	/*
	add_action( 'admin_head', function() use( $path ) {
		echo '<link rel="preload" as="style" type="text/css" href="', $path, '/editor-style.min.css', '" />';
	}, 1 );
	*/

	// Gutenberg CSS
	add_action( 'enqueue_block_editor_assets', function() use( $path ) {
		wp_enqueue_style( 'editor-style', $path . '/editor-style.min.css?v=' . $_SERVER['REQUEST_TIME'], array() );
		wp_enqueue_style( 'editor-style-gutenberg', TDEL . '/editor-style-gutenberg.min.css?v=' . $_SERVER['REQUEST_TIME'], array( 'editor-style' ) );
		wp_enqueue_script( 'editor-style-js', TDEL . '/js/editor-style.js?v=' . $_SERVER['REQUEST_TIME'], array( 'wp-blocks' ) );
	});

	//add_editor_style( $path . '/editor-style.min.css' );
	add_filter( 'mce_css', function( $mce_css ) use( $path ) {
		$mce_css .= ',' . $path . '/editor-style.min.css';
		return $mce_css;
	}, 1 );
}
