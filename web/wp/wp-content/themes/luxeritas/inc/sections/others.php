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
?>
<ul>
<li>
<p class="control-title"><?php echo __( '404 Not Found Page', 'luxeritas' ); ?></p>
<?php
echo wp_dropdown_pages( array( 
	'name' => 'not404', 
	'echo' => false, 
	'show_option_none' => __( 'Default', 'luxeritas' ), 
	'option_none_value' => '', 
	'selected' =>  isset( $luxe['not404'] ) ? $luxe['not404'] : '',
));
?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Site display settings', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="buffering_enable"<?php thk_value_check( 'buffering_enable', 'checkbox' ); ?> />
<?php echo __( 'To enable the sequential output of buffering', 'luxeritas' ); ?>
</p>
<p class="f09em"><?php echo __( '* It will improve the speed if you check this.', 'luxeritas' ); ?></p>
<p class="f09em m25-b"><?php echo __( '* If you use cache related plugins, it may conflict one another.', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="add_role_attribute"<?php thk_value_check( 'add_role_attribute', 'checkbox' ); ?> />
<?php echo __( 'Add the role attribute for a barrier-free', 'luxeritas' ); ?>
</p>

<span id="disable_jetpack_lazyload"></span>

<p class="checkbox">
<input type="checkbox" value="" name="remove_hentry_class"<?php thk_value_check( 'remove_hentry_class', 'checkbox' ); ?> />
<?php echo __( 'Remove hentry class', 'luxeritas' ); ?>
</p>
<p class="f09em m25-b"><?php echo __( '* Checking this will avoid getting hetnry errors from Google Webmasters even if you have the post dates, update dates, and author information not displayed.', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="enable_mb_slug"<?php thk_value_check( 'enable_mb_slug', 'checkbox' ); ?> />
<?php echo __( 'Allow multi byte characters for slugs', 'luxeritas' ), ' (', __( 'Not recommended', 'luxeritas' ), ')'; ?>
</p>
<?php
global $luxe;
if( isset( $luxe['fucking_jetpack'] ) ) {
?>
<p class="checkbox" id="disable_jetpack_lazyload_style">
<input type="checkbox" value="" name="disable_jetpack_lazyload"<?php thk_value_check( 'disable_jetpack_lazyload', 'checkbox' ); ?> />
<?php echo __( 'Disable Jetpack&apos;s Lazy Load', 'luxeritas' ); ?>
</p>
<script>
(function() {
	var hash = location.hash
	,   clikMsg = document.getElementById("disable_jetpack_lazyload_msg")
	,   lazyMsg = function() {
		$("#disable_jetpack_lazyload_style").css({'display':'inline-block', 'margin-left':'-9px', 'border':'2px solid red', 'padding':'5px 7px'});
	};
	if( hash === "#disable_jetpack_lazyload" ) {
		lazyMsg();
	} if( clikMsg ) {
		clikMsg.onclick = function() {
			lazyMsg();
		};
	}
}());
</script>
<?php
}
?>
</li>

<li>
<p class="control-title"><?php echo __( 'Media', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="media_alt_auto_input"<?php thk_value_check( 'media_alt_auto_input', 'checkbox' ); ?> />
<?php echo __( 'Enable automatic entry of alternative text (ALT attribute) on media screen', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Prevent automatic conversion to link', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="prevent_tel_links"<?php thk_value_check( 'prevent_tel_links', 'checkbox' ); ?> />
<?php echo __( 'Prevent detected phone numbers turning into links.', 'luxeritas' ); ?> ( <?php printf( __( 'Mainly %s', 'luxeritas'), __( 'Smartphone', 'luxeritas' ) . ' / Microsoft Edge' ); ?> )
</p>
<p class="checkbox">
<input type="checkbox" value="" name="prevent_email_links"<?php thk_value_check( 'prevent_email_links', 'checkbox' ); ?> />
<?php echo __( 'Prevent detected email address turning into links.', 'luxeritas' ); ?> ( <?php printf( __( 'Mainly %s', 'luxeritas'), __( 'Smartphone', 'luxeritas' ) ); ?> )
</p>
<p class="checkbox">
<input type="checkbox" value="" name="prevent_address_links"<?php thk_value_check( 'prevent_address_links', 'checkbox' ); ?> />
<?php echo __( 'Prevent detected address turning into links.', 'luxeritas' ); ?> ( <?php printf( __( 'Mainly %s', 'luxeritas'), __( 'Smartphone', 'luxeritas' ) ); ?> )
</p>
<p class="checkbox">
<input type="checkbox" value="" name="prevent_comment_links"<?php thk_value_check( 'prevent_comment_links', 'checkbox' ); ?> />
<?php echo __( 'Prevent URLs written in comments turning into links.', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'user-scalable ' ); ?></p>
<p class="f09em"><?php echo __( '* If you choose NO, the older version of Androids will be able to have sticky menus.  But it will  <span style="font-weight:bold">disalllow zoom function on smartphones</span>.', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="yes" name="user_scalable"<?php thk_value_check( 'user_scalable', 'radio', 'yes' ); ?> />
yes
</p>
<p class="radio">
<input type="radio" value="no" name="user_scalable"<?php thk_value_check( 'user_scalable', 'radio', 'no' ); ?> />
no
</p>
</li>

<li>
<p class="control-title"><?php printf( __( 'Setting for %s', 'luxeritas' ), __( 'design purpose', 'luxeritas' ) ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="categories_a_inner"<?php thk_value_check( 'categories_a_inner', 'checkbox' ); ?> />
<?php echo __( 'Place the number of posts inside the &lt;a&gt; tag in the category widget', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="checkbox">
<input type="checkbox" value="" name="archives_a_inner"<?php thk_value_check( 'archives_a_inner', 'checkbox' ); ?> />
<?php echo __( 'Place the number of posts inside the &lt;a&gt; tag in the archive widget', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="checkbox">
<input type="checkbox" value="" name="parent_css_uncompress"<?php thk_value_check( 'parent_css_uncompress', 'checkbox' ); ?> />
<?php echo __( 'Non-compression for Parent Theme (for debugging)', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Measures to be taken when the widget cannot be saved', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* It may be worth a try if you can not save with WAF or plug-ins.', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="measures_against_waf"<?php thk_value_check( 'measures_against_waf', 'checkbox' ); ?> />
<?php echo __( 'Measures to be taken when the widget save button cannot be saved by spinning around.', 'luxeritas' ); ?>
</p>
</li>
</ul>
