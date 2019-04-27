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
$admin_url = admin_url();
?>
<ul>
<li>
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe&active=optimize"><?php echo __( 'Compression and optimization', 'luxeritas' ); ?></a></p>
<p><?php echo __( 'Compression ratio of HTML', 'luxeritas' ); ?></p>
<select name="html_compress">
<option value="none"<?php thk_value_check( 'html_compress', 'select', 'none' ); ?>><?php echo __( 'Do not compress', 'luxeritas' ); ?></option>
<option value="low"<?php thk_value_check( 'html_compress', 'select', 'low' ); ?>><?php echo __( 'Compression rate low', 'luxeritas' ); ?></option>
<option value="high"<?php thk_value_check( 'html_compress', 'select', 'high' ); ?>><?php echo __( 'Compression rate high', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p><?php echo __( 'CSS compression of child theme', 'luxeritas' ); ?></p>
<select name="child_css_compress">
<option value="none"<?php thk_value_check( 'child_css_compress', 'select', 'none' ); ?>><?php echo __( 'Do not compress', 'luxeritas' ); ?></option>
<option value="comp"<?php thk_value_check( 'child_css_compress', 'select', 'comp' ); ?>><?php echo __( 'Compress only the child theme CSS', 'luxeritas' ); ?></option>
<option value="bind"<?php thk_value_check( 'child_css_compress', 'select', 'bind' ); ?>><?php echo __( 'Compression after combining CSS of parent and child', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p><?php echo __( 'Javascript compression of child theme', 'luxeritas' ); ?></p>
<select name="child_js_compress">
<option value="none"<?php thk_value_check( 'child_js_compress', 'select', 'none' ); ?>><?php echo __( 'Do not compress', 'luxeritas' ); ?></option>
<option value="comp"<?php thk_value_check( 'child_js_compress', 'select', 'comp' ); ?>><?php echo __( 'Compress', 'luxeritas' ); ?></option>
<option value="noload"<?php thk_value_check( 'child_js_compress', 'select', 'noload' ); ?>><?php echo __( 'Not required (no load)', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe&active=style">CSS</a></p>
<p class="m25-b">
<input type="checkbox" value="" name="css_to_style"<?php thk_value_check( 'css_to_style', 'checkbox' ); ?> />
<?php echo __( 'Include theme&apos;s CSS in HTML', 'luxeritas' ); ?>
</p>
<p><?php echo __( 'CSS for WordPress block library', 'luxeritas' ); ?></p>
<select name="wp_block_library_load">
<option value="inline"<?php thk_value_check( 'wp_block_library_load', 'select', 'inline' ); ?>><?php echo __( 'Include CSS in HTML', 'luxeritas' ); ?></option>
<option value="none"<?php thk_value_check( 'wp_block_library_load', 'select', 'none' ); ?>><?php echo __( 'Not required (no load)', 'luxeritas' ); ?></option>
<option value="default"<?php thk_value_check( 'wp_block_library_load', 'select', 'default' ); ?>><?php echo __( 'Leave initial setting of WordPress', 'luxeritas' ); ?></option>
</select>
</li>
<li class="m25-b">
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe&active=script">Javascript</a></p>
<p><?php printf( __( 'How to load jQuery', 'luxeritas' ), 'Meta keywords ' ); ?></p>
<select name="jquery_load">
<option value="google1"<?php thk_value_check( 'jquery_load', 'select', 'google1' ); ?>><?php echo 'Google CDN - jQuery v1 ( ', __( 'Stable', 'luxeritas' ), ' )'; ?></option>
<option value="google2"<?php thk_value_check( 'jquery_load', 'select', 'google2' ); ?>><?php echo 'Google CDN - jQuery v2 ( ', __( 'High speed', 'luxeritas' ), ' / ', __( 'Not supported before IE8', 'luxeritas' ), ' )'; ?></option>
<option value="google3"<?php thk_value_check( 'jquery_load', 'select', 'google3' ); ?>><?php echo 'Google CDN - jQuery v3 ( ', __( 'Recommend', 'luxeritas' ), ' / ', __( 'High speed', 'luxeritas' ), ' / ', __( 'Not supported before IE8', 'luxeritas' ), ' )'; ?></option>
<option value="wordpress"<?php thk_value_check( 'jquery_load', 'select', 'wordpress' ); ?>><?php echo __( 'WordPress Built In jQuery', 'luxeritas' ), ' ( ', __( 'Most stable', 'luxeritas' ), ' / ', __( 'Default behavior of WordPress.', 'luxeritas' ), ' )'; ?></option>
<option value="luxeritas"<?php thk_value_check( 'jquery_load', 'select', 'luxeritas' ); ?>><?php echo __( 'WordPress Built In jQuery', 'luxeritas' ), ' - ', __( 'Combine jQuery and Luxeritas\'s script', 'luxeritas' ), ' ( ', __( 'High speed', 'luxeritas' ), ' / ', __( 'More stable', 'luxeritas' ), ' )'; ?></option>
<option value="none"<?php thk_value_check( 'jquery_load', 'select', 'none' ); ?>><?php echo __( 'Not load jQuery', 'luxeritas' ); ?></option>
</select>
</li>
<li class="m25-b">
<input type="checkbox" value="" name="jquery_defer"<?php thk_value_check( 'jquery_defer', 'checkbox' ); ?> />
<?php echo __( 'Make jQuery asynchronous ( It will boost speed, be careful when using this. )', 'luxeritas' ); ?>
<p class="f09em"><?php echo __( '* ', 'luxeritas' ), '<span class="bg-gray">', __( 'Please do not check if you do not have knowledge.', 'luxeritas' ), '</span>', ' (', __( 'Some plugin may not work correctly when this option is enabled.', 'luxeritas' ), ')'; ?></p>
</li>
<li>
<p class="control-title"><a href="<?php echo $admin_url; ?>customize.php?return=%2Fwp-admin%2Fadmin.php%3Fpage%3Dluxe_fast&luxe=custom"><?php echo 'Lazy Load (' . __( 'Lazy loading of image', 'luxeritas' ) . ')' ?></a></p>
<p class="checkbox">
<input type="checkbox" value="" name="lazyload_thumbs"<?php thk_value_check( 'lazyload_thumbs', 'checkbox' ); ?> />
<?php echo __( 'Enable Lazy Load for various thumbnail images', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="lazyload_contents"<?php thk_value_check( 'lazyload_contents', 'checkbox' ); ?> />
<?php echo __( 'Enable Lazy Load for post contents', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="lazyload_sidebar"<?php thk_value_check( 'lazyload_sidebar', 'checkbox' ); ?> />
<?php echo __( 'Enable Lazy Load for sidebar', 'luxeritas' ); ?>
</p>
<p class="m25-b f09em"><span class="bg-gray"><?php echo __( '* The scroll follow sidebar may become strange movement.', 'luxeritas' ); ?></span></p>
<p class="checkbox">
<input type="checkbox" value="" name="lazyload_footer"<?php thk_value_check( 'lazyload_footer', 'checkbox' ); ?> />
<?php echo __( 'Enable Lazy Load for footer', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="lazyload_avatar"<?php thk_value_check( 'lazyload_avatar', 'checkbox' ); ?> />
<?php echo __( 'Enable Lazy Load for Gravatar', 'luxeritas' ); ?>
</p>

<?php
if( isset( $luxe['fucking_jetpack'] ) ) {
?>
<p class="checkbox" id="disable_jetpack_lazyload_style">
<input type="checkbox" value="" name="disable_jetpack_lazyload"<?php thk_value_check( 'disable_jetpack_lazyload', 'checkbox' ); ?> />
<?php echo __( 'Disable Jetpack&apos;s Lazy Load', 'luxeritas' ); ?>
</p>
<?php
}
?>

</li>
<li>
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe&active=others"><?php echo __( 'Others', 'luxeritas' ); ?></a></p>
<p class="checkbox">
<input type="checkbox" value="" name="buffering_enable"<?php thk_value_check( 'buffering_enable', 'checkbox' ); ?> />
<?php echo __( 'To enable the sequential output of buffering', 'luxeritas' ); ?>
</p>
<p class="f09em m25-b"><span class="bg-gray"><?php echo __( '* If you use cache related plugins, it may conflict one another.', 'luxeritas' ); ?></span></p>
</li>
<li class="m25-b">
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe_sns&active=sns_setting"><?php echo __( 'SNS count cache', 'luxeritas' ); ?></a></p>
<input type="checkbox" value="" name="sns_count_cache_enable"<?php thk_value_check( 'sns_count_cache_enable', 'checkbox', false ); ?> />
<?php echo __( 'Eanable cache for SNS counter', 'luxeritas' ); ?>
<p class="f09em"><span class="bg-gray"><?php echo __( '* will not function if normal SNS button is selected.', 'luxeritas' ); ?></span></p>
</li>
<li>
<p><?php echo __( 'Interval for cache restructure', 'luxeritas' ); ?></p>
<select name="sns_count_cache_expire">
<option value="60"<?php thk_value_check( 'sns_count_cache_expire', 'select', 60 ); ?>><?php printf( __( '%s seconds', 'luxeritas' ), 60 ); ?></option>
<option value="600"<?php thk_value_check( 'sns_count_cache_expire', 'select', 600 ); ?>><?php printf( __( '%s minutes', 'luxeritas' ), 10 ); ?></option>
<option value="1800"<?php thk_value_check( 'sns_count_cache_expire', 'select', 1800 ); ?>><?php printf( __( '%s minutes', 'luxeritas' ), 30 ); ?></option>
<option value="3600"<?php thk_value_check( 'sns_count_cache_expire', 'select', 3600 ); ?>><?php printf( __( '%s hour', 'luxeritas' ), 1 ); ?></option>
<option value="10800"<?php thk_value_check( 'sns_count_cache_expire', 'select', 10800 ); ?>><?php printf( __( '%s hours', 'luxeritas' ), 3 ); ?></option>
<option value="21600"<?php thk_value_check( 'sns_count_cache_expire', 'select', 21600 ); ?>><?php printf( __( '%s hours', 'luxeritas' ), 6 ); ?></option>
<option value="43200"<?php thk_value_check( 'sns_count_cache_expire', 'select', 43200 ); ?>><?php printf( __( '%s hours', 'luxeritas' ), 12 ); ?></option>
<option value="86400"<?php thk_value_check( 'sns_count_cache_expire', 'select', 86400 ); ?>><?php printf( __( '%s day', 'luxeritas' ), 1 ); ?></option>
</select>
</li>
<li>
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe&active=amp">AMP</a></p>
<p><?php echo __( '* Please setting this item yourself.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="control-title"><a href="<?php echo $admin_url; ?>admin.php?page=luxe&active=pwa">PWA</a></p>
<p><?php echo __( '* Please setting this item yourself.', 'luxeritas' ); ?></p>
</li>
</ul>
<script>
jQuery(document).ready(function(o) {
	var A = o('select[name="html_compress"]'),
		B = o('select[name="child_css_compress"]'),
		z = o('select[name="child_js_compress"]'),
		n = o('input[name="css_to_style"]'),
		v = o('select[name="wp_block_library_load"]'),
		x = o('select[name="jquery_load"]'),
		s = o('input[name="jquery_defer"]'),
		y = o('input[name="lazyload_thumbs"]'),
		G = o('input[name="lazyload_contents"]'),
		t = o('input[name="lazyload_sidebar"]'),
		q = o('input[name="lazyload_footer"]'),
		r = o('input[name="lazyload_avatar"]'),
		p = o('input[name="disable_jetpack_lazyload"]'),
		w = o('input[name="buffering_enable"]'),
		u = o('input[name="sns_count_cache_enable"]'),
		F = o('select[name="sns_count_cache_expire"]');
	o("#speed-recommend").on("click", function() {
		A.val("low");
		B.val("bind");
		z.val("comp");
		n.prop("checked", true);
		v.val("inline");
		x.val("google3");
		s.prop("checked", false);
		y.prop("checked", true);
		G.prop("checked", true);
		t.prop("checked", false);
		q.prop("checked", true);
		r.prop("checked", true);
		p.prop("checked", true);
		w.prop("checked", false);
		u.prop("checked", true);
		F.val("3600")
	});
	o("#speed-extreme").on("click", function() {
		A.val("high");
		B.val("bind");
		z.val("comp");
		n.prop("checked", true);
		v.val("inline");
		x.val("google3");
		s.prop("checked", true);
		y.prop("checked", true);
		G.prop("checked", true);
		t.prop("checked", true);
		q.prop("checked", true);
		r.prop("checked", true);
		p.prop("checked", true);
		w.prop("checked", true);
		u.prop("checked", true);
		F.val("3600")
	});
	o("#speed-default").on("click", function() {
		A.val("low");
		B.val("bind");
		z.val("none");
		n.prop("checked", true);
		v.val("inline");
		x.val("google3");
		s.prop("checked", false);
		y.prop("checked", false);
		G.prop("checked", false);
		t.prop("checked", false);
		q.prop("checked", false);
		r.prop("checked", false);
		p.prop("checked", false);
		w.prop("checked", false);
		u.prop("checked", false);
		F.val("600")
	});
	o("#speed-recommend,#speed-extreme,#speed-default").on("click", function() {
		o("#save").prop("disabled", false);
		o("#speed-msg").hide();
		o("#speed-msg").fadeIn(1500);
		if ($(this)[0].id === "speed-extreme") {
			o("#speed-msg span").css("background", "#ef9c99")
		} else {
			if ($(this)[0].id === "speed-default") {
				o("#speed-msg span").css("background", "#4cb5e8")
			} else {
				o("#speed-msg span").css("background", "#4da619")
			}
		}
	});
	o("#speed-recommend").prop("disabled", false);
	o("#speed-extreme").prop("disabled", false);
	o("#speed-default").prop("disabled", false)
});
</script>
