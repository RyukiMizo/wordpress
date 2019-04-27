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

class luxe_batch {
	public function __construct() {
		$limit_func = 'set_' . 'time_' . 'limit';
		@$limit_func( 900 );
	}

	// SNS カウントキャッシュ一括取得処理
	public static function luxe_reget_sns() {
		add_action( 'wp_ajax_regetsnscount', function() {
			$id = isset( $_POST['id'] ) ? (int)$_POST['id'] : null;
			if( empty( $id ) ) exit;

			$url = '';
			$failed = '<span style="color:red">Failed</span>';
			$_sns = new sns_cache();

			if( $id === -99 ) {
				$url = home_url('/');
			}
			elseif( $id === -100 ) {
				$url = get_bloginfo( 'rss2_url' );
				$_sns->create_feedly_cache(); // Feedly
			}
			else {
				$url = get_permalink( $id );
			}
			$_sns->touch_sns_count_cache( esc_url( $url ) );
			$_sns->create_sns_cache( esc_url( $url ) );

			echo $url;
			exit;
		});
	}

	// サムネイル一括再構築処理
	public static function luxe_regen_thumb() {
		// regeneratethumbnail という action 名は変更不可
		// EWWW Image Optimizer が regeneratethumbnail という名前でバイパスしてるから
		add_action( 'wp_ajax_regeneratethumbnail', function() {
			$id = isset( $_POST['id'] ) ? (int)$_POST['id'] : null;
			if( empty( $id ) ) exit;

			timer_start();

			$failed = '<span style="color:red">Failed</span>';
			$path = get_attached_file( $id );

			if( $path === false || file_exists( $path ) === false ) {
				echo 'ID: ', $id, ' | ', $failed, "\n", timer_stop(), ' sec';
				exit;
			}

			if( isset( $_POST['del'] ) && (int)$_POST['del'] === 1 ) {
/*
				require_once( INC . 'optimize.php' );
				global $wp_filesystem;
				$filesystem = new thk_filesystem();
				if( $filesystem->init_filesystem( site_url() ) === false ) return false;
*/
				$origin_parts = pathinfo( $path );
				$thumbs = glob( dirname( $path ) . '/' . $origin_parts['filename'] . '-*' );

				foreach( $thumbs as $del ) {
					$thumbs_parts = pathinfo( $del );
					$size_info = explode( $origin_parts['filename'], $thumbs_parts['filename'] );
					$sized = explode( 'x', $size_info[1] );
					if( isset( $sized[1] ) && !isset( $sized[2] ) ) {
						if( is_numeric( $sized[0] ) === true && is_numeric( $sized[1] ) === true ) {
							//$wp_filesystem->delete( $del );
							$del_func = 'un' . 'link';
							@$del_func( $del );
						}
					}
				}
			}

			$meta = wp_generate_attachment_metadata( $id, $path );
			if( !empty( $meta ) && is_wp_error( $meta ) === false ) {
				wp_update_attachment_metadata( $id, $meta );
			}
			else {
				echo 'ID: ', $id, ' | ', $failed, "\n", timer_stop(), ' sec';
				exit;
			}

			$ipath = isset( $meta['file'] ) ? $meta['file'] : $failed;
			echo 'ID: ', $id, ' | ', $ipath, "\n", timer_stop(), ' sec', "\n";

			exit;
		});
	}
}
