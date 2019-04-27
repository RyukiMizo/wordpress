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
<p class="control-title"><?php echo __( 'CSS compression of child theme', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* If other than &quot;do not compress&quot; is selected, it will compress &amp; combine and create a file named style.min.css.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* If other than &quot;do not compress&quot; is selected, it will load the style.min.css.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* If you merged with Parent Theme, it will no longer load Parent Theme CSS.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* CSS of parent theme will always be compressed.', 'luxeritas' ); ?></p>
<select name="child_css_compress">
<option value="none"<?php thk_value_check( 'child_css_compress', 'select', 'none' ); ?>><?php echo __( 'Do not compress', 'luxeritas' ); ?></option>
<option value="comp"<?php thk_value_check( 'child_css_compress', 'select', 'comp' ); ?>><?php echo __( 'Compress only the child theme CSS', 'luxeritas' ); ?></option>
<option value="bind"<?php thk_value_check( 'child_css_compress', 'select', 'bind' ); ?>><?php echo __( 'Compression after combining CSS of parent and child', 'luxeritas' ); ?></option>
</select>
</li>
</ul>
