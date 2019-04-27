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
<p class="control-title"><?php printf( __( 'Others', 'luxeritas' ), 'Meta keywords ' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="child_script"<?php thk_value_check( 'child_script', 'checkbox' ); ?> />
<?php echo __( 'Do not load javascript of child theme ( luxech.js )', 'luxeritas' ); ?>
</p>
<p class="f09em m25-b"><?php echo __( '* If you are not going to customly add anything on the luxech.js, enabling this will streamline the page resource.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="html5shiv_load_type"<?php thk_value_check( 'html5shiv_load_type', 'checkbox' ); ?> />
<?php echo __( 'Adapt to HTML5 for IE8 or lower', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="respondjs_load_type"<?php thk_value_check( 'respondjs_load_type', 'checkbox' ); ?> />
<?php echo __( 'Adapt to responsive for IE8 or lower', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="thk_emoji_disable"<?php thk_value_check( 'thk_emoji_disable', 'checkbox' ); ?> />
<?php echo __( 'Do not load the emoji script for WordPress', 'luxeritas' ); ?>
</p>
<p class="f09em"><?php echo __( '* If you do not use emoji, not loading it will make things faster !', 'luxeritas' ); ?></p>
</li>
<li>
<p class="checkbox">
<input type="checkbox" value="1" name="thk_embed_disable"<?php thk_value_check( 'thk_embed_disable', 'checkbox' ); ?> />
<?php echo __( 'Turn OFF the WordPress Embed function', 'luxeritas' ); ?>
</p>
<p class="f09em"><?php echo __( '* If you do not use emded functions, this will also make things faster !', 'luxeritas' ); ?></p>
</li>
</ul>
