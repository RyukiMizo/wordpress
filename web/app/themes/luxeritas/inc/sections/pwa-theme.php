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

wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-color-picker' );
?>
<script>
jQuery(document).ready(function($) {
	$('.thk-color-picker').wpColorPicker();
	$('.wp-color-result').on('click', function() {
		$("#save").prop("disabled", false);
	});
});
</script>
<ul>
<li>
<p class="f09em"><?php echo __( '* Set the color of mobile browser.', 'luxeritas'); ?></p>
<table>
<tbody>
<tr>
<th style="padding-right:20px"><?php echo __( 'Theme color', 'luxeritas' ); ?></th>
<td><input class="thk-color-picker" type="text" id="pwa_theme_color" name="pwa_theme_color" value="<?php thk_value_check( 'pwa_theme_color', 'text' ); ?>" /></td>
</tr>
<tr>
<th style="padding-right:20px"><?php echo __( 'Background color', 'luxeritas' ); ?></th>
<td><input class="thk-color-picker" type="text" id="pwa_bg_color" name="pwa_bg_color" value="<?php thk_value_check( 'pwa_bg_color', 'text' ); ?>" /></td>
</tr>
</tbody>
</table>
</li>
</ul>
