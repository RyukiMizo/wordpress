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

/*---------------------------------------------------------------------------
 * QuickTags の strong を消す（ <span style="font-weight:bold"> に変更するため ）
 *---------------------------------------------------------------------------*/
add_filter('quicktags_settings', function( $qtinit ) {
	global $luxe;

	$qtinit['buttons'] = str_replace( 'strong,', '', $qtinit['buttons'] );

	if( isset( $luxe['teditor_buttons_d'] ) ) {
		foreach( (array)$luxe['teditor_buttons_d'] as $key => $val ) {
			if( isset( $luxe['teditor_buttons_d'][$key] ) ) $qtinit['buttons'] = str_replace( $key . ',', '', $qtinit['buttons'] );
		}
	}
	return $qtinit;
}, 10, 1 );

/*---------------------------------------------------------------------------
 * QuickTags にボタンを追加
 * 定型文・ショートコード・ブログカードは別
 *---------------------------------------------------------------------------*/
add_action( 'admin_print_footer_scripts', function() {
	if( wp_script_is( 'quicktags' ) === true ){
		global $luxe;
?>
<script>
if( typeof QTags !== 'undefined' ) {
<?php if( !isset( $luxe['teditor_buttons_d']['thk-b'] ) )	echo "QTags.addButton( 'thk-b', 'b', '<span style=\"font-weight:bold\">', '</span>', '', '', 19 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-strong'] ) )	echo "QTags.addButton( 'thk-strong', 'strong', '<strong>', '</strong>', '', '', 29 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-div'] ) )	echo "QTags.addButton( 'thk-div', 'div', '\\n<div>', '</div>', '', '', 38 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-span'] ) )	echo "QTags.addButton( 'thk-span', 'span', '<span>', '</span>', '', '', 39 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-h2'] ) )	echo "QTags.addButton( 'thk-h2', 'h2', '\\n<h2>', '</h2>', '', '', 46 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-h3'] ) )	echo "QTags.addButton( 'thk-h3', 'h3', '\\n<h3>', '</h3>', '', '', 47 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-h4'] ) )	echo "QTags.addButton( 'thk-h4', 'h4', '\\n<h4>', '</h4>', '', '', 48 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-hr'] ) )	echo "QTags.addButton( 'thk-hr', 'hr', '\\n<hr />\\n', '', '', '', 49 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-pre'] ) )	echo "QTags.addButton( 'thk-pre', 'pre', '\\n<pre />\\n', '', '', '', 109 );" ?>
<?php if( !isset( $luxe['teditor_buttons_d']['thk-next'] ) )	echo "QTags.addButton( 'thk-next', 'nextpage', '\\n<!--nextpage-->', '', '', '', 119 );" ?>
}
</script>
<?php
 	}
}, 99 );
