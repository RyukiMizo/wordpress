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
settings_fields( 'backup' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* Will create the back up for all the Luxeritas customized data.', 'luxeritas' ); ?></p>
<p class="f09em"><?php printf( __( '* File will be saved in %s format.', 'luxeritas' ), 'JSON' ); ?></p>
<div class="luxe-backup">
<?php
submit_button( __( 'All Backup', 'luxeritas' ), 'secondary', 'backup', true, array() );
?>
</div>
</li>
</ul>
</form>

<form enctype="multipart/form-data" id="luxe-customize" method="post" action="">
<?php
settings_fields( 'restore' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* Will restore Luxeritas customized setting from JSON backed up file.', 'luxeritas' ); ?></p>
<label class="button secondary"><?php echo __( 'All Restore', 'luxeritas' ); ?>
<input type="file" id="luxe-restore" name="luxe-restore" style="display:none" />
</label>
</li>
</ul>
</form>
<script>
jQuery(function($) {
	$("#luxe-restore").change(function () {
		$(this).closest("form").submit();
	});
});
</script>
