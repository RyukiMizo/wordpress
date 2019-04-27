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

$fab = 'fab ';
$fa_google_plus = 'fa-google-plus-g';

if( $awesome === 4 ) {
	$fab = 'fa ';
	$fa_google_plus = 'fa-google-plus';
}

// HEAD BAND MENU
$band_type = '';
if( !isset( $luxe['head_band_wide'] ) && $luxe['bootstrap_header'] === 'in' ) {
	$band_type = '-in';
}

?>
<div class="band">
<div id="head-band<?php echo $band_type; ?>">
<div class="band-menu">
<?php
// Search Box
if( isset( $luxe['head_band_search'] ) && !isset( $luxe['amp'] ) ) {
?>
<div id="head-search">
<form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" method="get" class="head-search-form" action="<?php echo THK_HOME_URL; ?>"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="search"'; ?>>
<meta itemprop="url" content="<?php echo THK_HOME_URL; ?>"/>
<meta itemprop="target" content="<?php echo THK_HOME_URL; ?>?s={s}"/>
<input itemprop="query-input" type="text" class="head-search-field" placeholder="Search &hellip;" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr( __( 'Search for', 'luxeritas' ) ); ?>" />
<button id="head-search-button" type="submit" aria-hidden="true" class="head-search-submit" value="<?php echo esc_attr( __( 'Search', 'luxeritas' ) ); ?>"></button>
</form>
</div>
<?php
}
// User Custom Menu
$wp_nav_menu = wp_nav_menu( array ( 'theme_location' => 'head-band', 'echo' => false, 'container' => false, 'fallback_cb' => false, 'items_wrap' => '<div><ul>%3$s' ) );
if( empty( $wp_nav_menu ) ) $wp_nav_menu = '<div><ul>';

if(
	isset( $luxe['head_band_twitter'] )	||
	isset( $luxe['head_band_facebook'] )	||
	isset( $luxe['head_band_instagram'] )	||
	isset( $luxe['head_band_pinit'] )	||
	isset( $luxe['head_band_hatena'] )	||
	isset( $luxe['head_band_google'] )	||
	isset( $luxe['head_band_youtube'] )	||
	isset( $luxe['head_band_line'] )	||
	isset( $luxe['head_band_rss'] )		||
	isset( $luxe['head_band_feedly'] )
) {
	$publisher = 'Person';
	if( $luxe['site_name_type'] === 'Organization' ) {
		$publisher = 'Organization';
	}

	$author = '';
	if( isset( $luxe['follow_twitter_id'] ) ) {
		$author = $luxe['follow_twitter_id'];
	}
	elseif( $luxe['site_name_type'] === 'Organization' ) {
		$author = THK_SITENAME;
	}
	else {
		$auth = get_users();
		$author = get_the_author_meta( 'user_nicename', $auth[0]->ID );
	}

	$wp_nav_menu = str_replace( '<div><ul', '<div itemscope itemtype="http://schema.org/'. $publisher . '"><link itemprop="url" href="' . THK_HOME_URL . '"><meta itemprop="name" content="' . $author . '"/><ul', $wp_nav_menu );
	echo $wp_nav_menu;
}
else {
	echo $wp_nav_menu;
}
?>
<?php
// SNS Follow Button
	if( isset( $luxe['head_band_twitter'] ) ) {
		$follow_twitter_id = isset( $luxe['follow_twitter_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_twitter_id'] ) ) : '';
?><li><span class="snsf twitter"><a href="//twitter.com/<?php echo $follow_twitter_id; ?>" target="_blank" title="Twitter" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="<?php echo $fab; ?>fa-twitter"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Twitter</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_facebook'] ) ) {
		$follow_facebook_id = isset( $luxe['follow_facebook_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_facebook_id'] ) ) : '';
?><li><span class="snsf facebook"><a href="//www.facebook.com/<?php echo $follow_facebook_id; ?>" target="_blank" title="Facebook" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="<?php echo $fab; ?>fa-facebook-f"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Facebook</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_instagram'] ) ) {
		$follow_instagram_id = isset( $luxe['follow_instagram_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_instagram_id'] ) ) : '';
?><li><span class="snsf instagram"><a href="//www.instagram.com/<?php echo $follow_instagram_id; ?>?ref=badge" target="_blank" title="Instagram" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="<?php echo $fab; ?>fa-instagram"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Instagram</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_pinit'] ) ) {
		$follow_pinit_id = isset( $luxe['follow_pinit_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_pinit_id'] ) ) : '';
?><li><span class="snsf pinit"><a href="//www.pinterest.com/<?php echo $follow_pinit_id; ?>" target="_blank" title="Pinterest" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="<?php echo $fab; ?>fa-pinterest-p"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Pinterest</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_hatena'] ) ) {
		$follow_hatena_id = isset( $luxe['follow_hatena_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_hatena_id'] ) ) : '';
?><li><span class="snsf hatena"><a href="//b.hatena.ne.jp/<?php echo $follow_hatena_id; ?>" target="_blank" title="<?php echo __( 'Hatena Bookmark', 'luxeritas' ); ?>" rel="nofollow noopener" itemprop="sameAs">&nbsp;B!&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Hatena</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_google'] ) ) {
		$follow_google_id = isset( $luxe['follow_google_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_google_id'] ) ) : '';
?><li><span class="snsf google"><a href="//plus.google.com/<?php echo $follow_google_id; ?>" target="_blank" title="Google+" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="<?php echo $fab, $fa_google_plus; ?>"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Google+</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_youtube'] ) ) {
		$follow_youtube_id = '';
		$youtube_type = 'channel/';
		if( isset( $luxe['follow_youtube_channel_id'] ) ) {
			$follow_youtube_id = rawurlencode( rawurldecode( $luxe['follow_youtube_channel_id'] ) );
		}
		elseif( isset( $luxe['follow_youtube_id'] ) ) {
			$follow_youtube_id = rawurlencode( rawurldecode( $luxe['follow_youtube_id'] ) );
			$youtube_type = 'user/';
		}
?><li><span class="snsf youtube"><a href="//www.youtube.com/<?php echo $youtube_type, $follow_youtube_id; ?>" target="_blank" title="YouTube" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="<?php echo $fab; ?>fa-youtube"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">YouTube</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_line'] ) ) {
		$follow_line_id = isset( $luxe['follow_line_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_line_id'] ) ) : '';
?><li><span class="snsf line"><a href="//line.naver.jp/ti/p/<?php echo $follow_line_id; ?>" target="_blank" title="LINE" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="fa ico-line"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">LINE</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_rss'] ) ) {
?><li><span class="snsf rss"><a href="<?php echo get_bloginfo('rss2_url'); ?>" target="_blank" title="RSS" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="fa fas fa-rss"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">RSS</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_feedly'] ) ) {
?><li><span class="snsf feedly"><a href="//feedly.com/index.html#subscription/feed/<?php echo rawurlencode( get_bloginfo('rss2_url') ); ?>" target="_blank" title="Feedly" rel="nofollow noopener" itemprop="sameAs">&nbsp;<i class="ico-feedly"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Feedly</span>&nbsp;'; ?></a></span></li>
<?php
	}
?></ul></div>
</div>
</div><!--/#head-band-->
</div><!--/.band-->
