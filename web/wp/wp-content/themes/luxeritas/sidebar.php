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

if( isset( $luxe['amp'] ) ) {
	get_template_part( 'sidebar-amp' );
	return;
}
?>
<div id="sidebar">
<div id="side">
<aside<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="complementary"'; ?>>
<?php
if( function_exists('dynamic_sidebar') === true ) {
	$_is_home = is_home();
	$_is_front_page = is_front_page();
	$_is_active_side_h3 = is_active_sidebar('side-h3');
	$_is_active_side_h4 = is_active_sidebar('side-h4');
	$_is_active_side_top_h3 = false;
	$_is_active_side_top_h4 = false;
	$_is_active_side_no_top_h3 = false;
	$_is_active_side_no_top_h4 = false;

	if( $_is_home === true || $_is_front_page === true ) {
		$_is_active_side_top_h3 = is_active_sidebar('side-top-h3');
		$_is_active_side_top_h4 = is_active_sidebar('side-top-h4');
	}
	else {
		$_is_active_side_no_top_h3 = is_active_sidebar('side-no-top-h3');
		$_is_active_side_no_top_h4 = is_active_sidebar('side-no-top-h4');
	}

	if(
		( $_is_active_side_h3 === true ) ||
		( $_is_active_side_h4 === true ) ||
		( $_is_active_side_top_h3 === true ) ||
		( $_is_active_side_top_h4 === true ) ||
		( $_is_active_side_no_top_h3 === true ) ||
		( $_is_active_side_no_top_h4 === true )
	) {
?>
<div id="side-fixed">
<?php
		if( $_is_active_side_h3 === true ) dynamic_sidebar( 'side-h3' );
		if( $_is_active_side_h4 === true ) dynamic_sidebar( 'side-h4' );

		if( $_is_home === true || $_is_front_page === true ) {
			if( $_is_active_side_top_h3 === true ) dynamic_sidebar( 'side-top-h3' );
			if( $_is_active_side_top_h4 === true ) dynamic_sidebar( 'side-top-h4' );
		}
		else {
			if( $_is_active_side_no_top_h3 === true ) dynamic_sidebar( 'side-no-top-h3' );
			if( $_is_active_side_no_top_h4 === true ) dynamic_sidebar( 'side-no-top-h4' );
		}
?>
</div>
<?php
	}
	if( is_active_sidebar('side-scroll') === true ) {
?>
<div id="side-scroll">
<?php
	dynamic_sidebar( 'side-scroll' );
?>
</div>
<?php
	}
}
?>
</aside>
</div><!--/#side-->
</div><!--/#sidebar-->
