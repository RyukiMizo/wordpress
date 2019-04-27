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
settings_fields( 'backup_appearance' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* Will only back up customized data for the appearance design. (Image, various ID etc excluded)', 'luxeritas' ); ?></p>
<p class="f09em"><?php printf( __( '* File will be saved in %s format.', 'luxeritas' ), 'JSON' ); ?></p>
<div class="luxe-backup">
<?php
submit_button( __( 'Appearance Backup', 'luxeritas' ), 'secondary', 'backup_appearance', true, array() );
?>
</div>
</li>
</ul>
</form>

<form enctype="multipart/form-data" id="luxe-customize" method="post" action="">
<?php
settings_fields( 'restore_appearance' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* Will restore Luxeritas appearance customized setting from JSON backed up file.', 'luxeritas' ); ?></p>
<label class="button secondary"><?php echo __( 'Appearance Restore', 'luxeritas' ); ?>
<input type="file" id="luxe-restore-appearance" name="luxe-restore-appearance" style="display:none" />
</label>
<div style="display:none">
<?php
submit_button( __( 'Appearance Restore', 'luxeritas' ), 'secondary', 'restore', true, array() );
?>
</div>
</li>
</ul>
</form>
<script>
jQuery(function($) {
	$("#luxe-restore-appearance").change(function () {
		$(this).closest("form").submit();
	});
});
</script>
