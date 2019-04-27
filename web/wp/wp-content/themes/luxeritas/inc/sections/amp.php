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
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'AMP ' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="amp_enable"<?php thk_value_check( 'amp_enable', 'checkbox' ); ?> />
<?php printf( __( 'Enable %s', 'luxeritas' ), 'AMP ( Accelerated Mobile Pages )' . ' ' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="amp_hidden_comments"<?php thk_value_check( 'amp_hidden_comments', 'checkbox' ); ?> />
<?php echo __( 'Do not show comment list', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Plug-in to be activated with AMP', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* If you activate a plugin that inserts elements forbidden by AMP, an AMP error occurs.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* It is not necessary to activate the plugin which is necessary only in the management screen.', 'luxeritas' ); ?></p>
<table id="amp-plugins">
<thead>
<tr><th class="amp-cbox">Normal</th><th class="amp-cbox">AMP</th><th>Plugins</th></tr>
</thead>
<tbody>
<?php
if( function_exists( 'get_plugins' ) === false ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
$all_plugins = get_plugins();
foreach( (array)$all_plugins as $key => $val ) {
	if( stripos( $key, 'wp-multibyte-patch' ) !== false ) {
?>
<tr>
<td class="amp-cbox"><input type="checkbox" disabled<?php echo is_plugin_active( $key ) === true ? ' checked' : ''; ?> /></td>
<td class="amp-cbox"><input type="checkbox" disabled checked /></td>
<td><span style="opacity:.6"><?php echo $val['Name']; ?></span></td>
</tr>
<?php
	}
	else {
?>
<tr>
<td class="amp-cbox"><input type="checkbox" disabled<?php echo is_plugin_active( $key ) === true ? ' checked' : ''; ?> /></td>
<td class="amp-cbox"><input type="checkbox" value="" name="amp_plugin_<?php echo strlen( $key ) . '_' . md5( $key ); ?>"<?php thk_value_check( 'amp_plugin_' . strlen( $key ) . '_'  . md5( $key ), 'checkbox' ); ?> /></td>
<td><?php echo $val['Name']; ?></td>
</tr>
<?php
	}
}
?>
</tbody>
</table>
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), __( 'AMP Logo image', 'luxeritas' ) ); ?></p>
<p class="radio">
<input type="radio" value="same" name="amp_logo_same"<?php thk_value_check( 'amp_logo_same', 'radio', 'same' ); ?> />
<?php echo __( 'Same as the site logo', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="set" name="amp_logo_same"<?php thk_value_check( 'amp_logo_same', 'radio', 'set' ); ?> />
<?php echo __( 'Set the AMP logo separately', 'luxeritas' ); ?>
</p>

<p class="f09em"><?php echo __( '* the image must be within 600px width, height 60px.', 'luxeritas' ); ?></p>
<?php
	$logo = TURI . '/images/site-logo.png';
	$logo_val = '';
	$amp_logo_same = get_theme_mod( 'amp_logo_same', 'same' );
	$amp_logo = get_theme_mod( 'amp_logo', null );

	if( isset( $amp_logo_same ) && $amp_logo_same === 'same' ) {
		$amp_logo = get_theme_mod( 'site_logo', null );
	}

	if( isset( $amp_logo ) ) {
		$logo = $amp_logo;
		$logo_val = $amp_logo;
	}
?>
<script>thkImageSelector('amp-logo', 'AMP Logo');</script>
<div id="amp-logo-form">
<input id="amp-logo" type="hidden" name="amp_logo" value="<?php echo $logo_val; ?>" />
<input id="amp-logo-set" type="button" class="button" value="<?php echo __( 'Set image', 'luxeritas' ); ?>" />
<input id="amp-logo-del" type="button" class="button" value="<?php echo __( 'Delete image', 'luxeritas' ); ?>" />
<?php
	if( !empty( $logo ) ) {
?>
<div id="amp-logo-view" style="max-width: 300px"><img src="<?php echo $logo; ?>" alt="AMP Logo" style="max-width: 300px" /></div>
<?php
	}
	else {
?>
<div id="amp-logo-view" style="max-width: 300px"></div>
<?php
	}
?>
</div>
</li>
</ul>
