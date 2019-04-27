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
settings_fields( 'sns_get' );
?>
<ul>
<li>
<p class="f09em"><?php echo __( '* It will retrieve the SNS count number of all posts and restructure the cache.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Normally you do not need to use this function.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Do not use this function consecutively because this function is burdens the server.', 'luxeritas' ); ?></p>
<div class="luxe-backup">
<div>
<div style="display:inline-block">
<?php submit_button( __( 'Restructure started', 'luxeritas' ), 'secondary', 'sns_get', true, array() ); ?>
</div>
<div id="sns_get_stop" style="display:none">
<?php submit_button( __( 'Stop', 'luxeritas' ), 'secondary', 'sns_get_stop', true, array() ); ?>
</div>
</div>
<?php
$count_posts = wp_count_posts( 'post' );
$post_count  = $count_posts->publish;
$count_posts = wp_count_posts( 'page' );
$post_count += $count_posts->publish;
$post_count += 1 // トップページの分 + 1;
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
