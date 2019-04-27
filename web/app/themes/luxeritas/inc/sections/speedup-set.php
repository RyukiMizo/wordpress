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

$admin_url = admin_url();
?>
<ul>
<li>
<p><?php echo __( '* Using cache plugin with Luxeritas may be rather slow.', 'luxeritas' ); ?></p>
<button type="button" id="speed-recommend" class="button" disabled><?php echo __( 'Recommended settings', 'luxeritas' ); ?></button>
<button type="button" id="speed-extreme" class="button" disabled><?php echo __( 'Extreme settings', 'luxeritas' ); ?><span style="color:red"> ( <?php echo __( 'Caution', 'luxeritas' ); ?> )</span></button>
<button type="button" id="speed-default" class="button" disabled><?php echo __( 'Initial settings', 'luxeritas' ); ?></button>
<p id="speed-msg" style="display:none"><?php echo __( 'You selected the item.', 'luxeritas' ); ?><span style="color:#fff;border-radius:6px;padding:4px 10px 5px 10px"><?php echo __( 'Please press save button', 'luxeritas' ); ?></span></p>
</li>
</ul>
