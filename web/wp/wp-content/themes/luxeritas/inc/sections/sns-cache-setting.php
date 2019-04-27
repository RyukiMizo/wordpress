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
<input type="checkbox" value="" name="sns_count_cache_enable"<?php thk_value_check( 'sns_count_cache_enable', 'checkbox', false ); ?> />
<?php echo __( 'Eanable cache for SNS counter', 'luxeritas' ), ' (' . __( 'Recommend', 'luxeritas' ), ')'; ?>
<p class="f09em"><?php echo __( '* will not function if normal SNS button is selected.', 'luxeritas' ); ?></p>
<p class="f09em m25-b"><?php echo __( '* by enabling cache, the SNS counter will work even on WAF enabled servers.', 'luxeritas' ); ?></p>
</li>
<li>
<input type="checkbox" value="" name="sns_count_cache_force"<?php thk_value_check( 'sns_count_cache_force', 'checkbox', false ); ?> />
<?php echo __( 'Count and cache the SNS counts even NO display is selected.', 'luxeritas' ); ?>
</li>
<li>
<p class="control-title"><?php echo __( 'Interval for cache restructure', 'luxeritas' ); ?></p>
<select name="sns_count_cache_expire">
<option value="60"<?php thk_value_check( 'sns_count_cache_expire', 'select', 60 ); ?>><?php printf( __( '%s seconds', 'luxeritas' ), 60 ); ?></option>
<option value="600"<?php thk_value_check( 'sns_count_cache_expire', 'select', 600 ); ?>><?php printf( __( '%s minutes', 'luxeritas' ), 10 ); ?></option>
<option value="1800"<?php thk_value_check( 'sns_count_cache_expire', 'select', 1800 ); ?>><?php printf( __( '%s minutes', 'luxeritas' ), 30 ); ?></option>
<option value="3600"<?php thk_value_check( 'sns_count_cache_expire', 'select', 3600 ); ?>><?php printf( __( '%s hour', 'luxeritas' ), 1 ); ?></option>
<option value="10800"<?php thk_value_check( 'sns_count_cache_expire', 'select', 10800 ); ?>><?php printf( __( '%s hours', 'luxeritas' ), 3 ); ?></option>
<option value="21600"<?php thk_value_check( 'sns_count_cache_expire', 'select', 21600 ); ?>><?php printf( __( '%s hours', 'luxeritas' ), 6 ); ?></option>
<option value="43200"<?php thk_value_check( 'sns_count_cache_expire', 'select', 43200 ); ?>><?php printf( __( '%s hours', 'luxeritas' ), 12 ); ?></option>
<option value="86400"<?php thk_value_check( 'sns_count_cache_expire', 'select', 86400 ); ?>><?php printf( __( '%s day', 'luxeritas' ), 1 ); ?></option>
</select>
</li>
<li>
<p class="control-title"><?php echo __( 'Weekly cache cleaning', 'luxeritas' ); ?></p>
<select name="sns_count_weekly_cleanup">
<option value="dust"<?php thk_value_check( 'sns_count_weekly_cleanup', 'select', 'dust' ); ?>><?php echo __( 'Delete trash considered cache', 'luxeritas' ); ?></option>
<option value="all"<?php thk_value_check( 'sns_count_weekly_cleanup', 'select', 'all' ); ?>><?php echo __( 'Delete all cache', 'luxeritas' ); ?></option>
<option value="none"<?php thk_value_check( 'sns_count_weekly_cleanup', 'select', 'none' ); ?>><?php echo __( 'Do nothing', 'luxeritas' ); ?></option>
</select>
</li>
</ul>
