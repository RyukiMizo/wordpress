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
<form id="luxe-customize" method="post" action="">
<?php
settings_fields( 'backup_child' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* Will create backup file of child theme.', 'luxeritas' ); ?></p>
<p class="f09em"><?php printf( __( '* File will be saved in %s format.', 'luxeritas' ), 'ZIP' ); ?></p>
<p class="f09em"><?php echo __( '* If the filename contains multibyte characters, it may be skipped.', 'luxeritas' ); ?></p>
<div class="luxe-backup">
<?php
submit_button( __( 'Backup', 'luxeritas' ), 'secondary', 'backup_child', true, array() );
?>
</div>
</li>
</ul>
</form>
