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
<li class="m25-b">
<p class="control-title"><?php printf( __( 'How to load jQuery', 'luxeritas' ), 'Meta keywords ' ); ?></p>
<select name="jquery_load">
<option value="google1"<?php thk_value_check( 'jquery_load', 'select', 'google1' ); ?>><?php echo 'Google CDN - jQuery v1 ( ', __( 'Stable', 'luxeritas' ), ' )'; ?></option>
<option value="google2"<?php thk_value_check( 'jquery_load', 'select', 'google2' ); ?>><?php echo 'Google CDN - jQuery v2 ( ', __( 'High speed', 'luxeritas' ), ' / ', __( 'Not supported before IE8', 'luxeritas' ), ' )'; ?></option>
<option value="google3"<?php thk_value_check( 'jquery_load', 'select', 'google3' ); ?>><?php echo 'Google CDN - jQuery v3 ( ', __( 'Recommend', 'luxeritas' ), ' / ', __( 'High speed', 'luxeritas' ), ' / ', __( 'Not supported before IE8', 'luxeritas' ), ' )'; ?></option>
<option value="wordpress"<?php thk_value_check( 'jquery_load', 'select', 'wordpress' ); ?>><?php echo __( 'WordPress Built In jQuery', 'luxeritas' ), ' ( ', __( 'Most stable', 'luxeritas' ), ' / ', __( 'Default behavior of WordPress.', 'luxeritas' ), ' )'; ?></option>
<option value="luxeritas"<?php thk_value_check( 'jquery_load', 'select', 'luxeritas' ); ?>><?php echo __( 'WordPress Built In jQuery', 'luxeritas' ), ' - ', __( 'Combine jQuery and Luxeritas\'s script', 'luxeritas' ), ' ( ', __( 'High speed', 'luxeritas' ), ' / ', __( 'More stable', 'luxeritas' ), ' )'; ?></option>
<option value="none"<?php thk_value_check( 'jquery_load', 'select', 'none' ); ?>><?php echo __( 'Not load jQuery', 'luxeritas' ); ?></option>
</select>
<p class="f09em m25-b"><?php echo __( '* JQuery loading from CDN is not designed to avoid conflicts.', 'luxeritas' ); ?></p>
</li>
<li>
<input type="checkbox" value="" name="jquery_migrate_load"<?php thk_value_check( 'jquery_migrate_load', 'checkbox' ); ?> />
<?php echo __( 'Load jQuery-Migrate', 'luxeritas' ); ?>
<p class="f09em m25-b"><?php echo __( '* Older plugins that have not been updated may require jQuery-Migrate.', 'luxeritas' ); ?></p>
</li>
<li>
<input type="checkbox" value="" name="jquery_defer"<?php thk_value_check( 'jquery_defer', 'checkbox' ); ?> />
<?php echo __( 'Make jQuery asynchronous ( It will boost speed, be careful when using this. )', 'luxeritas' ); ?>
<p class="f09em"><?php echo __( '* When you are combining jQuery and other scripts, Will add &quot;async&quot; property for jQuery and add &quot;defer&quot; property for external script plugin files.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Otherwise, Will add &quot;defer&quot; property for jQuery and external script plugin files. ( &quot;async&quot; property will not be added )', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* ', 'luxeritas' ), '<span class="bg-gray">', __( 'Please do not check if you do not have knowledge.', 'luxeritas' ), '</span>', ' (', __( 'Some plugin may not work correctly when this option is enabled.', 'luxeritas' ), ')'; ?></p>
</li>
</ul>
