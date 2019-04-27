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

class cinline {
	public function __construct() {
	}

	public function add_inline() {
		require_once( INC . 'carray.php' );
		$i = 0;
		$ca = new carray();
		$imp = $ca->csstext_imp();
		$rev = $ca->hex_2_bin( '21696d706f7274616e74' );
		$bid = $ca->hex_2_bin( '626f64792023666f6f746572' );
		foreach( $imp as $val ){
			$imp[$i] = str_replace( '!', $rev, $ca->hex_2_bin( $val ) );
			++$i;
		}
		$insert = str_replace( '!', $rev, $ca->thk_hex_imp_style() )
		.	'}' . $bid . ' #' . $ca->thk_id() . '{' . $imp[1] . $imp[2]
		.	'}' . $bid . ' #' . $ca->thk_id() . ' a{' . $imp[0] . $imp[2] . '}';
		wp_add_inline_style( 'luxe', $insert );
		return;
	}
}
