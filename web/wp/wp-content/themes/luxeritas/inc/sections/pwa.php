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

$_is_ssl = is_ssl();
?>
<ul>
<li>
<p class="m25-b">
<?php
if( $_is_ssl === false ) {
echo '<span class="dashicons dashicons-no" style="color:red;width:24px;font-size:26px;margin:-1px 8px 0 -4px"></span>' . __( 'Your website is not served over SSL', 'luxeritas' );
}
else {
echo '<span class="dashicons dashicons-yes" style="color:green;width:24px;font-size:26px;margin:-1px 8px 0 -4px"></span>' . __( 'Your website is served over SSL', 'luxeritas' );
}
?>
</p>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'PWA ' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="pwa_enable"<?php thk_value_check( 'pwa_enable', 'checkbox' ); if( $_is_ssl === false ) echo ' disabled'; ?> />
<?php printf( __( 'Enable %s', 'luxeritas' ), 'PWA ( Progressive Web Apps )' . ' ' ); ?>
</p>
<p class="f09em m25-b"><?php echo __( '* When checked, users will be able to appear and operate your site like web application on mobile device.', 'luxeritas'); ?></p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="pwa_mobile"<?php thk_value_check( 'pwa_mobile', 'checkbox' ); if( !isset( $luxe['pwa_enable'] ) ) echo ' disabled'; ?> />
<?php echo __( 'Enable PWA only for access from mobile device', 'luxeritas' ); ?>
</p>
<p class="m25-b"><span class="f09em bold bg-gray"><?php echo __( '* If cache plugin is installed, it may not behavior properly.', 'luxeritas'); ?></span></p>
</li>
<li>
<p class="control-title"><?php echo __( 'Offline Page', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="pwa_offline_enable"<?php thk_value_check( 'pwa_offline_enable', 'checkbox' ); if( !isset( $luxe['pwa_enable'] ) ) echo ' disabled'; ?> />
<?php echo __( 'Allow browsing offline by caching', 'luxeritas' ); ?>
</p>
</li>
<li>
<p style="margin:10px 0 15px 0">
<input type="checkbox" value="" name="pwa_install_button"<?php thk_value_check( 'pwa_install_button', 'checkbox' ); if( !isset( $luxe['pwa_offline_enable'] ) ) echo ' disabled'; ?> />
<?php echo __( 'Display application install button', 'luxeritas' ); ?>
</p>
<p class="f09em"><?php echo __( '* In order to display installation button, display mode must be &quot;minimal-ui&quot; or &quot;standalone&quot;.', 'luxeritas' ); ?></p>
<p class="f09em m25-b"><?php echo __( '* Installation button is automatically displayed under certain conditions such as user&apos;s visit frequency. ( The condition depends on browser specs )', 'luxeritas' ); ?></p>
</li>
<li>
<?php
echo wp_dropdown_pages( array( 
	'name' => 'pwa_offline_page', 
	'echo' => false, 
	'show_option_none' => __( 'Top Page', 'luxeritas' ), 
	'option_none_value' => '0', 
	'selected' =>  isset( $luxe['pwa_offline_page'] ) ? $luxe['pwa_offline_page'] : '',
));
?>
</p>
<p class="f09em"><?php echo __( '* Offline page is displayed when the device is offline and the requested page is not already cached.', 'luxeritas'); ?></p>
<p class="f09em m25-b"><?php echo __( '* Please check <code class="normal-family">&quot;Include theme&apos;s CSS in HTML&quot;</code> in CSS setting to display page with CSS applied in cache.', 'luxeritas'); ?></p>
</li>
</ul>
<script>
jQuery(document).ready(function($) {
	var e = $('input[name="pwa_enable"]')
	,   m = $('input[name="pwa_mobile"]')
	,   o = $('input[name="pwa_offline_enable"]')
	,   i = $('input[name="pwa_install_button"]');

	e.on('change', function() {
		if( e.prop('checked') === true ) {
			m.prop('disabled', false);
			o.prop('disabled', false);
		}
		else {
			m.prop('disabled', true);
			o.prop('checked', false);
			o.prop('disabled', true);
			i.prop('checked', false);
			i.prop('disabled', true);
		}
	});
	o.on('change', function() {
		if( o.prop('checked') === true ) {
			i.prop('disabled', false);
		}
		else {
			i.prop('checked', false);
			i.prop('disabled', true);
		}
	});
});
</script>
