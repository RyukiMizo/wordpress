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

$shortcode_file_names = array(
	'simple_line_output'	=> '1. ' . __( 'Sample that simply displays a character string', 'luxeritas' ),
	'enclosing_shortcode'	=> '2. ' . __( 'Sample using enclosing shortcode', 'luxeritas' ),
	'shortcode_param'	=> '3. ' . __( 'Sample to display argument given to shortcode', 'luxeritas' ),
	'balloon_left'		=> __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) ',
	'balloon_right'		=> __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) ',
	'ads'			=> 'Google Adsense',
);

$shortcode_file_names += thk_syntax_highlighter_list();

$shortcodes_dir = TPATH . DSEP . 'samples' . DSEP . 'shortcodes' . DSEP;

require_once( INC . 'shortcode-regist.php' );
require_once( INC . 'optimize.php' );

global $wp_filesystem, $filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

foreach( $shortcode_file_names as $key => $val ) {
	if( isset( $_POST['shortcode_' . $key . '_sample'] ) ) {
		if( file_exists( $shortcodes_dir . $key . '.json' ) ) {
			$contents = $wp_filesystem->get_contents( $shortcodes_dir . $key . '.json' );
			$contents = str_replace( array( "\r\n", "\n" ), '_', $contents );

			/*
			 吹き出しの項目置換
			 */
			// 吹き出し左画像
			$sbl_image_url = isset( $_POST['sbl_image_url'] ) ? $_POST['sbl_image_url'] : '';
			$contents = str_replace( '&lt;!-- sbl_image_url --&gt;', $sbl_image_url, $contents );

			// 吹き出し左キャプション
			$sbl_caption = isset( $_POST['sbl_caption'] ) ? $_POST['sbl_caption'] : '';
			$contents = str_replace( '&lt;!-- sbl_caption --&gt;', $sbl_caption, $contents );

			// 吹き出し右画像
			$sbr_image_url = isset( $_POST['sbr_image_url'] ) ? $_POST['sbr_image_url'] : '';
			$contents = str_replace( '&lt;!-- sbr_image_url --&gt;', $sbr_image_url, $contents );

			// 吹き出し右キャプション
			$sbr_caption = isset( $_POST['sbr_caption'] ) ? $_POST['sbr_caption'] : '';
			$contents = str_replace( '&lt;!-- sbr_caption --&gt;', $sbr_caption, $contents );

			$a = (array)@json_decode( $contents );
			if( !empty( $a ) ) {
				foreach( $a as $k => $v ) {
					$opts = (array)$v;
					$regist_name = $k;
					$shortcodes  = array(
						'label'  => $val,
						'php'    => isset( $opts['php'] )    ? (bool)$opts['php']     : false,
						'close'  => isset( $opts['close'] )  ? (bool)$opts['close']   : false,
						'hide'   => isset( $opts['hide'] )   ? (bool)$opts['hide']    : false,
						'active' => isset( $opts['active'] ) ? (bool)$opts['active']  : false,
					);
					$code_text = isset( $opts['active'] ) ? unserialize( $opts['contents'] ) : '';
					break;
				}

				thk_shortcode_regist( $regist_name, $shortcodes, $code_text );
			}
		}
	}
}
