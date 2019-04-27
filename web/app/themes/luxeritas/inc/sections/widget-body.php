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

global $wp_widget_factory;
$thk_widget = array();
$widget_bodys = thk_widget_prefix( 'body' );

foreach( $wp_widget_factory->widgets as $key => $val ) {
	$id_base = $val->id_base;
	if( !isset( $thk_widget[$id_base] ) ) {
		$thk_widget[$id_base] = $val->name;
	}
}
asort( $thk_widget );
?>
<p class="f09em m10-b"><?php echo __( '* When checked, hides the widget.', 'luxeritas' ); ?></p>
<table id="thk-widget-table" class="wp-list-table widefat striped">
<colgroup span="1" style="width:auto" />
<colgroup span="8" class="al-c" style="width:70px" />
<thead>
<tr>
<th scope="col" class="manage-column column-title column-primary al-c"><?php echo __( 'Widget', 'luxeritas' ); ?></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Home', 'luxeritas' ); ?>" class="dashicons dashicons-admin-home"></span><br /><span class="f09em">Home</span></th>
<th scope="col" class="manage-column al-c"><span title="<?php echo __( 'Post page', 'luxeritas' ); ?>" class="dashicons dashicons-media-default"></span><br /><span class="f09em">Post</span></th>
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
foreach( (array)$thk_widget as $key => $val ) {
?>
<tr>
<td class="column-primary">
<?php echo $val; ?>
<p><button type="button" class="toggle-row"></button></p>
</td>
<?php
	foreach( $widget_bodys as $value ) {
		switch( $value ) {
			case 'widget_bt_': $colname = __( 'Home', 'luxeritas' );	$colicon = 'dashicons-admin-home';		break;
			case 'widget_bw_': $colname = __( 'Post page', 'luxeritas' );	$colicon = 'dashicons-welcome-write-blog';	break;
			case 'widget_bp_': $colname = __( 'Static page', 'luxeritas' );	$colicon = 'dashicons-admin-page';		break;
			case 'widget_bc_': $colname = __( 'Category', 'luxeritas' );	$colicon = 'dashicons-category';		break;
			case 'widget_ba_': $colname = __( 'Archive', 'luxeritas' );	$colicon = 'dashicons-list-view';		break;
			case 'widget_bs_': $colname = __( 'Search result page', 'luxeritas' ); $colicon = 'dashicons-search';		break;
			case 'widget_bv_': $colname = __( 'Preview', 'luxeritas' );	$colicon = 'dashicons-welcome-write-blog';	break;
			case 'widget_b4_': $colname = '404 Not Found';			$colicon = 'dashicons-dismiss';			break;
			default: $colname = ''; break;
		}
?>
<td class="al-c"><input type="checkbox" value="" name="<?php echo $value, $key; ?>"<?php thk_value_check( $value . $key, 'checkbox' ); ?> /><span class="colname"><span class="dashicons <?php echo $colicon; ?>"></span>&nbsp;<?php echo $colname; ?></span></td>
<?php
	}
?>
</tr>
<?php
}
?>
</tbody>
</table>
