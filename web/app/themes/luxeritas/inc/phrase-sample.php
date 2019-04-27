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

$phrase_file_names = array(
	'blockquote'	=> __( 'Quote', 'luxeritas' ),
	'pre'		=> __( 'Preformatted text', 'luxeritas' ),
	'ul'		=> __( 'Bulleted list', 'luxeritas' ),
	'ol'		=> __( 'Numbered list', 'luxeritas' ),
	'h2'		=> __( 'Heading 2', 'luxeritas' ),
	'h3'		=> __( 'Heading 3', 'luxeritas' ),
	'h4'		=> __( 'Heading 4', 'luxeritas' ),
	'adsense'	=> 'Google Adsense',
	'balloon_left'	=> __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' )',
	'balloon_right'	=> __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' )',
);

$phrases_dir = TPATH . DSEP . 'samples' . DSEP . 'phrases' . DSEP;
$shortcodes_dir = TPATH . DSEP . 'samples' . DSEP . 'shortcodes' . DSEP;

require_once( INC . 'phrase-regist.php' );
require_once( INC . 'optimize.php' );

global $wp_filesystem, $filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

foreach( $phrase_file_names as $key => $val ) {
	if( isset( $_POST['phrase_' . $key . '_sample'] ) ) {
		if( file_exists( $phrases_dir . $key . '.json' ) ) {
			$contents = $wp_filesystem->get_contents( $phrases_dir . $key . '.json' );
			$contents = str_replace( "\n", '_', $contents );
			$a = (array)@json_decode( $contents );

			if( !empty( $a ) ) {
				foreach( $a as $k => $v ) {
					$regist_name = $val;
					$code_text   = unserialize( $v );
					$code_close  = false;

					$sep_org = "\n<!--" . strlen( $key ) . '-' . md5( $key ) . "-->\n";
					$sep = "\n<!--" . strlen( $val ) . '-' . md5( $val ) . "-->\n";

					if( strpos( $code_text, $sep_org ) !== false ) {
						$code_text = str_replace( $sep_org, $sep, $code_text );
						$code_close = true;
					}

					break;
				}
				thk_phrase_regist( $regist_name, $code_text, $code_close );
			}
		}
	}
}
