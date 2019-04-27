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
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'OGP' . ' ' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="facebook_ogp_enable"<?php thk_value_check( 'facebook_ogp_enable', 'checkbox' ); ?> />
<?php printf( __( 'Add %s', 'luxeritas' ), 'OGP (Open Graph Protocol)' . ' ' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'Facebook' . ' ' ); ?></p>
<p class="label-title">fb:admins (<?php echo __( 'Depreciated: Unnecessary if app_id exists', 'luxeritas' ); ?>)</p>
<input type="text" value="<?php thk_value_check( 'facebook_admin', 'text' ); ?>" name="facebook_admin" />
</li>
<li>
<p class="label-title">fb:app_id (<?php echo __( 'Recommended', 'luxeritas' ); ?>)</p>
<input type="text" value="<?php thk_value_check( 'facebook_app_id', 'text' ); ?>" name="facebook_app_id" />
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), __( 'Twitter Card', 'luxeritas' ) ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="twitter_card_enable"<?php thk_value_check( 'twitter_card_enable', 'checkbox' ); ?> />
<?php printf( __( 'Add %s', 'luxeritas' ), __( 'Twitter Card', 'luxeritas' ) ); ?>
</p>
</li>
<li>
<p class="label-title"><?php printf( __( 'Type of %s', 'luxeritas' ), __( 'Twitter Card', 'luxeritas' ) ); ?></p>
<select name="twitter_card_type">
<option value="summary"<?php thk_value_check( 'twitter_card_type', 'select', 'summary' ); ?>><?php echo __( 'summary', 'luxeritas' ); ?></option>
<option value="summary_large_image"<?php thk_value_check( 'twitter_card_type', 'select', 'summary_large_image' ); ?>><?php echo __( 'summary_large_image', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p class="label-title">Twitter ID ( &#x40; <?php echo __( 'No need', 'luxeritas' )?> )</p>
<input type="text" value="<?php thk_value_check( 'twitter_id', 'text' ); ?>" name="twitter_id" />
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), __( 'default og:image', 'luxeritas' ) ); ?></p>
<p class="f09em"><?php echo __( '* When og:image is not set in the post, the default image set here will be applied.', 'luxeritas' ); ?></p>
<?php
	//global $luxe;

	$image = TURI . '/images/og-h200.png';
	$img_val = '';
	$og = get_theme_mod( 'og_img', null );
	if( isset( $og ) ) {
		$image = $og;
		$img_val = $og;
	}
?>
<script>thkImageSelector('og-img', 'og:image / twitter:image');</script>
<div id="og-img-form">
<input id="og-img" type="hidden" name="og_img" value="<?php echo $img_val; ?>" />
<input id="og-img-set" type="button" class="button" value="<?php echo __( 'Set image', 'luxeritas' ); ?>" />
<input id="og-img-del" type="button" class="button" value="<?php echo __( 'Delete image', 'luxeritas' ); ?>" />
<?php
	if( !empty( $image ) ) {
?>
<div id="og-img-view"><img src="<?php echo $image; ?>" alt="og:image" width="1" height="1" /></div>
<?php
	}
	else {
?>
<div id="og-img-view"></div>
<?php
	}
?>
<p class="f09em m0-t"><?php echo __( '* The above image is a reduced version.', 'luxeritas' ); ?></p>
</div>
</li>
</ul>
