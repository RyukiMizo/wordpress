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
<nav itemscope itemtype="https://schema.org/SiteNavigationElement"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="navigation"'; ?>>
<?php
// Global Navi Under
if( isset( $luxe['global_navi_visible'] ) ) {
	echo apply_filters( 'thk_head_nav', '' );
}
if( isset( $luxe['head_band_visible'] ) ) {
	if( isset( $luxe['amp'] ) ) {
		ob_start();
		get_template_part( 'head-band' );
		$band = ob_get_clean();
		echo thk_amp_not_allowed_tag_replace( $band );
	}
	else {
		get_template_part( 'head-band' );
	}
}
?>
</nav>
