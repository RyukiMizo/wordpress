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
<input type="checkbox" value="" name="blogcard_cache_cleanup" />
<?php echo __( 'Clear all Blog Card cache', 'luxeritas' ); ?>
<p class="f09em"><?php echo __( '* This will delete the whole cache directory including cache expiration time infomation.', 'luxeritas' ); ?></p>
</li>
<li>
<input type="checkbox" value="" name="blogcard_cache_expire_cleanup" />
<?php echo __( 'Clear only the cache expiration time information of Blog Card', 'luxeritas' ); ?>
<p class="f09em"><?php echo __( '* This will delete only the cache expiration time information.', 'luxeritas' ); ?></p>
</li>
</ul>
