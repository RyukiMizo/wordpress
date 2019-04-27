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

global $luxe;
?>
<form enctype="multipart/form-data" id="luxe-customize" method="post" action="">
<?php
settings_fields( 'design_create' );
?>
<ul>
<li>
<p><?php echo __( 'Create a design file based on the following contents.', 'luxeritas' ); ?></p>
<ul style="list-style:none;margin:15px 0 30px 15px">
<li style="margin-bottom:10px"><input type="checkbox" name="design_custom" value="" />&nbsp;<?php echo __( 'Customize (Appearance) settings (Image, various ID etc excluded)', 'luxeritas' ); ?></li>
<li style="margin-bottom:10px"><input type="checkbox" name="design_active" value="" <?php echo isset( $luxe['design_file'] ) ? '' : 'disabled';?> />&nbsp;<?php echo __( 'Stylesheet of currently selected design file', 'luxeritas' ); ?></li>
<li style="margin-bottom:10px"><input type="checkbox" name="design_child" value="" />&nbsp;<?php echo __( 'Child theme&apos;s stylesheet', 'luxeritas' ); ?></li>
</ul>
<p><?php echo __( '* Images set in &quot;Customize (Appearance)&quot; are copied to the images directory, but they are not applicable in the style sheet. If necessary, please append later.', 'luxeritas' ); ?></p>
<p><?php echo __( '* In order to use this feature, the server must be compatible with ZipArchive.', 'luxeritas' ); ?></p>
<p class="control-title"><?php echo __( 'Design file name', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* 20 characters or less. The characters that can be used are alphanumeric and - (hyphen) and _ (underscore).', 'luxeritas' ); ?></p>
<input type="text" value="<?php echo isset( $_POST['design_name'] ) ? $_POST['design_name'] : ''; ?>" name="design_name" maxlength="20" style="width:180px" /> .zip
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), __( 'Screenshot', 'luxeritas' ) ); echo ' ( option )'; ?></p>
<p class="f09em"><?php echo __( '* Aspect ratio 4: 3 recommended ( e.g. 600 x 450 px, 720 x 540 px, 800 x 600 px, 1200 x 900 px )', 'luxeritas' ); ?></p>
<script>thkImageSelector('og-img', 'Screenshot');</script>
<div id="og-img-form">
<input id="og-img" type="hidden" name="screenshot" value="" />
<input id="og-img-set" type="button" class="button" value="<?php echo __( 'Set image', 'luxeritas' ); ?>" />
<input id="og-img-del" type="button" class="button" value="<?php echo __( 'Delete image', 'luxeritas' ); ?>" />
<div id="og-img-view"></div>
<li>
<?php
submit_button( __( 'Create Zip file', 'luxeritas' ), 'primary', 'design-create', true, array() );
?>
</li>
</ul>
</form>
