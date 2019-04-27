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

settings_fields( 'shortcode_sample' );

wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-color-picker' );

$sc_mods = get_phrase_list( 'shortcode', false, true );
$highlighter_list = thk_syntax_highlighter_list();
$i = 0;
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
<p class="control-title"><?php echo __( 'Syntax Highlighter', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* Since it distinguish shortcode in post page and loads only script of language to highlight, even if it registers all, it will work lightly.', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* It is not highlighted in AMP.', 'luxeritas' ); ?></p>
<p>
&nbsp;[ <span style="color:royalblue;text-decoration:underline;cursor:pointer" id="highlight-allcheck"><?php echo __( 'Check all', 'luxeritas' ); ?></span> ]
&nbsp;[ <span style="color:royalblue;text-decoration:underline;cursor:pointer" id="highlight-alluncheck"><?php echo __( 'Uncheck all', 'luxeritas' ); ?></span> ]</p>
<p class="checkbox">
<table class="highlighter-table">
<tbody>
<tr>
<td colspan="2"><input type="checkbox" value="" name="shortcode_highlight_markup_sample"<?php echo isset( $sc_mods['highlight_markup'] ) ? ' checked disabled' : ''; ?> /> Markup ( HTML / XHTML )</td>
<?php
	foreach( $highlighter_list as $key => $val ) {
		if( $key === 'highlight_markup') continue;
		if( $i === 0 ) { echo "</tr>\n<tr>\n";  $i = 1; } else { $i = 0; }
?>
<td><input type="checkbox" value="" name="shortcode_<?php echo $key; ?>_sample"<?php echo isset( $sc_mods[$key] ) ? ' checked disabled' : ''; ?> /> <?php echo $val; ?></td>
<?php
	}
?>
</tr>
</tbody>
</table>
<script>
jQuery(document).ready(function($) {
	$('#highlight-allcheck').on('click', function() {
<?php
	foreach( $highlighter_list as $key => $val ) {
?>
		$('input[name="shortcode_<?php echo $key; ?>_sample"]').prop('checked', true);
<?php
	}
?>
		$("#save").prop("disabled", false);
	});
	$('#highlight-alluncheck').on('click', function() {
<?php
	foreach( $highlighter_list as $key => $val ) {
?>
		if( $('input[name="shortcode_<?php echo $key; ?>_sample"]').prop('disabled') === false ) $('input[name="shortcode_<?php echo $key; ?>_sample"]').prop('checked', false);
<?php
	}
?>
		$("#save").prop("disabled", false);
	});
});
</script>

<p>
CSS Theme:&nbsp;
<select name="highlighter_css">
<option value="none"<?php thk_value_check( 'highlighter_css', 'select', 'solarized_light' ); ?>><?php echo __( 'None', 'luxeritas' ); ?></option>
<option value="default"<?php thk_value_check( 'highlighter_css', 'select', 'default' ); ?>>Default</option>
<option value="dark"<?php thk_value_check( 'highlighter_css', 'select', 'dark' ); ?>>Dark</option>
<option value="okaidia"<?php thk_value_check( 'highlighter_css', 'select', 'okaidia' ); ?>>Okaidia</option>
<option value="twilight"<?php thk_value_check( 'highlighter_css', 'select', 'twilight' ); ?>>Twilight</option>
<option value="coy"<?php thk_value_check( 'highlighter_css', 'select', 'coy' ); ?>>Coy</option>
<option value="solarized-light"<?php thk_value_check( 'highlighter_css', 'select', 'solarized-light' ); ?>>Solarized Light</option>
<option value="tomorrow-night"<?php thk_value_check( 'highlighter_css', 'select', 'tomorrow-night' ); ?>>Tomorrow Night</option>
</select>
</p>

<p class="control-title"><?php echo __( 'Speech balloon', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* If speech balloon shortcode is registered, CSS for speech balloon will be automatically loaded.', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="shortcode_balloon_left_sample"<?php echo isset( $sc_mods['balloon_left'] ) ? ' checked disabled' : ''; ?> />
<?php echo __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) '; ?>
</p>

<table class="balloon-regist-table">
<colgroup span="1" style="width:120px" />
<tbody>
<tr>
<th style="padding-top:10px;vertical-align:top">* <?php echo __( 'Image', 'luxeritas' ); ?> URL : </th>
<td>
<?php
if( isset( $sc_mods['balloon_left'] ) ) {
?>
<input type="text" id="sbl_image_url" name="sbl_image_url" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
	$image = TURI . '/images/white-cat.png';
?>
<input type="text" id="sbl_image_url" name="sbl_image_url" value="<?php echo $image; ?>" />
<div style="margin:5px 0 10px 0">
<script>thkImageSelector('sbl_image_url', 'Image');</script>
<input id="sbl_image_url-set" type="button" class="button" value="<?php echo __( 'Select image', 'luxeritas' ); ?>" style="vertical-align:middle" />
( <?php printf( __( 'Width %s recommended', 'luxeritas' ), '60px' ); ?> )
</div>
<?php
}
?>
</td>
</tr>
<tr>
<th>* <?php echo __( 'Caption', 'luxeritas' ); ?> : </th>
<td>
<?php
if( isset( $sc_mods['balloon_left'] ) ) {
?>
<input type="text" id="sbl_caption" name="sbl_caption" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
?>
<input type="text" id="sbl_caption" name="sbl_caption" value="<?php echo __( 'Left caption', 'luxeritas' ); ?>" />
<?php
}
?>
</td>
</tr>
</tbody>
</table>

<p>
<input type="checkbox" value="" name="shortcode_balloon_right_sample"<?php echo isset( $sc_mods['balloon_right'] ) ? ' checked disabled' : ''; ?> />
<?php echo __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) '; ?>
</p>

<table class="balloon-regist-table">
<colgroup span="1" style="width:120px" />
<tbody>
<tr>
<th style="padding-top:10px;vertical-align:top">* <?php echo __( 'Image', 'luxeritas' ); ?> URL : </th>
<td>
<?php
if( isset( $sc_mods['balloon_right'] ) ) {
?>
<input type="text" id="sbr_image_url" name="sbr_image_url" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
	$image = TURI . '/images/black-cat.png';
?>
<input type="text" id="sbr_image_url" name="sbr_image_url" value="<?php echo $image; ?>" />
<div style="margin:5px 0 10px 0">
<script>thkImageSelector('sbr_image_url', 'Image');</script>
<input id="sbr_image_url-set" type="button" class="button" value="<?php echo __( 'Select image', 'luxeritas' ); ?>" style="vertical-align:middle" />
( <?php printf( __( 'Width %s recommended', 'luxeritas' ), '60px' ); ?> )
</div>
<?php
}
?>
</td>
</tr>
<tr>
<th>* <?php echo __( 'Caption', 'luxeritas' ); ?> : </th>
<td>
<?php
if( isset( $sc_mods['balloon_right'] ) ) {
?>
<input type="text" id="sbr_caption" name="sbr_caption" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
?>
<input type="text" id="sbr_caption" name="sbr_caption" value="<?php echo __( 'Right caption', 'luxeritas' ); ?>" />
<?php
}
?>
</td>
</tr>
</tbody>
</table>

<p class="control-title"><?php echo __( 'CSS settings for speech balloon', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* This item can be changed even after shortcode registration.', 'luxeritas' ); ?></p>
<?php
require( 'balloon-css.php' );
?>
<script>
jQuery(document).ready(function($) {
	$('input[name="shortcode_balloon_left_sample"],input[name="shortcode_balloon_right_sample"]').on('change', function() {
		if(
			$('input[name="shortcode_balloon_left_sample"]').prop('checked') === true ||
			$('input[name="shortcode_balloon_right_sample"]').prop('checked') === true
		) {
			$('input[name="balloon_enable"]').prop('checked', true);
			$('input[name="balloon_enable"]').prop('disabled', true);
		}
		else {
			$('input[name="balloon_enable"]').prop('disabled', false);
		}
	});
});
</script>
</li>
</ul>
