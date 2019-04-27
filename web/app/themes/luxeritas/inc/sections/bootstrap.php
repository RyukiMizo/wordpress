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
<p class="control-title"><?php echo __( 'How to load bootstrap.js', 'luxeritas' ); ?></p>
<select name="bootstrap_js_load_type">
<option value="asyncdefer"<?php thk_value_check( 'bootstrap_js_load_type', 'select', 'asyncdefer' ); ?>><?php echo __( 'Asynchronous', 'luxeritas' ), ' (async defer)'; ?></option>
<option value="async"<?php thk_value_check( 'bootstrap_js_load_type', 'select', 'async' ); ?>><?php echo __( 'Asynchronous', 'luxeritas' ), ' (async)'; ?></option>
<option value="defer"<?php thk_value_check( 'bootstrap_js_load_type', 'select', 'defer' ); ?>><?php echo __( 'Asynchronous', 'luxeritas' ), ' (defer)'; ?></option>
<option value="sync"<?php thk_value_check( 'bootstrap_js_load_type', 'select', 'sync' ); ?>><?php echo __( 'Synchronism', 'luxeritas' ); ?></option>
<option value="none"<?php thk_value_check( 'bootstrap_js_load_type', 'select', 'none' ); ?>><?php echo __( 'Not required (no load)', 'luxeritas' ); ?></option>
</select>
<p class="f09em"><?php echo __( '* It is necessary only when using Bootstrap components, plugins, etc.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Even if Bootstrap mode is selected, bootstrap.js is not always necessary.', 'luxeritas' ); ?></p>
</li>
</ul>
