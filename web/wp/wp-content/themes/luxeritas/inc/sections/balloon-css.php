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

?>
<table class="balloon-regist-table">
<colgroup span="1" style="width:120px" />
<tbody>
<?php
if( !isset( $sc_mods ) ) {
	$sc_mods = get_phrase_list( 'shortcode', false, true );
}
$disabled = false;
if( isset( $sc_mods['balloon_left'] ) || isset( $sc_mods['balloon_right'] ) ) {
	$disabled = true;
}
?>
<tr>
<td colspan="2"><input type="checkbox" value="" name="balloon_enable"<?php thk_value_check( 'balloon_enable', 'checkbox' ); echo $disabled === true ? ' disabled' : ''; ?> /> <?php echo __('Load CSS for speech balloon', 'luxeritas'), ' ( ', __('If speech balloon shortcode is registered, it will be sure to loaded.', 'luxeritas'), ' )'; ?></td>
</tr>
<tr><td colspan="2"><hr /></td></tr>
<tr>
<th>* <?php echo __( 'Text color', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) '; ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_left_color" name="balloon_left_color" value="<?php thk_value_check( 'balloon_left_color', 'text' ); ?>" /></th>
</tr>
<tr>
<th>* <?php echo __( 'Background color', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) '; ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_left_bg_color" name="balloon_left_bg_color" value="<?php thk_value_check( 'balloon_left_bg_color', 'text' ); ?>" /></td>
</tr>
<tr>
<th style="padding-top:10px;vertical-align:top">* <?php echo __( 'Border', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) '; ?> : </th>
<td>
<input class="thk-color-picker" type="text" id="balloon_left_border_color" name="balloon_left_border_color" value="<?php thk_value_check( 'balloon_left_border_color', 'text' ); ?>" />
<input type="number" id="balloon_left_border_width" name="balloon_left_border_width" value="<?php thk_value_check( 'balloon_left_border_width', 'number' ); ?>" style="width:100%;max-width:60px" /> px
</td>
</tr>
<th>* <?php echo __( 'Shadow', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) '; ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_left_shadow_color" name="balloon_left_shadow_color" value="<?php thk_value_check( 'balloon_left_shadow_color', 'text' ); ?>" /></td>
</tr>
<tr><td colspan="2"><hr /></td></tr>
<tr>
<th>* <?php echo __( 'Text color', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) '; ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_right_color" name="balloon_right_color" value="<?php thk_value_check( 'balloon_right_color', 'text' ); ?>" /></th>
</tr>
<tr>
<th>* <?php echo __( 'Background color', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) '; ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_right_bg_color" name="balloon_right_bg_color" value="<?php thk_value_check( 'balloon_right_bg_color', 'text' ); ?>" /></td>
</tr>
<tr>
<th style="padding-top:10px;vertical-align:top">* <?php echo __( 'Border', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) '; ?> : </th>
<td>
<input class="thk-color-picker" type="text" id="balloon_right_border_color" name="balloon_right_border_color" value="<?php thk_value_check( 'balloon_right_border_color', 'text' ); ?>" />
<input type="number" id="balloon_right_border_width" name="balloon_right_border_width" value="<?php thk_value_check( 'balloon_right_border_width', 'number' ); ?>" style="width:100%;max-width:60px" /> px
</td>
</tr>
<th>* <?php echo __( 'Shadow', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) '; ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_right_shadow_color" name="balloon_right_shadow_color" value="<?php thk_value_check( 'balloon_right_shadow_color', 'text' ); ?>" /></td>
</tr>
<tr><td colspan="2"><hr /></td></tr>
<tr>
<th>* <?php echo __( 'Max width', 'luxeritas' ); ?> : </th>
<td><input type="number" id="balloon_max_width" name="balloon_max_width" value="<?php thk_value_check( 'balloon_max_width', 'number' ); ?>" style="width:100%;max-width:60px" /> px ( <?php echo __( 'When input is 0, 100%', 'luxeritas' ); ?> )</td>
</tr>
</tbody>
</table>
