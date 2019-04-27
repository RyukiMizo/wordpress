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

global $luxe, $awesome;
?>
<div id="nav">
<div id="gnavi">
<?php
// AMP 用グローバルナビ
if( isset( $luxe['amp'] ) ) {
?>
<label for="mnav" class="mobile-nav"><i class="fa fas fa-list"></i><?php echo __(' Menu', 'luxeritas'); ?></label>
<input type="checkbox" id="mnav" class="nav-on" />
<?php
}
// グローバルナビ本体
$trims = $luxe['html_compress'] === 'high' ? array( "\r", "\n", "\t" ) : array( "\t" );

echo str_replace( $trims, '',
	wp_nav_menu(
		array(
			'theme_location' => 'global-nav',
			'depth' => '3',
			'link_before' => '<span>',
			'link_after' => '</span>',
			'echo' => false,
			'items_wrap' => '<ul class="%2$s clearfix">%3$s</ul>',
		)
	)
);

if( isset( $luxe['amp'] ) ) {
?>
</div><!--/#gnavi-->
<div class="cboth"></div>
</div><!--/#nav-->
<?php
	return true;
}

if( $luxe['global_navi_mobile_type'] !== 'luxury' ) {
?>
<div class="mobile-nav"><i class="fa fas fa-list"></i><?php echo __(' Menu', 'luxeritas'); ?></div>
<?php
}
else {
	// 豪華版モバイルメニュー用、前の記事と次の記事

	if(
		( is_single() === true && isset( $luxe['next_prev_nav_visible'] ) ) ||
		( is_page() === true && isset( $luxe['next_prev_nav_page_visible'] ) )
	) {
		$prv = get_adjacent_post( false, '', true );
		$nxt = get_adjacent_post( false, '', false );

		if( !empty( $prv ) ) {
?>
<div id="data-prev" data-prev="<?php echo get_permalink( $prv->ID ); ?>"></div>
<?php
		}
		if( !empty( $nxt ) ) {
?>
<div id="data-next" data-next="<?php echo get_permalink( $nxt->ID ); ?>"></div>
<?php
		}
	}
?>
<ul class="mobile-nav">
<li class="mob-menu"><i class="fa fas fa-list"></i><p>Menu</p></li>
<?php
if( $luxe['column_style'] !== '1column' && !isset( $luxe['hide_mobile_sidebar'] ) ) {
	$fa_exchange = $awesome === 4 ? 'fa-exchange' : 'fa-exchange-alt';
?>
<li class="mob-side"><i class="fa fas <?php echo $fa_exchange; ?>"></i><p>Sidebar</p></li>
<?php
}
?>
<li class="mob-prev"><i class="fa fas fa-angle-double-left"></i><p>Prev</p></li>
<li class="mob-next"><i class="fa fas fa-angle-double-right"></i><p>Next</p></li>
<li class="mob-search"><i class="fa fas fa-search"></i><p>Search</p></li>
</ul>
<?php
}
?>
</div><!--/#gnavi-->
<div class="cboth"></div>
</div><!--/#nav-->
