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

/**
 * Template Name: Sitemap
 */

global $luxe, $awesome, $wpdb;

$fa_pencil = $awesome === 4 ? 'fa-pencil' : 'fa-pencil-alt' ;

get_header();
?>
<div id="core" class="grid">
<?php
if( $luxe['breadcrumb_view'] === 'inner' )get_template_part('breadcrumb');
?>
<section>
<?php
echo apply_filters( 'thk_h_tag', 1, __( 'Sitemap', 'luxeritas' ), '', '', 'entry-title' ); // <h1> タイトル
get_template_part('meta');
?>
</section>
<div id="sitemap" class="post">
<section>
<h2 class="entry-title"><?php echo __( 'Pages', 'luxeritas' ); ?></h2>
<div class="sitemap-home"><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a></div>
<ul>
<?php
wp_list_pages( 'title_li=' );
?>
</ul>
</section>
<section>
<h2 class="entry-title"><?php echo __( 'Category', 'luxeritas' ); ?></h2>
<ul>
<?php
echo thk_list_categories();
?>
</ul>
<div class="clearfix"></div>
<div class="meta-box">
<?php
if( isset( $luxe['author_visible'] ) ) {
	if( $luxe['author_page_type'] === 'auth' ) {
?>
<p class="vcard author"><i class="fa fas <?php echo $fa_pencil; ?>"></i>Posted by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></p>
<?php
	}
else {
?>
<p class="vcard author"><i class="fa fas <?php echo $fa_pencil; ?>"></i>Posted by <a href="<?php echo isset( $luxe['thk_author_url'] ) ? $luxe['thk_author_url'] : THK_HOME_URL; ?>"><?php the_author(); ?></a></p>
<?php
	}
}
?>
</div>
</section>
</div><!--/#sitemap-->
</div><!--/#core-->
</main>
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>

<?php
function thk_list_categories()
{	$html = '';
	$categories = get_categories();

	foreach( $categories as $category ) {
		if( empty( $category->category_parent ) ) {
			$html .= '<li class="category_item category-' . $category->cat_ID . ' post_item_has_children">';
			$html .= '<a href="' . get_category_link( $category->cat_ID ) . '">' . $category->name . '</a>';
			$html .= thk_list_postlist_categories( $category->cat_ID );
			$html .= thk_list_parent_categories( $category->cat_ID );
			$html .= '</li>'."\n";
		}
	}
	return $html;
}

function thk_list_parent_categories( $parent_id = 0 ) {
	$html = '';
	$categories = get_categories( 'child_of=' . $parent_id );

	foreach( $categories as $category ) {
		if( $category->category_parent === $parent_id ) {
			$html .= '<li class="category_item category-' . $category->cat_ID . ' post_item_has_children">';
			$html .= '<a href="' . get_category_link( $category->cat_ID ) . '">' . $category->name . '</a>';
			$html .= thk_list_postlist_categories( $category->cat_ID );
			$html .= thk_list_parent_categories( $category->cat_ID );
			$html .= '</li>'."\n";
		}
	}
	if( !empty( $html ) ) $html = "\n".'<ul>' . $html . '</ul>';

	return $html;
}

function thk_list_postlist_categories( $category_id ) {
	global $post;
	$html = '';
	query_posts( 'cat=' . $category_id . '&posts_per_page=-1' );

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			if( in_category( $category_id ) ) {
				$html .= '<li class="post_item post-item-' . $post->ID . '"><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
				$html .= '</li>'."\n";
			}
		}
	}
	wp_reset_query();
	if( !empty( $html ) ) $html = "\n".'<ul>' . $html . '</ul>';

	return $html;
}
