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

if( class_exists( 'sns_cache' ) === false ):
class sns_cache {
	private $_wp_upload_dir		= null;
	private $_cache_dir		= null;
	private $_sns_count_cache	= null;
	private $_filesystem		= null;
	private $_ids_count		= 0;
	private $_idarray = array( 'f' => '!', 'g' => '!', 'h' => '!', 'l' => '!', 't' => '!', 'p' => '!' );

	public function __construct() {
		if( version_compare( PHP_VERSION, '5.4', '<' ) === false ) {
			if( class_exists( 'Punycode' ) === false ) {
				require( INC . 'punycode.php' );
				//use TrueBV\Punycode;
			}
		}
		require_once( INC . 'optimize.php' );
		global $wp_filesystem;

		$this->_filesystem = new thk_filesystem();
		if( $this->_filesystem->init_filesystem( site_url() ) === false ) return false;

		$this->_wp_upload_dir = wp_upload_dir();
		$this->_cache_dir = $this->_wp_upload_dir['basedir'] . '/luxe-sns/';
		if( $wp_filesystem->is_dir( $this->_cache_dir ) === false ) {
			/* ディレクトリが存在しなかったら作成 */
			if( wp_mkdir_p( $this->_cache_dir ) === false ) {
				if( $wp_filesystem->mkdir( $this->_cache_dir, FS_CHMOD_DIR ) === false && $wp_filesystem->is_dir( $this->_cache_dir ) === false ) {
					if( defined( 'WP_DEBUG' ) === true && WP_DEBUG == true ) {
						$result = new WP_Error( 'mkdir failed', __( 'Could not create cache directory.', 'luxeritas' ), $this->_cache_dir );
						thk_error_msg( $result );
					}
				}
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * 先に空のキャッシュファイルを作成しておく
	 *---------------------------------------------------------------------------*/
	public function touch_sns_count_cache( $url ) {
		global $wp_filesystem;

		$this->_sns_count_cache = $this->_cache_dir . md5( $url );
		if( file_exists( $this->_sns_count_cache ) === false ) {
			if( $wp_filesystem->touch( $this->_sns_count_cache ) === false ) {
				if( defined( 'WP_DEBUG' ) === true && WP_DEBUG == true ) {
					$result = new WP_Error( 'mkdir failed', __( 'Could not create cache file.', 'luxeritas' ), $this->_cache_dir );
					thk_error_msg( $result );
				}
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * SNS カウント数取得処理
	 *---------------------------------------------------------------------------*/
	public function create_sns_cache( $url = null ) {
		if( empty( $url ) ) return;

		$format_url = rawurlencode( puny_encode( thk_convert( $url ) ) );

		require_once( INC . 'sns-count.php' );
		$getcnt = new getSnsCount();

		foreach( $this->_idarray as $key => $val ) {
			switch( $key ) {
				case 'f':
					global $luxe;
					$this->_idarray['f'] = $getcnt->facebookCount( $format_url, $luxe['sns_fb_appid'], $luxe['sns_fb_appsec'], $luxe['sns_fb_apptoken'] );
					break;
				case 'g':
					$this->_idarray['g'] = $getcnt->googleCount( $format_url );
					break;
				case 'h':
					$this->_idarray['h'] = $getcnt->hatenaCount( $format_url );
					break;
				case 'l':
					$this->_idarray['l'] = $getcnt->linkedinCount( $format_url );
					break;
				case 't':
					$this->_idarray['t'] = $getcnt->pinterestCount( $format_url );
					break;
				case 'p':
					$this->_idarray['p'] = $getcnt->pocketCount( $format_url );
					break;
				default:
					break;
			}
		}

		$this->reload_sns_cache( $this->_idarray, $url );
	}

	/*---------------------------------------------------------------------------
	 * Feedly のカウント数取得処理 (常に同じ feed URL なので他の SNS とは別取得)
	 *---------------------------------------------------------------------------*/
	public function create_feedly_cache() {
		$feed = esc_url( get_bloginfo( 'rss2_url' ) );

		require_once( INC . 'sns-count.php' );
		$getcnt = new getSnsCount();
		$this->_idarray = array( 'r' => $getcnt->feedlyCount( rawurlencode( $feed ) ) );

		$this->reload_sns_cache( $this->_idarray, $feed );
	}

	/*---------------------------------------------------------------------------
	 * SNS カウントキャッシュの transient 登録
	 *---------------------------------------------------------------------------*/
	public function set_transient_sns_count_cache( $hook, $url ) {
		global $luxe, $wp_filesystem, $wpdb;

		// 期限切れの transient を全部削除
		$time_now = $_SERVER['REQUEST_TIME'];
		$expired_trans = $wpdb->get_col( "SELECT option_name FROM $wpdb->options where option_name LIKE '%_transient_timeout_%' AND option_value+0 < $time_now" );

		if( !empty( $expired_trans ) ) {
			foreach( (array)$expired_trans as $val ) {
				$site_wide = ( strpos( $val, '_site_transient' ) !== false );
				$trans_name = str_replace( $site_wide ? '_site_transient_timeout_' : '_transient_timeout_', '', $val );

				if( strpos( $trans_name, 'luxe-sns-' ) !== false ) {
					if( $site_wide !== false ) {
						delete_site_transient( $trans_name );
					}
					else {
						delete_transient( $trans_name );
					}
				}
			}
		}

		$md5_url = md5( $url );

		$wp_upload_dir = wp_upload_dir();
		$cache_dir = $wp_upload_dir['basedir'] . '/luxe-sns/';
		$this->_sns_count_cache = $cache_dir . $md5_url;

		$transient = 'luxe-sns-' . $md5_url;
		$expire = isset( $luxe['sns_count_cache_expire'] ) && is_int( $luxe['sns_count_cache_expire'] ) ? $luxe['sns_count_cache_expire'] : 600;

		// キャッシュファイルが不完全、もしくは一括再構築なら transient 削除
		if( file_exists( $this->_sns_count_cache ) === true ) {
			$cache = $wp_filesystem->get_contents( $this->_sns_count_cache );
			$cache_count = substr_count( $cache, "\n" ) - 1;
			$this->_ids_count = count( $this->_idarray );

			if(
				empty( $cache ) ||
				strpos( $cache, $url ) === false ||
				strpos( $cache, ':!' ) !== false ||
				( $cache_count !== $this->_ids_count && $cache_count > 1 )
			) {
				//$wp_filesystem->delete( $this->_sns_count_cache );
				delete_transient( $transient );
			}
		}

		// transient が無かったら transient を登録して SNS カウント取得のアクションを実行
		if( get_transient( $transient ) === false ) {
			set_transient( $transient, 1, $expire );
			do_action( $hook, $url );
		}
	}

	/*---------------------------------------------------------------------------
	 * キャッシュ作成・再構築処理
	 *---------------------------------------------------------------------------*/
	private function reload_sns_cache( $idarray, $url ) {
		global $wp_filesystem;

		$cache = '';
		$old_cache = '!';
		$cache_count = 0;
		$this->_sns_count_cache = $this->_cache_dir . md5( $url );

		if( isset( $_POST['luxe_reget_sns'] ) ) {
			$wp_filesystem->delete( $this->_sns_count_cache );
		}
		else {
			if( file_exists( $this->_sns_count_cache ) === true ) {
				$cache = $wp_filesystem->get_contents( $this->_sns_count_cache );
				$cache_count = substr_count( $cache, "\n" ) - 1;
				$old_cache = $cache;
			}

			if( $cache_count !== $this->_ids_count && $cache_count > 1 ) {
				$cache = '';
			}
		}

		if( empty( $cache ) || stripos( $cache, $url ) === false ) {
			$cache = trim( $url ) . "\n";
			foreach( (array)$idarray as $key => $val) {
				if( ctype_digit( trim( $val ) ) === false ) $val = '!';
				$cache .= $key . ':' . trim( $val ) . "\n";
			}
		}
		else {
			foreach( (array)$idarray as $key => $val) {
				if( ctype_digit( trim( $val ) ) === true ) {
					$cache = preg_replace( '/' . $key . '\:[0-9\!]+?\n/m', $key . ':' . trim( $val ) . "\n", $cache );
				}
			}
		}

		if( empty( $cache ) || $cache !== $old_cache ) {
			$this->_filesystem->file_save( $this->_sns_count_cache, $cache );
		}
	}
}
endif;

if( class_exists( 'sns_real' ) === false ):
class sns_real {
	public function __construct() {
	}

	public function thk_sns_real() {
		if( version_compare( PHP_VERSION, '5.4', '<' ) === false ) {
			if( class_exists( 'Punycode' ) === false ) {
				require( INC . 'punycode.php' );
				//use TrueBV\Punycode;
			}
		}

		$hst = isset( $_SERVER['HTTP_HOST'] ) ? puny_encode( thk_convert( $_SERVER['HTTP_HOST'] ) ) : null;
		$lnk = isset( $_GET['url'] ) ? $_GET['url'] : home_url('/');
		$url = rawurlencode( puny_encode( esc_url( thk_convert( $lnk ) ) ) );
		$id  = isset( $_GET['sns'] ) ? $_GET['sns'] : null;
		$cnt = '';

		if( stripos( $url, $hst ) === false ) {
			echo '!';
			exit;
		}

		require_once( INC . 'sns-count.php' );
		$getcnt = new getSnsCount();

		switch( $id ) {
			case 'f':
				global $luxe;
				$cnt = $getcnt->facebookCount( $url, $luxe['sns_fb_appid'], $luxe['sns_fb_appsec'], $luxe['sns_fb_apptoken'] );
				break;
			case 'g':
				$cnt = $getcnt->googleCount( $url );
				break;
			case 'h':
				$cnt = $getcnt->hatenaCount( $url );
				break;
			case 'l':
				$cnt = $getcnt->linkedinCount( $url );
				break;
			case 't':
				$cnt = $getcnt->pinterestCount( $url );
				break;
			case 'p':
				$cnt = $getcnt->pocketCount( $url );
				break;
			case 'r':
				$cnt = $getcnt->feedlyCount( rawurlencode( esc_url( get_bloginfo( 'rss2_url' ) ) ) );
				break;
			default:
				break;
		}

		echo apply_filters( 'thk_sns_count', $cnt, $id, $lnk );
	}
}
endif;
