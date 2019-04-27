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

class thk_custom_image_sizes {
	public function __construct() {
	}

	public static function custom_image_sizes( $choose = true ) {
		$image_sizes = self::unregist_image_sizes( self::regist_image_sizes() );

		foreach( $image_sizes as $slug => $size ) {
			if( has_image_size( $slug ) === false ) {
				add_image_size( $slug, $size['width'], $size['height'], $size['crop'] );
			}
		}

		if( $choose != false ) {
			add_action( 'image_size_names_choose', function( $size_names ) use( $image_sizes ) {
				$custom_sizes = get_intermediate_image_sizes();
				foreach( $custom_sizes as $val ) {
					if( isset( $image_sizes[$val]['selectable'] ) && $image_sizes[$val]['selectable'] ) {
						if( !isset( $size_names[$val] ) ) {
							$size_names[$val] = $image_sizes[$val]['name'];
						}
					}
				}
				return $size_names;
			});
		}
	}

	public static function regist_image_sizes() {
		$custom_image_sizes = array(
			'thumb75' => array(
				'name'       => __( 'Micro thumbnail', 'luxeritas' ),
				'width'      => 75,
				'height'     => 75,
				'crop'       => true,
				'selectable' => false
			),
			'thumb100' => array(
				'name'       => __( 'Small thumbnail', 'luxeritas' ),
				'width'      => 100,
				'height'     => 100,
				'crop'       => true,
				'selectable' => false
			),
			'thumb320' => array(
				'name'       => __( 'Horizontal thumbnail', 'luxeritas' ),	// 選択肢のラベル名
				'width'      => 320,         	// 最大画像幅
				'height'     => 180,         	// 最大画像高さ
				'crop'       => true,        	// 切り抜きを行うかどうか
				'selectable' => true         	// 選択肢に含めるかどうか
			),
			'thumb530' => array(
				'name'       => __( 'Small size', 'luxeritas' ) . '(' . __( 'Side bar with 336 px', 'luxeritas' ) . ')',
				'width'      => 530,
				'height'     => 530,
				'crop'       => false,
				'selectable' => true
			),
			'thumb565' => array(
				'name'       => __( 'Small size', 'luxeritas' ) . '(' . __( 'Side bar with 300 px', 'luxeritas' ) . ')',
				'width'      => 565,
				'height'     => 565,
				'crop'       => false,
				'selectable' => true
			),
			'thumb710' => array(
				'name'       => __( 'Large size', 'luxeritas' ) . '(' . __( 'Side bar with 336 px', 'luxeritas' ) . ')',
				'width'      => 710,
				'height'     => 710,
				'crop'       => false,
				'selectable' => true
			),
			'thumb725' => array(
				'name'       => __( 'Large size', 'luxeritas' ) . '(' . __( 'Side bar with 300 px', 'luxeritas' ) . ')',
				'width'      => 725,
				'height'     => 725,
				'crop'       => false,
				'selectable' => true
			),
		);

		require( INC . 'defaults.php' );
		$conf = new defConfig();
		$defs = $conf->user_thumbs_default_variables();
		$mods = wp_parse_args( get_option( 'theme_mods_' . THEME ), $defs );

		if( isset( $mods['thumb_u1_a'] ) && $mods['thumb_u1_a'] === true ) {
			if( isset( $mods['thumb_u1'] ) && isset( $mods['thumb_u1_w'] ) && isset( $mods['thumb_u1_h'] ) && isset( $mods['thumb_u1_c'] ) && isset( $mods['thumb_u1_s'] ) ) {
				$custom_image_sizes += self::add_user_image_sizes( 'user_thumb_1', $mods['thumb_u1'], $mods['thumb_u1_w'], $mods['thumb_u1_h'], $mods['thumb_u1_c'], $mods['thumb_u1_s'] );
			}
		}
		if( isset( $mods['thumb_u2_a'] ) && $mods['thumb_u2_a'] === true ) {
			if( isset( $mods['thumb_u2'] ) && isset( $mods['thumb_u2_w'] ) && isset( $mods['thumb_u2_h'] ) && isset( $mods['thumb_u2_c'] ) && isset( $mods['thumb_u2_s'] ) ) {
				$custom_image_sizes += self::add_user_image_sizes( 'user_thumb_2', $mods['thumb_u2'], $mods['thumb_u2_w'], $mods['thumb_u2_h'], $mods['thumb_u2_c'], $mods['thumb_u2_s'] );
			}
		}
		if( isset( $mods['thumb_u3_a'] ) && $mods['thumb_u3_a'] === true ) {
			if( isset( $mods['thumb_u3'] ) && isset( $mods['thumb_u3_w'] ) && isset( $mods['thumb_u3_h'] ) && isset( $mods['thumb_u3_c'] ) && isset( $mods['thumb_u3_s'] ) ) {
				$custom_image_sizes += self::add_user_image_sizes( 'user_thumb_3', $mods['thumb_u3'], $mods['thumb_u3_w'], $mods['thumb_u3_h'], $mods['thumb_u3_c'], $mods['thumb_u3_s'] );
			}
		}

		return $custom_image_sizes;
	}

	public static function add_user_image_sizes( $id, $name, $width, $height, $crop, $selectable ) {
		return array(
			$id => array(
				'name'       => $name,
				'width'      => (int)$width,
				'height'     => (int)$height,
				'crop'       => (bool)$crop,
				'selectable' => (bool)$selectable
			),
		);
	}

	public static function unregist_image_sizes( $custom_image_sizes ) {
		global $luxe;

		if( isset( $luxe['not_thumb75']  ) ) unset( $custom_image_sizes['thumb75']  );
		if( isset( $luxe['not_thumb100'] ) ) unset( $custom_image_sizes['thumb100'] );
		if( isset( $luxe['not_thumb320'] ) ) unset( $custom_image_sizes['thumb320'] );
		if( isset( $luxe['not_thumb530'] ) ) unset( $custom_image_sizes['thumb530'] );
		if( isset( $luxe['not_thumb565'] ) ) unset( $custom_image_sizes['thumb565'] );
		if( isset( $luxe['not_thumb710'] ) ) unset( $custom_image_sizes['thumb710'] );
		if( isset( $luxe['not_thumb725'] ) ) unset( $custom_image_sizes['thumb725'] );

		$w = isset( $luxe['thumbnail_width'] ) ? $luxe['thumbnail_width'] : null;
		$h = isset( $luxe['thumbnail_height'] ) ? $luxe['thumbnail_height'] : null;

		if( isset( $w ) && isset( $h ) ) {
			$custom_thumbs = 'thumb' . $w . 'x' . $h;
			if( isset( $luxe['not_' . $custom_thumbs] ) ) unset( $custom_image_sizes[$custom_thumbs] );
		}

		return $custom_image_sizes;
	}
}
