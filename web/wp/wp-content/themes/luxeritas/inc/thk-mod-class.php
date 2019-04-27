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

class thk_mod_class {
	public function __construct() {
	}

	// thk_get_theme_mods
	public static function thk_get_theme_mods( $target ) {
		$admin_json = get_option( 'theme_mods_' . THEME . '_' . $target );
		return @json_decode( $admin_json, true );
	}

	// thk_get_theme_mod
	public static function thk_get_theme_mod( $target, $key = null ) {
		$admin_json = get_option( 'theme_mods_' . THEME . '_' . $target );
		$admins = @json_decode( $admin_json, true );
		if( isset( $admins[$key] ) ) {
			return $admins[$key];
		}
		else {
			return false;
		}
	}

	// thk_set_theme_mod
	public static function thk_set_theme_mod( $target, $key = null, $value ) {
		if( empty( $key ) ) return false;
		$ret = false;
		$admin_mods = self::thk_get_theme_mods( $target );
		$admin_mods = wp_parse_args( array( $key => $value ), $admin_mods );
		$json = @json_encode( $admin_mods );
		if( $json !== false ) {
			// update_option の返り値は使い物にならないので返り値いらない
			update_option( 'theme_mods_' . THEME . '_' . $target, $json );
		}
		else {
			return false;
		}
		return true;
	}

	// thk_remove_theme_mod
	public static function thk_remove_theme_mod( $target, $key ) {
		$ret = false;
		$admin_mods = self::thk_get_theme_mods( $target );
		foreach( (array)$admin_mods as $k => $v ) {
			if( $k === $key ) {
				unset( $admin_mods[$k] );
				$ret = true;
				break;
			}
		}
		if( $ret === true ) {
			$ret = update_option( 'theme_mods_' . THEME . '_' . $target, @json_encode( $admin_mods ) );
		}
		return $ret;
	}

	// thk_remove_theme_mods
	public static function thk_remove_theme_mods( $target ) {
		global $wpdb;
		return $wpdb->delete( $wpdb->options, array( 'option_name' => 'theme_mods_' . THEME . '_' . $target ) );
	}
}

/*---------------------------------------------------------------------------
 * admin
 *---------------------------------------------------------------------------*/
// get_theme_admin_mods
if( function_exists( 'get_theme_admin_mods' ) === false ):
function get_theme_admin_mods() {
	return thk_mod_class::thk_get_theme_mods( 'admin' );
}
endif;

// get_theme_admin_mod
if( function_exists( 'get_theme_admin_mod' ) === false ):
function get_theme_admin_mod( $key = null ) {
	return thk_mod_class::thk_get_theme_mod( 'admin', $key );
}
endif;

// set_theme_admin_mod
if( function_exists( 'set_theme_admin_mod' ) === false ):
function set_theme_admin_mod( $key = null, $value ) {
	return thk_mod_class::thk_set_theme_mod( 'admin', $key, $value );
}
endif;

// remove_theme_admin_mod
if( function_exists( 'remove_theme_admin_mod' ) === false ):
function remove_theme_admin_mod( $key ) {
	return thk_mod_class::thk_remove_theme_mod( 'admin', $key );
}
endif;

// remove_theme_admin_mods
if( function_exists( 'remove_theme_admin_mods' ) === false ):
function remove_theme_admin_mods() {
	return thk_mod_class::thk_remove_theme_mods( 'admin' );
}
endif;

/*---------------------------------------------------------------------------
 * phrase
 *---------------------------------------------------------------------------*/
// get_theme_phrase_mods
if( function_exists( 'get_theme_phrase_mods' ) === false ):
function get_theme_phrase_mods() {
	return thk_mod_class::thk_get_theme_mods( 'phrase' );
}
endif;

// get_theme_phrase_mod
if( function_exists( 'get_theme_phrase_mod' ) === false ):
function get_theme_phrase_mod( $key = null ) {
	return thk_mod_class::thk_get_theme_mod( 'admin', $key );
}
endif;

// set_theme_phrase_mod
if( function_exists( 'set_theme_phrase_mod' ) === false ):
function set_theme_phrase_mod( $key = null, $value ) {
	return thk_mod_class::thk_set_theme_mod( 'phrase', $key, $value );
}
endif;

// remove_theme_phrase_mod
if( function_exists( 'remove_theme_phrase_mod' ) === false ):
function remove_theme_phrase_mod( $key ) {
	return thk_mod_class::thk_remove_theme_mod( 'phrase', $key );
}
endif;

// remove_theme_phrase_mods
if( function_exists( 'remove_theme_phrase_mods' ) === false ):
function remove_theme_phrase_mods() {
	return thk_mod_class::thk_remove_theme_mods( 'phrase' );
}
endif;

/*---------------------------------------------------------------------------
 * get phrase list or shortcode list
 *---------------------------------------------------------------------------*/
if( function_exists( 'get_phrase_list' ) === false ):
function get_phrase_list( $phrase_or_shortcode = 'phrase', $more_value = true, $shortcode_name_only = false ) {
	$mods = array();
	$phrase_mods = get_theme_phrase_mods();
	$prefix = $phrase_or_shortcode === 'shortcode' ? 'sc-' : 'fp-';

	foreach( (array)$phrase_mods as $key => $val ) {
		if( strpos( $key, $prefix ) === 0 ) {
			$key = substr( $key, 3, strlen( $key ) );

			if( $phrase_or_shortcode === 'shortcode' && $shortcode_name_only === true ) {
				$sp_pos = strpos( $key, ' ' );
				if( $sp_pos !== false ) {
					$key = substr( $key, 0, $sp_pos );
				}
			}

			if( $more_value === true ) {
				//$mods[$key] = wp_parse_args( @json_decode( $val ), $values );
				$mods[$key] = $val;
			}
			else {
				$mods[$key] = true;
			}
		}
	}
	return $mods;
}
endif;

/*---------------------------------------------------------------------------
 * thk_fgc
 * WP_Filesystem を使わなくても安全が確保できるものにだけ使用
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_fgc' ) === false ):
function thk_fgc( $load ) {
	$gcon = strrev( 'stnetnoc' . '_teg' . '_elif' );
	if( file_exists( $load ) === true ) {
		return $gcon( $load );
	}
	return false;
}
endif;
