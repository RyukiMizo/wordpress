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
<ul>
<li>
<p class="control-title"><?php echo __( 'Layout of search result', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="word" name="search_extract"<?php thk_value_check( 'search_extract', 'radio', 'word' ); ?> />
1. <?php echo __( 'Show excerpt based on word matching', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="normal" name="search_extract"<?php thk_value_check( 'search_extract', 'radio', 'normal' ); ?> />
2. <?php echo __( 'Show normal excerpts', 'luxeritas' ); ?>
</p>
</li>
<li>
<input type="number" value="<?php thk_value_check( 'search_extract_length', 'number' ); ?>" name="search_extract_length" />
<?php echo __( 'Number of letters when #1 is chosen', 'luxeritas' ); ?>
<p class="f09em m25-b"><?php echo __( 'When #2 is chosen, the number of letters set in &quot;Customizing (Appearance)  -&gt; Style Details&quot; will apply.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="control-title"><?php echo __( 'Two-byte and One-byte character distinction', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="default" name="search_match_method"<?php thk_value_check( 'search_match_method', 'radio', 'default' ); ?> />
<?php echo __( 'Apply the WordPress&apos;s MySQL / Maria DB setting', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="unicode" name="search_match_method"<?php thk_value_check( 'search_match_method', 'radio', 'unicode' ); ?> />
<?php echo __( 'Do not distinguish Two/One-Byte and search', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="general" name="search_match_method"<?php thk_value_check( 'search_match_method', 'radio', 'general' ); ?> />
<?php echo __( 'Distinguish Two/One-Byte and search', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Extended Function', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="comment_search"<?php thk_value_check( 'comment_search', 'checkbox' ); ?> />
<?php echo __( 'Include Comments as search results', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="autocomplete"<?php thk_value_check( 'autocomplete', 'checkbox' ); ?> />
<?php echo __( 'Use search string autocomplete function', 'luxeritas' ), ' ( ', __( '* It can not be used with smartphones etc.', 'luxeritas' ), ' )'; ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="search_highlight"<?php thk_value_check( 'search_highlight', 'checkbox' ); ?> />
<?php echo __( 'Highlight the searched words', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Highlight decoration style', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="highlight_bold"<?php thk_value_check( 'highlight_bold', 'checkbox' ); ?> />
<?php echo __( 'Bold', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="highlight_oblique"<?php thk_value_check( 'highlight_oblique', 'checkbox' ); ?> />
<?php echo __( 'Oblique', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="highlight_bg"<?php thk_value_check( 'highlight_bg', 'checkbox' ); ?> />
<?php echo __( 'Apply background color', 'luxeritas' ); ?>
</p>
<select name="highlight_bg_color" style="background:<?php global $luxe; echo $luxe['highlight_bg_color']; ?>">
<?php
require_once( INC . 'colors.php' );

$colors_class = new thk_colors();
$colors = $colors_class->primary_colors();

foreach( $colors as $key => $val ) {
	$text_color = $colors_class->get_text_color_matches_background( $key );
?>
<option value="<?php echo $key; ?>"<?php thk_value_check( 'highlight_bg_color', 'select', $key ); ?> data-color="<?php echo $text_color; ?>" style="background:<?php echo $key; ?>;color:<?php echo $text_color; ?>"><?php echo $val; ?></option>
<?php
}
?>
</select>
<?php echo __( 'Background color', 'luxeritas' ); ?>
<script>
jQuery(function($){
	hicol = $('select[name="highlight_bg_color"]');
	hiopt = $('select[name="highlight_bg_color"] option:selected');
	hicol.css( 'color', hiopt.attr('data-color') );
	hicol.css( 'background', hiopt.val() );

	hicol.change(function() {
		hiopt = $('select[name="highlight_bg_color"] option:selected');
		hicol.css( 'color', hiopt.attr('data-color') );
		hicol.css( 'background', hiopt.val() );
		$(this).blur()
	});
});
</script>
</li>
<li>
<input type="number" value="<?php thk_value_check( 'highlight_radius', 'number' ); ?>" name="highlight_radius" />
<?php echo __( 'Border radius', 'luxeritas' ); ?>
</li>
</ul>
