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

require_once( INC . 'colors.php' );

$colors_class = new thk_colors();
$colors = $colors_class->primary_colors();
?>
<ul>
<li>
<p class="label-title"><?php echo __( 'Image Size (Width : Height)', 'luxeritas' ); ?></p>
<input type="number" value="<?php thk_value_check( 'secimg_image_width', 'number' ); ?>" name="secimg_image_width" />
:
<input type="number" value="<?php thk_value_check( 'secimg_image_height', 'number' ); ?>" name="secimg_image_height" />
</li>
<li>
<p class="label-title"><?php echo __( 'Number of characters (Min - Max)', 'luxeritas' ); ?></p>
<input type="number" value="<?php thk_value_check( 'secimg_start_length', 'number' ); ?>" name="secimg_start_length" />
-
<input type="number" value="<?php thk_value_check( 'secimg_end_length', 'number' ); ?>" name="secimg_end_length" />
</li>
<li>
<p class="label-title"><?php echo __( 'Character Set', 'luxeritas' ); ?></p>
<select name="secimg_charset">
<option value="numeric"<?php thk_value_check( 'secimg_charset', 'select', 'numeric' ); ?>><?php echo __( 'Number', 'luxeritas' ); ?></option>
<option value="alpha"<?php thk_value_check( 'secimg_charset', 'select', 'alpha' ); ?>><?php echo __( 'Alphabet', 'luxeritas' ); ?></option>
<option value="alpha_upper"<?php thk_value_check( 'secimg_charset', 'select', 'alpha_upper' ); ?>><?php echo __( 'Alphabet', 'luxeritas' ), ' (', __( 'upper', 'luxeritas' ), ')'; ?></option>
<option value="alpha_lower"<?php thk_value_check( 'secimg_charset', 'select', 'alpha_lower' ); ?>><?php echo __( 'Alphabet', 'luxeritas' ), ' (', __( 'lower', 'luxeritas' ), ')'; ?></option>
<option value="alphanum"<?php thk_value_check( 'secimg_charset', 'select', 'alphanum' ); ?>><?php echo __( 'Alphanumeric', 'luxeritas' ); ?></option>
<option value="alphanum_upper"<?php thk_value_check( 'secimg_charset', 'select', 'alphanum_upper' ); ?>><?php echo __( 'Alphanumeric', 'luxeritas' ), ' (', __( 'upper', 'luxeritas' ), ')'; ?></option>
<option value="alphanum_lower"<?php thk_value_check( 'secimg_charset', 'select', 'alphanum_lower' ); ?>><?php echo __( 'Alphanumeric', 'luxeritas' ), ' (', __( 'lower', 'luxeritas' ), ')'; ?></option>
</select>
</li>
<li>
<p class="label-title"><?php echo __( 'Font size', 'luxeritas' ); ?></p>
<input type="range" value="<?php thk_value_check( 'secimg_font_ratio', 'range' ); ?>" name="secimg_font_ratio" />
</li>
<li>
<p class="label-title"><?php echo __( 'Image color', 'luxeritas' ); ?></p>
<div style="margin-bottom:15px">
<select name="secimg_color" style="background:<?php global $luxe; echo $luxe['secimg_color']; ?>">
<?php
foreach( $colors as $key => $val ) {
	$text_color = $colors_class->get_text_color_matches_background( $key );
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'secimg_color', 'select', $key ); ?> data-color="<?php echo $text_color; ?>" style="background:<?php echo $key; ?>;color:<?php echo $text_color; ?>"><?php echo $val; ?></option>
<?php
}
?>
</select>
<?php echo __( 'Text color', 'luxeritas' ); ?>
</div>
<div style="margin-bottom:15px">
<select name="secimg_bg_color" style="background:<?php global $luxe; echo $luxe['secimg_bg_color']; ?>">
<?php
foreach( $colors as $key => $val ) {
	$text_color = $colors_class->get_text_color_matches_background( $key );
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'secimg_bg_color', 'select', $key ); ?> data-color="<?php echo $text_color; ?>" style="background:<?php echo $key; ?>;color:<?php echo $text_color; ?>"><?php echo $val; ?></option>
<?php
}
?>
</select>
<?php echo __( 'Background color', 'luxeritas' ); ?>
</div>
</li>
<li>
<p class="label-title"><?php echo __( 'Character distortion', 'luxeritas' ); ?></p>
<input type="range" value="<?php thk_value_check( 'secimg_perturbation', 'range' ); ?>" name="secimg_perturbation" />
</li>
<li>
<p class="label-title"><?php echo __( 'Background noise', 'luxeritas' ); ?></p>
<input type="range" value="<?php thk_value_check( 'secimg_noise_level', 'range' ); ?>" name="secimg_noise_level" />
</li>
<li>
<div style="margin-bottom:15px">
<select name="secimg_noise_color" style="background:<?php global $luxe; echo $luxe['secimg_noise_color']; ?>">
<?php
foreach( $colors as $key => $val ) {
	$text_color = $colors_class->get_text_color_matches_background( $key );
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'secimg_noise_color', 'select', $key ); ?> data-color="<?php echo $text_color; ?>" style="background:<?php echo $key; ?>;color:<?php echo $text_color; ?>"><?php echo $val; ?></option>
<?php
}
?>
</select>
<?php echo __( 'Noise color', 'luxeritas' ); ?>
</div>
</li>
<li>
<p class="label-title"><?php echo __( 'Number of lines above the image to make it obscure', 'luxeritas' ); ?></p>
<input type="number" value="<?php thk_value_check( 'secimg_num_lines', 'number' ); ?>" name="secimg_num_lines" />
</li>
<li>
<select name="secimg_line_color" style="background:<?php global $luxe; echo $luxe['secimg_line_color']; ?>">
<?php
foreach( $colors as $key => $val ) {
	$text_color = $colors_class->get_text_color_matches_background( $key );
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'secimg_line_color', 'select', $key ); ?> data-color="<?php echo $text_color; ?>" style="background:<?php echo $key; ?>;color:<?php echo $text_color; ?>"><?php echo $val; ?></option>
<?php
}
?>
</select>
<?php echo __( 'Line color', 'luxeritas' ); ?>
</li>
</ul>
<script>
jQuery(function($){
	ctcol = $('select[name="secimg_color"]');
	ctopt = $('select[name="secimg_color"] option:selected');
	ctcol.css( 'color', ctopt.attr('data-color') );
	ctcol.css( 'background', ctopt.val() );

	ctcol.change(function() {
		ctopt = $('select[name="secimg_color"] option:selected');
		ctcol.css( 'color', ctopt.attr('data-color') );
		ctcol.css( 'background', ctopt.val() );
		$(this).blur()
	});

	bgcol = $('select[name="secimg_bg_color"]');
	bgopt = $('select[name="secimg_bg_color"] option:selected');
	bgcol.css( 'color', bgopt.attr('data-color') );
	bgcol.css( 'background', bgopt.val() );

	bgcol.change(function() {
		bgopt = $('select[name="secimg_bg_color"] option:selected');
		bgcol.css( 'color', bgopt.attr('data-color') );
		bgcol.css( 'background', bgopt.val() );
		$(this).blur()
	});

	nscol = $('select[name="secimg_noise_color"]');
	nsopt = $('select[name="secimg_noise_color"] option:selected');
	nscol.css( 'color', nsopt.attr('data-color') );
	nscol.css( 'background', nsopt.val() );

	nscol.change(function() {
		nsopt = $('select[name="secimg_noise_color"] option:selected');
		nscol.css( 'color', nsopt.attr('data-color') );
		nscol.css( 'background', nsopt.val() );
		$(this).blur()
	});

	lncol = $('select[name="secimg_line_color"]');
	lnopt = $('select[name="secimg_line_color"] option:selected');
	lncol.css( 'color', lnopt.attr('data-color') );
	lncol.css( 'background', lnopt.val() );

	lncol.change(function() {
		lnopt = $('select[name="secimg_line_color"] option:selected');
		lncol.css( 'color', lnopt.attr('data-color') );
		lncol.css( 'background', lnopt.val() );
		$(this).blur()
	});
});
</script>
