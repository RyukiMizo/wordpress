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

if( class_exists( 'Web_Font' ) === false ):
class Web_Font {
	public function __construct() {
	}

	public static $webfont = array(
		'roboto'		=> true,
		'robotoslab'		=> true,
		'opensans'		=> true,
		'sourcesanspro'		=> true,
		'notosans'		=> true,
		'nunito'		=> true,
		'merriweather'		=> true,
		'vollkorn'		=> true,
		'sortsmillgoudy'	=> true,
		'notosansjapanese'	=> true,
		'mplus1p'		=> true,
		'roundedmplus1c'	=> true,
		'sawarabigothic'	=> true,
		'sawarabimincho'	=> true,
	);

	public static $alphabet = array(
		'roboto'		=> array(
			'Roboto',
			'https://fonts.googleapis.com/css?family=Roboto',
		),
		'robotoslab'		=> array(
			'Roboto Slab',
			'https://fonts.googleapis.com/css?family=Roboto+Slab',
		),
		'opensans'		=> array(
			'Open Sans',
			'https://fonts.googleapis.com/css?family=Open+Sans',
		),
		'sourcesanspro'		=> array(
			'Source Sans Pro',
			'https://fonts.googleapis.com/css?family=Source+Sans+Pro',
		),
		'notosans'		=> array(
			'Noto Sans',
			'https://fonts.googleapis.com/css?family=Noto+Sans',
		),
		'nunito'		=> array(
			'Nunito',
			'https://fonts.googleapis.com/css?family=Nunito',
		),
		'merriweather'		=> array(
			'Merriweather',
			'https://fonts.googleapis.com/css?family=Merriweather',
		),
		'vollkorn'		=> array(
			'Vollkorn',
			'https://fonts.googleapis.com/css?family=Vollkorn',
		),
		'sortsmillgoudy'	=> array(
			'Sorts Mill Goudy',
			'https://fonts.googleapis.com/css?family=Sorts+Mill+Goudy',
		),
		'segoe-helvetica'	=> array(
			"Segoe UI', 'Verdana', 'Helvetica', 'Arial",
			null,
		),
		'verdana-helvetica'	=> array(
			"Verdana', 'Helvetica', 'Arial",
			null,
		),
		'arial'	=> array(
			"Arial', 'Verdana', 'Helvetica",
			null,
		),
		'none'	=> array(
			null,
			null,
		),
	);

	public static $japanese = array(
		'notosansjapanese'	=> array(
			'Noto Sans JP',
			'https://fonts.googleapis.com/css?family=Noto+Sans+JP',
		),
		'notoserifjapanese'	=> array(
			'Noto Serif JP',
			'https://fonts.googleapis.com/css?family=Noto+Serif+JP',
		),
		'kosugi'		=> array(
			'Kosugi',
			'https://fonts.googleapis.com/css?family=Kosugi',
		),
		'kosugimaru'		=> array(
			'Kosugi Maru',
			'https://fonts.googleapis.com/css?family=Kosugi+Maru',
		),
		'mplus1p'		=> array(
			'M PLUS 1p',
			'https://fonts.googleapis.com/css?family=M+PLUS+1p',
		),
		'roundedmplus1c'	=> array(
			'M PLUS Rounded 1c',
			'https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c',
		),
		'sawarabigothic'	=> array(
			'Sawarabi Gothic',
			'https://fonts.googleapis.com/css?family=Sawarabi+Gothic',
		),
		'sawarabimincho'	=> array(
			'Sawarabi Mincho',
			'https://fonts.googleapis.com/css?family=Sawarabi+Mincho',
		),
		'yu-sanfrancisco'	=> array(
			"Yu Gothic', -apple-system, 'BlinkMacSystemFont', '.SFNSDisplay-Regular', 'Hiragino Kaku Gothic Pro', 'Meiryo', 'MS PGothic",
			null,
		),
		'meiryo-sanfrancisco'	=> array(
			"Meiryo', -apple-system, 'BlinkMacSystemFont', '.SFNSDisplay-Regular', 'Hiragino Kaku Gothic Pro', 'Yu Gothic', 'MS PGothic",
			null,
		),
		'msp-sanfrancisco'	=> array(
			"MS PGothic', -apple-system, 'BlinkMacSystemFont', '.SFNSDisplay-Regular', 'Hiragino Kaku Gothic Pro', 'Yu Gothic', 'Meiryo",
			null,
		),
		'yu-hiragino'	=> array(
			"Yu Gothic', 'Hiragino Kaku Gothic Pro', 'Meiryo', 'MS PGothic",
			null,
		),
		'meiryo-hiragino'=> array(
			"Meiryo', 'Hiragino Kaku Gothic Pro', 'Yu PGothic', 'MS PGothic",
			null,
		),
		'msp-hiragino'	=> array(
			"MS PGothic', 'Hiragino Kaku Gothic Pro', 'Yu Gothic', 'Meiryo",
			null,
		),
		'yu-osaka'	=> array(
			"Yu Gothic', 'Osaka', 'Hiragino Kaku Gothic Pro', 'Meiryo', 'MS PGothic",
			null,
		),
		'meiryo-osaka'	=> array(
			"Meiryo', 'Osaka', 'Hiragino Kaku Gothic Pro', 'Yu PGothic', 'MS PGothic",
			null,
		),
		'msp-osaka'	=> array(
			"MS PGothic', 'Osaka', 'Hiragino Kaku Gothic Pro', 'Yu Gothic', 'Meiryo",
			null,
		),
		'none'	=> array(
			null,
			null,
		),
	);
}
endif;

if( class_exists( 'Create_Web_Font' ) === false ):
class Create_Web_Font {
	private $_filesystem = null;
	private $_font_wight = '400';

	public function __construct() {
		global $luxe, $wp_filesystem;

		if( $luxe['font_japanese'] === 'notosansjapanese' ) {
			$this->_font_wight = '200';
		}

		require_once( INC . 'optimize.php' );
		$this->_thk_files = new thk_files();

		// filesystem initialization
		$this->_filesystem = new thk_filesystem();
		if( $this->_filesystem->init_filesystem() === false ) return false;
	}

	/*
	 * create web font stylesheet
	 */
	public function create_web_font_stylesheet() {
		global $luxe, $wp_filesystem;

		$ret = array(
			'font_alphabet'	=> null,
			'font_japanese'	=> null,
			'font_family'	=> null
		);

		$web_font_dir = TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP;

		$ret['font_alphabet'] = $this->get_web_font_stylesheet( 'font_alphabet', Web_Font::$alphabet );
		$ret['font_japanese'] = $this->get_web_font_stylesheet( 'font_japanese', Web_Font::$japanese );

		if( stripos( $ret['font_alphabet'], 'font-display' ) === false ) {
			$ret['font_alphabet'] = preg_replace( '/@font-face\s*\{/ism', '@font-face { font-display: swap;', $ret['font_alphabet'] );
		}

		if( stripos( $ret['font_japanese'], 'font-display' ) === false ) {
			$ret['font_japanese'] = preg_replace( '/@font-face\s*\{/ism', '@font-face { font-display: swap;', $ret['font_japanese'] );
		}

		if( $ret['font_alphabet'] !== false || $ret['font_japanese'] !== false ) {
			if( isset( $luxe['font_priority'] ) ) {
				$ret['font_family'] = "'" . Web_Font::$alphabet[$luxe['font_alphabet']][0] . "','" . Web_Font::$japanese[$luxe['font_japanese']][0] . "'";
			}
			else {
				$ret['font_family'] = "'" . Web_Font::$japanese[$luxe['font_japanese']][0] . "','" . Web_Font::$alphabet[$luxe['font_alphabet']][0] . "'";
			}

			$ret['font_family'] = str_replace( "'',", '', $ret['font_family'] );
			$ret['font_family'] = str_replace( ",''", '', $ret['font_family'] );

			if( !empty( $ret['font_alphabet'] ) ) {
				$this->create_web_font_url_file( $ret['font_alphabet'], $web_font_dir . $luxe['font_alphabet'] );
			}
			if( !empty( $ret['font_japanese'] ) ) {
				$this->create_web_font_url_file( $ret['font_japanese'], $web_font_dir . $luxe['font_japanese'] );
			}

			// create font family
			if( $ret['font_family'] !== "''" ) {
				$ret['font_family'] = 'font-family:' . $ret['font_family'] . ',sans-serif;';
			}
			else {
				$ret['font_family'] = 'font-family: sans-serif;';
			}
			$ret['font_family'] .= 'font-weight:' . $this->_font_wight . ';';
			//$ret['font_family'] .= '}';
		}
		return $ret;
	}

	/*
	 * get web font stylesheet
	 */
	public function get_web_font_stylesheet( $type, $arr ) {
		global $luxe, $wp_filesystem;

		if( isset( $luxe[$type] ) && $luxe[$type] === 'none' ) return false;

		$ret = '';
		$web_font_dir = TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP;

		foreach( $arr as $key => $val) {
			$css_file = $web_font_dir . $key;

			if( isset( $luxe[$type] ) && $luxe[$type] === $key && !empty( $val[1] ) ) {
				// Web フォントの CSS が無いか、1日以上古い場合は再ダウンロード
				if(
					file_exists( $css_file ) === false ||
					( file_exists( $css_file ) === true && filemtime( $css_file ) < $_SERVER['REQUEST_TIME'] - 86400 )
				) {
					$ret = thk_remote_request( $val[1] );

					if( $this->_filesystem->file_save( $css_file . '.css', $ret ) === false ) return false;
				}
			}
			else {
				if( file_exists( $css_file ) ) {
					if( $wp_filesystem->delete( $css_file ) === false ) {
						$this->_filesystem->file_save( $css_file, null );
					}
				}
				if( file_exists( $css_file . '.css' ) ) {
					if( $wp_filesystem->delete( $css_file . '.css' ) === false ) {
						$this->_filesystem->file_save( $css_file . '.css', null );
					}
				}
			}
		}
		return $ret;
	}

	/*
	 * create web font url file
	 */
	public function create_web_font_url_file( $css, $save_file ) {
		$candidatus = '';
		$weight = false;

		if( substr_count( $css, 'font-weight' ) <= 1 ) {
			$weight = true;
		}
		$matches = explode( "\n", $css );

		foreach( $matches as $val ) {
			if( stripos( $val, 'font-weight' ) !== false && stripos( $val, $this->_font_wight ) !== false ) {
				$weight = true;
			}
			if( $weight === false ) continue;
			if( stripos( $val, '//' ) === false ) continue;
			if(
				stripos( $val, '.woff' ) === false &&
				stripos( $val, '.otf' )  === false &&
				stripos( $val, '.ttf' )  === false
			) continue;
			$candidatus = str_replace( array( '.woff2', '.woff', '.otf', '.ttf' ), '', $val );
			$candidatus = preg_replace( '/.*((http:|https:)*\/\/[^\)]+?)[\'|\"]*\)\s+.*/', "$1", $candidatus );
			if( !empty( $candidatus ) ) break;
		}

		$type = '.ttf';
		if( stripos( $css, '.woff2' ) !== false )	$type = '.woff2';
		elseif( stripos( $css, '.woff' ) !== false )	$type = '.woff';
		elseif( stripos( $css, '.otf' ) !== false )	$type = '.otf';

		$candidatus .= $type;
		$candidatus = trim( $candidatus );

		if( $this->_filesystem->file_save( $save_file, $candidatus ) === false ) return false;
	}
}
endif;
