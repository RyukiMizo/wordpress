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
get_header();

if( isset( $luxe['not404'] ) && is_numeric( $luxe['not404'] ) ) {
?>
<article>
<div id="core" class="grid">
<?php
	if( $luxe['breadcrumb_view'] === 'inner' ) get_template_part( 'breadcrumb' );
?>
<div itemprop="mainEntityOfPage" id="post" class="post not404">
<?php
	if( function_exists('dynamic_sidebar') === true ) {
		if( is_active_sidebar('post-title-upper') === true ) {
			dynamic_sidebar( 'post-title-upper' );
		}
	}
	$arr = array( 'page_id' => $luxe['not404'] );
	$st_query = new WP_Query( $arr );

	if( $st_query->have_posts() === true ) {
		while( $st_query->have_posts() === true ) {
			$st_query->the_post();

			echo apply_filters( 'thk_h_tag', 1, '', '', '', 'entry-title title404' ); // <h1> タイトル

			if( function_exists('dynamic_sidebar') === true ) {
				if( is_active_sidebar('post-title-under') === true ) {
					dynamic_sidebar( 'post-title-under' );
				}
			}
			echo apply_filters( 'thk_content', '' );
			break;
		}
	}
	wp_reset_postdata();

	if( function_exists('dynamic_sidebar') === true ) {
		if( is_active_sidebar('post-under-1') === true ) {
			dynamic_sidebar( 'post-under-1' );
		}
	}
}
else {
?>
<article>
<div id="core" class="grid">
<?php
if( $luxe['breadcrumb_view'] === 'inner' ) get_template_part( 'breadcrumb' );
?>
<div itemprop="mainEntityOfPage" id="post">
<?php
echo apply_filters( 'thk_h_tag', 1, '404 Not Found', '', '', 'entry-title title404' ); // <h1> タイトル
?>
<p><?php echo __('Sorry, but you are looking for something that isn&#8217;t here.', 'luxeritas'); ?></p>
<?php
}
?>
</div><!--/post-->
</div><!--/#core-->
</article>
</main>
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
