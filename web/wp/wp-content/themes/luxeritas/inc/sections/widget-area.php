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

//global $wp_registered_sidebars;
$widgets = thk_widget_areas();
$widget_areas = thk_widget_prefix( 'area' );
?>
<p class="f09em m10-b"><?php echo __( '* When checked, hide the widget area.', 'luxeritas' ); ?></p>
<table id="thk-widget-table" class="wp-list-table widefat striped">
<colgroup span="1" style="width:auto" />
<colgroup span="8" class="al-c" style="width:70px" />
<thead>
<tr>
<th class="manage-column column-title column-primary al-c"><?php echo __( 'Widget', 'luxeritas' ); ?></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Home', 'luxeritas' ); ?>" class="dashicons dashicons-admin-home"></span><br /><span class="f09em">Home</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Post page', 'luxeritas' ); ?>" class="dashicons dashicons-welcome-write-blog"></span><br /><span class="f09em">Post</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Static page', 'luxeritas' ); ?>" class="dashicons dashicons-admin-page"></span><br /><span class="f09em">Page</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Category', 'luxeritas' ); ?>" class="dashicons dashicons-category"></span><br /><span class="f09em">Category</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Archive', 'luxeritas' ); ?>" class="dashicons dashicons-list-view"></span><br /><span class="f09em">Archive</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Search result page', 'luxeritas' ); ?>" class="dashicons dashicons-search"></span><br /><span class="f09em">Search</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Preview', 'luxeritas' ); ?>" class="dashicons dashicons-welcome-write-blog"></span><br /><span class="f09em">Preview</span></th>
<th scope="col" class="manage-column al-c"><span title="404 Not Found" class="dashicons dashicons-dismiss"></span><br /><span class="f09em">404</span></th>
</tr>
</thead>
<tbody id="the-list">
<?php
foreach( $widgets as $key => $val ) {
?>
<tr>
<td class="column-primary">
<?php echo $val['name']; ?>
<p><button type="button" class="toggle-row"></button></p>
</td>
<?php
	foreach( $widget_areas as $value ) {
		switch( $value ) {
			case 'widget_at_': $colname = __( 'Home', 'luxeritas' );	$colicon = 'dashicons-admin-home';		break;
			case 'widget_aw_': $colname = __( 'Post page', 'luxeritas' );	$colicon = 'dashicons-welcome-write-blog';	break;
			case 'widget_ap_': $colname = __( 'Static page', 'luxeritas' );	$colicon = 'dashicons-admin-page';		break;
			case 'widget_ac_': $colname = __( 'Category', 'luxeritas' );	$colicon = 'dashicons-category';		break;
			case 'widget_aa_': $colname = __( 'Archive', 'luxeritas' );	$colicon = 'dashicons-list-view';		break;
			case 'widget_as_': $colname = __( 'Search result page', 'luxeritas' ); $colicon = 'dashicons-search';		break;
			case 'widget_av_': $colname = __( 'Preview', 'luxeritas' );	$colicon = 'dashicons-welcome-write-blog';	break;
			case 'widget_a4_': $colname = '404 Not Found';			$colicon = 'dashicons-dismiss';			break;
			default: $colname = ''; break;
		}
?>
<td class="al-c"><input type="checkbox" value="" name="<?php echo $value, $val['id']; ?>"<?php thk_value_check( $value . $val['id'], 'checkbox' ); ?> /><span class="colname"><span class="dashicons <?php echo $colicon; ?>"></span>&nbsp;<?php echo $colname; ?></span></td>
<?php
	}
?>
</tr>
<?php
}
unset( $widgets );
?>
</tbody>
</table>
