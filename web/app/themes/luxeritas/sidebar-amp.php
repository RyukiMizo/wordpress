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
<div id="sidebar">
<div id="side">
<aside<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="complementary"'; ?>>
<?php
if(
	function_exists('dynamic_sidebar') === true && is_active_sidebar('side-amp') === true
) {
?>
<div id="side-fixed">
<?php
	echo thk_amp_dynamic_sidebar( 'side-amp' );
?>
</div>
<?php
}
?>
</aside>
</div><!--/#side-->
</div><!--/#sidebar-->
