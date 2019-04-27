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
<p class="control-title"><?php echo __( 'Javascript compression of child theme', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* It will compress the file luxech.js in the child theme folder and create a new file of luxech.min.js.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* If you select the &quot;compress&quot;, it will automatically load the luxech.min.js.', 'luxeritas' ); ?></p>
<select name="child_js_compress">
<option value="none"<?php thk_value_check( 'child_js_compress', 'select', 'none' ); ?>><?php echo __( 'Do not compress', 'luxeritas' ); ?></option>
<option value="comp"<?php thk_value_check( 'child_js_compress', 'select', 'comp' ); ?>><?php echo __( 'Compress (you can also compress with combined additional files)', 'luxeritas' ); ?></option>
<option value="noload"<?php thk_value_check( 'child_js_compress', 'select', 'noload' ); ?>><?php echo __( 'Not required (no load)', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p class="control-title"><?php echo __( 'Additional Javascript file names to combine &amp; compress', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* In addition to luxech.js, it can be combine and compress any three files directly under the child theme folder.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* The extension must be &quot;.js&quot;  (Please do not input the extension in the below boxes).', 'luxeritas' ); ?></p>
<input type="text" value="<?php thk_value_check( 'child_js_file_1', 'text' ); ?>" name="child_js_file_1" />
</li>
<li>
<input type="text" value="<?php thk_value_check( 'child_js_file_2', 'text' ); ?>" name="child_js_file_2" />
</li>
<li>
<input type="text" value="<?php thk_value_check( 'child_js_file_3', 'text' ); ?>" name="child_js_file_3" />
</li>
</ul>
