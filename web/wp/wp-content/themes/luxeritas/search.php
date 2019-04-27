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

global $luxe, $s;
get_header();

if( function_exists( 'thk_search_result' ) === false ) {
	function thk_search_result() {
		global $s, $wp_query; ?>
<p id="list-title"><?php echo
	sprintf( __( 'Search results of [%s]', 'luxeritas' ), esc_html( $s ) ) .
	sprintf( __( ' : %s', 'luxeritas' ), $wp_query->found_posts );
?></p><?php
	}
}
?>
<input type="hidden" id="search-result" value="<?php echo esc_html( $s ); ?>" />
<?php
if( !empty( $s ) && have_posts() === true ) {
?>
<div id="section"<?php echo $luxe['content_discrete'] === 'indiscrete' ? ' class="grid"' : ''; ?>>
<?php
	get_template_part( 'loop' );
?>
</div><!--/#section-->
<?php
}
else {
?>
<article>
<div id="core" class="grid">
<?php
if( $luxe['breadcrumb_view'] === 'inner' ) get_template_part( 'breadcrumb' );
?>
<div itemprop="mainEntityOfPage" id="post">
<h2 id="list-title"><?php echo __( 'No search hits', 'luxeritas' ); ?></h2>
<p><?php echo __('Sorry, the requested post was not found.', 'luxeritas'); ?></p>
</div><!--/#post-->
</div><!--/#core-->
</article>
<?php
}
?>
</main>
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
