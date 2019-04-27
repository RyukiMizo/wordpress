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

settings_fields( 'thumbnail' );
?>
<p class="f09em m10-b"><?php echo __( '* For checked size, thumbnails will be created when uploading images on the Media Library.', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* Crop = When the aspect ratio does not match, the protruding part is cut away.', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* Selectable = On post, you can select &quot;ATTACHMENT DISPLAY SETTINGS&quot; in the Media Library.', 'luxeritas' ); ?></p>
<table id="amp-plugins">
<thead>
<tr>
<th class="amp-cbox"><?php echo __( 'Generate', 'luxeritas' ); ?></th>
<th><?php echo __( 'Max size', 'luxeritas' ); ?></th>
<th><?php echo __( 'Name', 'luxeritas' ); ?></th>
<th>Crop</th>
<th>Selectable</th>
</tr>
</thead>
<tbody>
<?php
require_once( INC . 'thumbnail-images.php' );
$wp_default_thumbs = array( 'thumbnail', 'medium', 'medium_large', 'large' );
$custom_images = thk_custom_image_sizes::regist_image_sizes();
$image_sizes = get_intermediate_image_sizes();

$yes = '<i class="dashicons dashicons-yes"></i>';
$no  = '-';

$sizes = array();
$image_list = array();

foreach( $image_sizes as $val ) {
	if( !isset( $custom_images[$val] ) ) $image_list[] = $val;
}
unset( $image_sizes );
foreach( $custom_images as $key => $val ) {
	$image_list[] = $key;
}
foreach( $image_list as $val ) {
	if( in_array( $val, $wp_default_thumbs ) === true ) {
		switch( $val ) {
			case 'thumbnail': $sizes[$val]['name'] = 'Thumbnail'; break;
			case 'medium': $sizes[$val]['name'] = 'Medium size'; break;
			case 'medium_large': $sizes[$val]['name'] = 'Medium large size'; break;
			case 'large': $sizes[$val]['name'] = 'Large size'; break;
			default: break;
		}
		$sizes[$val]['size'] = get_option( $val . '_size_w' ) . ' x ' . get_option( $val . '_size_w' ) . ' px';
		$sizes[$val]['crop'] = (int)get_option( $val . '_crop' ) == 1 ? $yes : $no;
		$sizes[$val]['selectable'] = get_option( $val . '_size_h' ) > 0 ? $yes : $no;
	}
	else {
		if( isset( $custom_images[$val]['width'] ) && isset( $custom_images[$val]['height'] ) ) {
			$sizes[$val]['name'] = isset( $custom_images[$val]['name'] ) ? $custom_images[$val]['name'] : '';
			$sizes[$val]['size'] = $custom_images[$val]['width'] . ' x ' . $custom_images[$val]['height'] . ' px';
			$sizes[$val]['crop'] = $custom_images[$val]['crop'] === true ? $yes : $no;
			$sizes[$val]['selectable'] = $custom_images[$val]['selectable'] === true ? $yes : $no;
		}
	}
}
unset( $sizes['user_thumb_1'], $sizes['user_thumb_2'], $sizes['user_thumb_3'] );

foreach( $sizes as $key => $val ) {
?>
<tr>
<?php
if( in_array( $key, $wp_default_thumbs ) === true ) {
?>
<td class="amp-cbox"><input type="checkbox" value="" name="" disabled checked="checked" /></td>
<?php
}
else {
	// チェックが付いてる方がデフォルトなので checked の結果を反転させる( DB の無駄を無くすため )
	$checked = thk_value_check( 'not_' . $key, 'checkbox', '', false );
	$checked = empty( $checked ) ? ' checked="checked"' : '';
?>
<td class="amp-cbox"><input type="checkbox" value="" name="not_<?php echo $key; ?>"<?php echo $checked; ?> /></td>
<?php
}
?>
<td><?php echo $val['size']; ?></td>
<td><?php echo $val['name']; ?></td>
<td style="text-align:center"><?php echo $val['crop']; ?></td>
<td style="text-align:center"><?php echo $val['selectable']; ?></td>
</tr>
<?php
}
?>
<tr>
<td class="amp-cbox"><input type="checkbox" name="thumb_u1_a" value=""<?php thk_value_check( 'thumb_u1_a', 'checkbox' ); ?> /></td>
<td><input type="number" name="thumb_u1_w" value="<?php thk_value_check( 'thumb_u1_w', 'number' ); ?>" /> x <input type="number" name="thumb_u1_h" value="<?php thk_value_check( 'thumb_u1_h', 'number' ); ?>" /> px</td>
<td><input type="text" name="thumb_u1" value="<?php thk_value_check( 'thumb_u1', 'text' ); ?>" /></td>
<td style="text-align:center"><input type="checkbox" name="thumb_u1_c" value=""<?php thk_value_check( 'thumb_u1_c', 'checkbox' ); ?> /></td>
<td style="text-align:center"><input type="checkbox" name="thumb_u1_s" value=""<?php thk_value_check( 'thumb_u1_s', 'checkbox' ); ?> /></td>
</tr>
<tr>
<td class="amp-cbox"><input type="checkbox" name="thumb_u2_a" value=""<?php thk_value_check( 'thumb_u2_a', 'checkbox' ); ?> /></td>
<td><input type="number" name="thumb_u2_w" value="<?php thk_value_check( 'thumb_u2_w', 'number' ); ?>" /> x <input type="number" name="thumb_u2_h" value="<?php thk_value_check( 'thumb_u2_h', 'number' ); ?>" /> px</td>
<td><input type="text" name="thumb_u2" value="<?php thk_value_check( 'thumb_u2', 'text' ); ?>" /></td>
<td style="text-align:center"><input type="checkbox" name="thumb_u2_c" value=""<?php thk_value_check( 'thumb_u2_c', 'checkbox' ); ?> /></td>
<td style="text-align:center"><input type="checkbox" name="thumb_u2_s" value=""<?php thk_value_check( 'thumb_u2_s', 'checkbox' ); ?> /></td>
</tr>
<tr>
<td class="amp-cbox"><input type="checkbox" name="thumb_u3_a" value=""<?php thk_value_check( 'thumb_u3_a', 'checkbox' ); ?> /></td>
<td><input type="number" name="thumb_u3_w" value="<?php thk_value_check( 'thumb_u3_w', 'number' ); ?>" /> x <input type="number" name="thumb_u3_h" value="<?php thk_value_check( 'thumb_u3_h', 'number' ); ?>" /> px</td>
<td><input type="text" name="thumb_u3" value="<?php thk_value_check( 'thumb_u3', 'text' ); ?>" /></td>
<td style="text-align:center"><input type="checkbox" name="thumb_u3_c" value=""<?php thk_value_check( 'thumb_u3_c', 'checkbox' ); ?> /></td>
<td style="text-align:center"><input type="checkbox" name="thumb_u3_s" value=""<?php thk_value_check( 'thumb_u3_s', 'checkbox' ); ?> /></td>
</tr>
</tbody>
</table>
<p class="f09em m10-b"><?php echo __( '* To use user thumbnails with existing images, you need to regenerate thumbnails.', 'luxeritas' ); ?></p>
