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
<p class="control-title"><?php echo __( 'Compression ratio of HTML', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* &quot;Compression rate high&quot;, is the compression level which is still readable, and will not compress to the limit.', 'luxeritas' ); ?></p>
<select name="html_compress">
<option value="none"<?php thk_value_check( 'html_compress', 'select', 'none' ); ?>><?php echo __( 'Do not compress', 'luxeritas' ); ?></option>
<option value="low"<?php thk_value_check( 'html_compress', 'select', 'low' ); ?>><?php echo __( 'Compression rate low', 'luxeritas' ); ?></option>
<option value="high"<?php thk_value_check( 'html_compress', 'select', 'high' ); ?>><?php echo __( 'Compression rate high', 'luxeritas' ); ?></option>
</select>
</li>
</ul>
