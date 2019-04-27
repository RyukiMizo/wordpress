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
<p class="label-title"><?php echo __( 'Load CSS for widgets', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* If you are not using CSS for widgets, disabling its load will decrease the total filze size of the page and can make your page render faster.', 'luxeritas' ); ?></p>
</li>
<li>
<table id="amp-plugins">
<thead>
<tr><th class="amp-cbox">Normal</th><th class="amp-cbox">AMP</th><th><?php echo __( 'Widget', 'luxeritas' ); ?></th></tr>
</thead>
<tbody>
<?php
$widget_css = array(
	'css_search'		=> __( 'Search Form Widget', 'luxeritas' ),
	'css_archive'		=> __( 'Categories &amp; Archive DropDown Widget', 'luxeritas' ),
	'css_calendar'		=> __( 'Calendar Widget', 'luxeritas' ),
	'css_tagcloud'		=> __( 'Tag cloud Widget', 'luxeritas' ),
	'css_new_post'		=> __( 'Recent posts', 'luxeritas' ) . ' (' . __( 'by Luxeritas', 'luxeritas' ) . ')',
	'css_adsense'		=> __( 'Adsense Widget', 'luxeritas' ) . ' (' . __( 'by Luxeritas', 'luxeritas' ) . ')',
	'css_rcomments'		=> __( 'Recent Comments', 'luxeritas' ) . ' (' . __( 'by Luxeritas', 'luxeritas' ) . ')',
	'css_follow_button'	=> __( 'SNS Follow Button (by Luxeritas)', 'luxeritas' ),
	'css_rss_feedly'	=> __( 'RSS / Feedly Button (by Luxeritas)', 'luxeritas' ),
	'css_qr_code'		=> __( 'QR Code', 'luxeritas' ) . ' (' . __( 'by Luxeritas', 'luxeritas' ) . ')',
);
$widget_no_amp = array(
	'css_search'		=> true,
);

foreach( $widget_css as $key => $val ) {
?>
<tr>
<td class="amp-cbox"><input type="checkbox" value="" name="<?php echo $key ?>"<?php thk_value_check( $key, 'checkbox' ); ?> /></td>
<?php
	if( !isset( $widget_no_amp[$key] ) ) {
?>
<td class="amp-cbox"><input type="checkbox" value="" name="amp_<?php echo $key ?>"<?php thk_value_check( 'amp_' . $key, 'checkbox' ); ?> /></td>
<?php
	}
	else {
?>
<td class="amp-cbox"><input type="checkbox" disabled /></td>
<?php
	}
?>
<td><?php echo $val; ?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</li>
</ul>
