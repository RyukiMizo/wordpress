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
<p class="control-title"><?php echo __( 'How to load CSS ( Font Awesome )', 'luxeritas' ); ?></p>
<select name="awesome_load_css">
<option value="sync"<?php thk_value_check( 'awesome_load_css', 'select', 'sync' ); ?>><?php echo __( 'Synchronism', 'luxeritas' ), ' (', __( 'No delays in icon font', 'luxeritas' ), ')'; ?></option>
<option value="async"<?php thk_value_check( 'awesome_load_css', 'select', 'async' ); ?>><?php echo __( 'Asynchronous', 'luxeritas' ), ' (', __( 'High rendering speed', 'luxeritas' ), ')'; ?></option>
<option value="none"<?php thk_value_check( 'awesome_load_css', 'select', 'none' ); ?>><?php echo __( 'Not required (no load)', 'luxeritas' ); ?></option>
</select>
<p class="f09em m25-b"><?php echo __( '* Usually, icon font is required.', 'luxeritas' ), __( 'Please select the &quot;synchronous&quot; or &quot;asynchronous&quot;.', 'luxeritas' ); ?></p>
</li>

<li>
<p class="control-title">Font Awesome <?php echo __( 'Version', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="5" name="awesome_version"<?php thk_value_check( 'awesome_version', 'radio', 5 ); ?> />
Font Awesome 5
</p>
<p class="radio">
<input type="radio" value="4" name="awesome_version"<?php thk_value_check( 'awesome_version', 'radio', 4 ); ?> />
Font Awesome 4
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Size of CSS', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="minimum" name="awesome_css_type"<?php thk_value_check( 'awesome_css_type', 'radio', 'minimum' ); ?> />
<?php echo __( 'Minimum CSS required by Luxeritas', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="full" name="awesome_css_type"<?php thk_value_check( 'awesome_css_type', 'radio', 'full' ); ?> />
<?php echo __( 'Font Awesome Original CSS', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'How to load font file', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="cdn" name="awesome_load_file"<?php thk_value_check( 'awesome_load_file', 'radio', 'cdn' ); ?> />
CDN
</p>
<p class="radio">
<input type="radio" value="local" name="awesome_load_file"<?php thk_value_check( 'awesome_load_file', 'radio', 'local' ); ?> />
<?php echo __( 'Local', 'luxeritas' ); ?>
</p>
</li>
</ul>
