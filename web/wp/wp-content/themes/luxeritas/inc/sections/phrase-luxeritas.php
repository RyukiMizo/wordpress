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

settings_fields( 'phrase_sample' );

wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-color-picker' );

$fp_mods = get_phrase_list( 'phrase', false );
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
<p class="control-title"><?php echo __( 'Speech balloon', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* After registration, please rewrite URL and Caption of the image from the fixed phrase edit screen as necessary.', 'luxeritas' ); ?></p>
<p class="checkbox">
<?php $phrase_name = __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' )'; ?>
<input type="checkbox" value="" name="phrase_balloon_left_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?>
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' )'; ?>
<input type="checkbox" value="" name="phrase_balloon_right_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?>
</p>

<p class="control-title"><?php echo __( 'CSS settings for speech balloon', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* This item is CSS settings for speech balloon shortcode and shared.', 'luxeritas' ); ?></p>
<?php
require( 'balloon-css.php' );
?>
</li>
</ul>
