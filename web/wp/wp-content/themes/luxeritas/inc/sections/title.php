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
<p class="control-title"><?php echo __( 'Separator of title', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="pipe" name="title_sep"<?php thk_value_check( 'title_sep', 'radio', 'pipe' ); ?> />
<?php echo '|&nbsp;&nbsp;&nbsp;( ' . __( 'The pipe symbol', 'luxeritas' ) . ' )'; ?>
</p>
<p class="radio">
<input type="radio" value="hyphen" name="title_sep"<?php thk_value_check( 'title_sep', 'radio', 'hyphen' ); ?> />
<?php echo '&#045;&nbsp;&nbsp;&nbsp;( ' . __( 'The hyphen symbol', 'luxeritas' ) . ' )'; ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Page title when Front Page is post pages', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="site" name="title_top_list"<?php thk_value_check( 'title_top_list', 'radio', 'site' ); ?> />
<?php echo __( 'Site name', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="site_catch" name="title_top_list"<?php thk_value_check( 'title_top_list', 'radio', 'site_catch' ); ?> />
<?php echo __( 'Site name', 'luxeritas' ) . ' | ' . __( 'Tagline', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Page title when Front Page is static pages', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="site" name="title_front_page"<?php thk_value_check( 'title_front_page', 'radio', 'site' ); ?> />
<?php echo __( 'Site name', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="site_catch" name="title_front_page"<?php thk_value_check( 'title_front_page', 'radio', 'site_catch' ); ?> />
<?php echo __( 'Site name', 'luxeritas' ) . ' | ' . __( 'Tagline', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="site_title" name="title_front_page"<?php thk_value_check( 'title_front_page', 'radio', 'site_title' ); ?> />
<?php echo __( 'Site name', 'luxeritas' ) . ' | ' . __( 'Page title', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="title_site" name="title_front_page"<?php thk_value_check( 'title_front_page', 'radio', 'title_site' ); ?> />
<?php echo __( 'Page title', 'luxeritas' ) . ' | ' . __( 'Site name', 'luxeritas' ); ?>
</p>
</li>
<li>
<p class="control-title"><?php echo __( 'Other page title', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="title" name="title_other"<?php thk_value_check( 'title_other', 'radio', 'title' ); ?> />
<?php echo __( 'Page title', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="site_title" name="title_other"<?php thk_value_check( 'title_other', 'radio', 'site_title' ); ?> />
<?php echo __( 'Site name', 'luxeritas' ) . ' | ' . __( 'Page title', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="title_site" name="title_other"<?php thk_value_check( 'title_other', 'radio', 'title_site' ); ?> />
<?php echo __( 'Page title', 'luxeritas' ) . ' | ' . __( 'Site name', 'luxeritas' ); ?>
</p>
</li>
</ul>