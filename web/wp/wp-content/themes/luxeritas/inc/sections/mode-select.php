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
<p class="f09em"><?php echo __( '* Both has the same design layout but Luxeritas mode is faster and lighter.  Bootstrap mode should be chosen if you want to use the functions or classes of Bootstrap.', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="luxeritas" name="luxe_mode_select"<?php thk_value_check( 'luxe_mode_select', 'radio', 'luxeritas' ); ?> />
Luxeritas Mode
</p>
<p class="radio">
<input type="radio" value="bootstrap" name="luxe_mode_select"<?php thk_value_check( 'luxe_mode_select', 'radio', 'bootstrap' ); ?> />
Bootstrap 3 Mode
</p>
<p class="radio">
<input type="radio" value="bootstrap4" name="luxe_mode_select"<?php thk_value_check( 'luxe_mode_select', 'radio', 'bootstrap4' ); ?> />
Bootstrap 4 Mode
</p>
</li>
</ul>
