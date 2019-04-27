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

global $luxe;

if( class_exists('thk_colors') === false ) require( INC . 'colors.php' );
$colors_class = new thk_colors();

// balloon max-width replace
if( isset($luxe['balloon_max_width']) && $luxe['balloon_max_width'] !== 0 ) {
	$contents = str_replace( '65535px', $luxe['balloon_max_width'] . 'px', $contents );
}
else {
	$contents = str_replace( '65535px', '100%', $contents );
}

/* balloon left replace */
// left color
$balloon_left_color = isset( $luxe['balloon_left_color'] ) ? $luxe['balloon_left_color'] : 'transparent';
$contents = str_replace( '#000000', $balloon_left_color, $contents );

// left background color
$balloon_left_bg_color = isset( $luxe['balloon_left_bg_color'] ) ? $luxe['balloon_left_bg_color'] : 'transparent';
$contents = str_replace( '#e4e8eb', $balloon_left_bg_color, $contents );

// left border
$balloon_left_border_color = isset( $luxe['balloon_left_border_color'] ) ? $luxe['balloon_left_border_color'] : 'transparent';
$balloon_left_border_width = isset( $luxe['balloon_left_border_width'] ) ? (int)$luxe['balloon_left_border_width'] : 1;

if( $balloon_left_border_width > 0 ) {
	$contents = str_replace( '1px #e5e9ec', $balloon_left_border_width . 'px ' . $balloon_left_border_color, $contents );
	$contents = str_replace( '#e5e9ec', $balloon_left_border_color, $contents );

	$left = 0 - 22 - $balloon_left_border_width;
	$contents = str_replace( 'left: -22px', 'left: ' . $left . 'px', $contents );
}
else {
	$contents = str_replace( 'border: solid 1px #e5e9ec;', '', $contents );
	$contents = str_replace( 'border-right: solid 12px #e5e9ec;', 'border-right: solid 12px transparent;', $contents );
}

// left shadow color
if( isset( $luxe['balloon_left_shadow_color'] ) ) {
	$rgb = $colors_class->colorcode_2_rgb( $luxe['balloon_left_shadow_color'] );
	$contents = str_replace(
		'box-shadow: 4px 4px 5px rgba( 0, 0, 0, .3 );',
		'box-shadow: 4px 4px 5px rgba( ' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ', .3 );',
		$contents
	);
}
else {
	$contents = str_replace( 'box-shadow: 4px 4px 5px rgba( 0, 0, 0, .3 );', '', $contents );
}

/* balloon right replace */
// right color
$balloon_right_color = isset( $luxe['balloon_right_color'] ) ? $luxe['balloon_right_color'] : 'transparent';
$contents = str_replace( '#111111', $balloon_right_color, $contents );

// right background color
$balloon_right_bg_color = isset( $luxe['balloon_right_bg_color'] ) ? $luxe['balloon_right_bg_color'] : 'transparent';
$contents = str_replace( '#bef18c', $balloon_right_bg_color, $contents );

// right border
$balloon_right_border_color = isset( $luxe['balloon_right_border_color'] ) ? $luxe['balloon_right_border_color'] : 'transparent';
$balloon_right_border_width = isset( $luxe['balloon_right_border_width'] ) ? (int)$luxe['balloon_right_border_width'] : 1;

if( $balloon_right_border_width > 0 ) {
	$contents = str_replace( '1px #bff28d', $balloon_right_border_width . 'px ' . $balloon_right_border_color, $contents );
	$contents = str_replace( '#bff28d', $balloon_right_border_color, $contents );

	$right = 0 - 22 - $balloon_right_border_width;
	$contents = str_replace( 'right: -22px', 'right: ' . $right . 'px', $contents );
}
else {
	$contents = str_replace( 'border: solid 1px #bff28d;', '', $contents );
	$contents = str_replace( 'border-right: solid 12px #bff28d;', 'border-right: solid 12px transparent;', $contents );
}

// right shadow color
if( isset( $luxe['balloon_right_shadow_color'] ) ) {
	$rgb = $colors_class->colorcode_2_rgb( $luxe['balloon_right_shadow_color'] );
	$contents = str_replace(
		'box-shadow: -4px 4px 5px rgba( 0, 0, 0, .3 );',
		'box-shadow: -4px 4px 5px rgba( ' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ', .3 );',
		$contents
	);
}
else {
	$contents = str_replace( 'box-shadow: -4px 4px 5px rgba( 0, 0, 0, .3 );', '', $contents );
}
