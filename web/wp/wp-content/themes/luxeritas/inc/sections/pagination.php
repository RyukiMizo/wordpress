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

$posts_per_page = get_option( 'posts_per_page' );

?>
<p><?php echo __( '* ', 'luxeritas' ), __( 'default value', 'luxeritas' ), ' : <a href="' . admin_url( "options-reading.php" ) . '" style="margin-left:8px">', __( 'Settings', 'luxeritas' ); ?> -&gt; <?php echo __( 'Reading Settings', 'luxeritas' ); ?></a> -&gt; <?php echo __( 'Blog pages show at most', 'luxeritas' ); ?></p>
<ul>
<li>
<p class="control-title"><?php echo __( 'Top page of list type', 'luxeritas' ); ?></p>
<p class="radio">
<?php
$value_check = thk_value_check( 'items_home', 'radio', 0, false );
$items_num   = empty( $value_check ) ? thk_value_check( 'items_home_num', 'number', $posts_per_page, false ) : $posts_per_page;
?>
<input type="radio" value="0" name="items_home"<?php echo $value_check; ?> />
<?php echo __( 'default value', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="1" name="items_home"<?php thk_value_check( 'items_home', 'radio', 1 ); ?> />
<input type="number" min="1" value="<?php echo $items_num; ?>" name="items_home_num" />
<?php echo __( 'posts', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Category', 'luxeritas' ); ?></p>
<p class="radio">
<?php
$value_check = thk_value_check( 'items_category', 'radio', 0, false );
$items_num   = empty( $value_check ) ? thk_value_check( 'items_category_num', 'number', $posts_per_page, false ) : $posts_per_page;
?>
<input type="radio" value="0" name="items_category"<?php echo $value_check; ?> />
<?php echo __( 'default value', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="1" name="items_category"<?php thk_value_check( 'items_category', 'radio', 1 ); ?> />
<input type="number" min="1" value="<?php echo $items_num; ?>" name="items_category_num" />
<?php echo __( 'posts', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Archive', 'luxeritas' ); ?></p>
<p class="radio">
<?php
$value_check = thk_value_check( 'items_archive', 'radio', 0, false );
$items_num   = empty( $value_check ) ? thk_value_check( 'items_archive_num', 'number', $posts_per_page, false ) : $posts_per_page;
?>
<input type="radio" value="0" name="items_archive"<?php echo $value_check; ?> />
<?php echo __( 'default value', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="1" name="items_archive"<?php thk_value_check( 'items_archive', 'radio', 1 ); ?> />
<input type="number" min="1" value="<?php echo $items_num; ?>" name="items_archive_num" />
<?php echo __( 'posts', 'luxeritas' ); ?>
</p>
</li>

<li>
<p class="control-title"><?php echo __( 'Search result page', 'luxeritas' ); ?></p>
<p class="radio">
<?php
$value_check = thk_value_check( 'items_search', 'radio', 0, false );
$items_num   = empty( $value_check ) ? thk_value_check( 'items_search_num', 'number', $posts_per_page, false ) : $posts_per_page;
?>
<input type="radio" value="0" name="items_search"<?php echo $value_check; ?> />
<?php echo __( 'default value', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="1" name="items_search"<?php thk_value_check( 'items_search', 'radio', 1 ); ?> />
<input type="number" min="1" value="<?php echo $items_num; ?>" name="items_search_num" />
<?php echo __( 'posts', 'luxeritas' ); ?>
</p>
</li>
</ul>
