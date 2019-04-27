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

class code_change {
	private static $_codes = array(
		' ',
		'"',
		"'",
		'.',
		',',
		':',
		';',
		'[',
		']',
		'(',
		')',
		'{',
		'}',
		'<',
		'>',
		'+',
		'_',
		'|',
		'~',
		'^',
		'%',
		'=',
		'#',
		'&',
		'$',
		'!',
		'?',
		"\r",
		"\n",
		"\t"
	);

	private function __construct() {
	}

	private static function thk_rot( $ret ) {
		$rot = strrev( '31tor' . '_' . 'rts' );
		return( $rot( $ret ) );
	}

	private static function thk_wspace( $ret ) {
		$wspace = strrev( self::thk_rot( 'rpncfrgvuj_cvegf_cuc' ) );
		return( $wspace( $ret ) );
	}

	private static function thk_code_font() {
		if( function_exists( 'thk_code_font_1' ) === false ) {
			require( TPATH . self::thk_rot( '/sbagf/pbqr.jbss2' ) );
		}
	}

	public static function thk_fcheck() {
		$chk = true;
		$rep = '';
		$rev = strrev( self::thk_rot( 'ergbbs' ) );
		$pfl = SPATH . DSEP . $rev . '.php';

		if( file_exists( $pfl ) === false ) {
			$pfl = TPATH . DSEP . $rev . '.php';
		}
		if( file_exists( $pfl ) === true ) {
			$rep = self::thk_wspace( $pfl );
			$rep = preg_replace( '/<!--[\s\S]*?-->/s', '', $rep );
			$rep = str_replace( self::$_codes, '', $rep );
		}

		self::thk_code_font();
		$chk_array = thk_code_font_1();

		foreach( $chk_array as $val) {
			$val = strrev( self::thk_rot( $val ) );
			if( stripos( $rep, $val ) === false ) $chk = false;
		}

		if( $chk === false || stripos( $rep, 'wp-' . $rev ) === false ) {
			self::wp_false();
		}
	}

	public static function thk_ccheck() {
		$rev = strrev( self::thk_rot( 'lneenp' ) );
		$pfl = INC . $rev . '.php';
		$ffl = TPATH . self::thk_rot( '/sbagf/pbqr.jbss' );

		if( file_exists( $pfl ) === false || file_exists( $ffl ) === false ) {
			self::wp_false();
		}

		$orig = str_replace( self::$_codes, '', self::thk_wspace( $pfl ) );
		$comp = str_replace( self::$_codes, '', self::thk_wspace( $ffl ) );

		if( $orig !== $comp ) {
			self::wp_false();
		}
	}
	public static function thk_jcheck() {
		require_once( INC . self::thk_rot( 'pneenl.cuc' ) );
		require_once( INC . self::thk_rot( 'perngr-wninfpevcg.cuc' ) );

		$chk = true;
		$cls = self::thk_rot( 'perngr_Wninfpevcg' );
		$fnk = self::thk_rot( 'perngr_yhkr_inevbhf_fpevcg' );
		$js = new $cls();
		$vr = preg_replace( "/([\{|\}|;|'|\"|,])\s*?\/\/.+?\n/", "$1\n", $js->$fnk() );
		$vr = preg_replace( "/\n[\s|\t]*?\/\/.+?\n/", "\n", $vr );
		$vr = preg_replace( array('{\n\/\/.+}','{\A\/\/.+}'), "", $vr );
		$vr = preg_replace( "/\/\*(.*?)\*\//s", "", $vr);
		$vr = str_replace( self::$_codes, '', $vr );

		self::thk_code_font();
		$chk_array = thk_code_font_2();

		foreach( $chk_array as $val) {
			$val = strrev( self::thk_rot( $val ) );
			if( stripos( $vr, $val ) === false ) $chk = false;
		}
		if( $chk === false ) {
			set_theme_admin_mod( 'all_clear', true );
			self::wp_false();
		}
	}

	private static function wp_false() {
		global $wp, $wp_query; $wp = false; $wp_query = false;
	}
}

call_user_func( function() {
	code_change::thk_ccheck();
	code_change::thk_jcheck();
});
add_action( 'init', function() { code_change::thk_fcheck(); } );
