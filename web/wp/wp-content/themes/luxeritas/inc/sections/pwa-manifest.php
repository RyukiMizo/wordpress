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
<p class="checkbox">
<input type="checkbox" value="" name="pwa_manifest"<?php thk_value_check( 'pwa_manifest', 'checkbox' ); ?> />
<?php echo __( 'Even if PWA is invalid, create and load manifest', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Start Page', 'luxeritas' ); ?></p>
<?php
echo wp_dropdown_pages( array( 
	'name' => 'pwa_start_url', 
	'echo' => false, 
	'show_option_none' => __( 'Top Page', 'luxeritas' ), 
	'option_none_value' => '0', 
	'selected' =>  isset( $luxe['pwa_start_url'] ) ? $luxe['pwa_start_url'] : '',
));
?>
</p>
<p class="f09em"><?php echo __( '* It is the first page displayed when the application is launched.', 'luxeritas'); ?></p>
</li>
<li>
<p class="control-title"><?php echo __( 'Application name', 'luxeritas' ); ?></p>
<input type="text" value="<?php thk_value_check( 'pwa_name', 'text' ); ?>" name="pwa_name" />
</li>
<li>
<p class="control-title"><?php echo __( 'Application short name', 'luxeritas' ); ?></p>
<input type="text" value="<?php thk_value_check( 'pwa_short_name', 'text' ); ?>" name="pwa_short_name" />
<p class="f09em"><?php echo __( '* <code class="normal-family">12 characters or less</code>. Used when there is insufficient space to display the full name of the application.', 'luxeritas'); ?></p>
</li>
<li>
<p class="control-title"><?php echo __( 'Description', 'luxeritas' ); ?></p>
<input type="text" value="<?php thk_value_check( 'pwa_description', 'text' ); ?>" name="pwa_description" />
</li>
<li>
<p class="control-title"><?php echo __( 'Application and Splash screen icon', 'luxeritas' ); ?></p>
<p><?php echo __( 'Please set from &quot;Site icon&quot; of appearance customization.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="control-title"><?php echo __( 'Display mode', 'luxeritas' ); ?></p>
<select name="pwa_display">
<option value="standalone"<?php thk_value_check( 'pwa_display', 'select', 'any' ); ?>>standalone ( <?php echo __( 'No UI', 'luxeritas' ); ?> )</option>
<option value="minimal-ui"<?php thk_value_check( 'pwa_display', 'select', 'minimal-ui' ); ?>>minimal-ui ( <?php echo __( 'Minimal UI', 'luxeritas' ); ?> )</option>
<option value="browser"<?php thk_value_check( 'pwa_display', 'select', 'browser' ); ?>>browser ( <?php echo __( 'Same UI as browser', 'luxeritas' ); ?> )</option>
</select>
</li>
<li>
<p class="control-title"><?php echo __( 'Orientation of screen', 'luxeritas' ); ?></p>
<select name="pwa_orientation">
<option value="any"<?php thk_value_check( 'pwa_orientation', 'select', 'any' ); ?>>any ( <?php echo __( 'Allow rotation', 'luxeritas' ); ?> )</option>
<option value="portrait"<?php thk_value_check( 'pwa_orientation', 'select', 'portrait' ); ?>>portrait ( <?php echo __( 'Fixed in portrait', 'luxeritas' ); ?> )</option>
<option value="landscape"<?php thk_value_check( 'pwa_orientation', 'select', 'landscape' ); ?>>landscape ( <?php echo __( 'Fixed in landscape', 'luxeritas' ); ?> )</option>
</select>
</li>
</ul>