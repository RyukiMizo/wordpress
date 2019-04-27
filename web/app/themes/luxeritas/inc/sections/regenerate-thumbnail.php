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
<input type="hidden" name="init_process" value="1" />
<?php
settings_fields( 'thumbnail' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* Regenerate all thumbnails being used.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Processing takes time. Please do not move to another page during processing.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Do not use this function consecutively because this function is burdens the server.', 'luxeritas' ); ?></p>
<div class="luxe-backup">
<div style="display:inline-block">
<?php submit_button( __( 'Regenerate started', 'luxeritas' ), 'secondary', 'regen_thumbs', true, array() ); ?>
</div>
<div id="regen_stop" style="display:none">
<?php submit_button( __( 'Stop', 'luxeritas' ), 'secondary', 'regen_stop', true, array() ); ?>
</div>
<p><input type="checkbox" name="thumb_delete" value=""<?php echo isset( $_POST['thumb_delete'] ) ? ' checked="checked"' : ''; ?> />
<?php echo __( 'Delete thumbnails that are not checked in &quot;Thumbnail Management&quot;', 'luxeritas' ); ?></p>
<?php
$get_posts = get_posts( array(
	'posts_per_page'	=> -1,	// 全件
	'post_type'		=> 'attachment',
	'orderby'		=> 'ID',
	'order'			=> 'DESC',
	'post_status'		=> null,
	'post_parent'		=> null
));
foreach( $get_posts as $val ) {
	if( stripos( $val->post_mime_type, 'image/' ) === 0 ) {
		$attachments[] = $val->ID;
	}
}
$post_count = count( $attachments );
unset( $get_posts, $attachments );
?>
<div id="progress-bar">
<span class="progress-count-text"><?php echo __( 'Count', 'luxeritas' ); ?> : <span id="post-items"><?php echo $post_count; ?></span></span>
<div id="progress"></div>
</div>
<div style="max-width:600px">
<pre id="log-view">
</pre>
</div>
</div>
</li>
</ul>
</form>
