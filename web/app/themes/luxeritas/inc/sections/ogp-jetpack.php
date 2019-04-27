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
<span id="disable_jetpack_ogp"></span>
<ul>
<li>
<p class="checkbox" id="disable_jetpack_ogp_style">
<input type="checkbox" value="" name="disable_jetpack_ogp"<?php thk_value_check( 'disable_jetpack_ogp', 'checkbox' ); ?> />
<?php echo __( 'Disable Jetpack&apos;s OGP', 'luxeritas' ); ?>
</p>
<script>
(function() {
	var hash = location.hash
	,   clikMsg = document.getElementById("disable_jetpack_ogp_msg")
	,   ogpMsg  = function() {
		$("#disable_jetpack_ogp_style").css({'display':'inline-block', 'margin-left':'-9px', 'border':'2px solid red', 'padding':'5px 7px'});
	};
	if( hash === "#disable_jetpack_ogp" ) {
		ogpMsg();
	} if( clikMsg ) {
		clikMsg.onclick = function() {
			ogpMsg();
		};
	}
}());
</script>
</li>
</ul>
