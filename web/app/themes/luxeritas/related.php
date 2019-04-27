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
<div id="related">
<?php
global $luxe, $post, $wpdb;

$categories = get_the_category( $post->ID );
$tags = get_the_tags( $post->ID );

$cat_post_id = array();
$tag_post_id = array();

// 関数使うより直接 SELECT 文発行した方が速い
// 同じカテゴリに属する post_id 取得
if( !empty( $categories ) ) {
	foreach( (array)$categories as $val ) {
		//$cat_post_id = wp_parse_args( $cat_post_id, $wpdb->get_col( "SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = $val->cat_ID AND object_id != $post->ID" ) );
		$cat_post_id = wp_parse_args( $cat_post_id, $wpdb->get_col( "SELECT object_id FROM $wpdb->term_relationships, $wpdb->term_taxonomy WHERE $wpdb->term_taxonomy.term_id = $val->cat_ID AND $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id AND object_id != $post->ID" ) );
	}
	shuffle( $cat_post_id );
}

// 同じタグに属する post_id 取得
if( !empty( $tags ) ) {
	foreach( (array)$tags as $val ) {
		//$tag_post_id = wp_parse_args( $tag_post_id, $wpdb->get_col( "SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = $val->term_taxonomy_id AND object_id != $post->ID" ) );
		$tag_post_id = wp_parse_args( $tag_post_id, $wpdb->get_col( "SELECT object_id FROM $wpdb->term_relationships, $wpdb->term_taxonomy WHERE $wpdb->term_taxonomy.term_taxonomy_id = $val->term_taxonomy_id AND $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id AND object_id != $post->ID" ) );
	}
	shuffle( $tag_post_id );
}

// 同じタグに属する記事を優先表示させるため wp_parse_args 使わない( wp_parse_args だと同じ値があった時に、配列の後ろが残る形になるため )
//$post_in = wp_parse_args( $tag_post_id, $cat_post_id );
// key は使わず単なる連番なので、array_merge で結合するより + 演算子で結合しちゃった方が速い
//$post_in = array_unique( $tag_post_id + $cat_post_id );
// と思ったけど、array_merge じゃないと要素が消えるパターンがあるから、やっぱり array_merge にしたｗ
$post_in = array_unique( array_merge( $tag_post_id, $cat_post_id ) );

$sticky_posts = get_option( 'sticky_posts' );

$args = array(
	'post__not_in' => array( $post->ID ),
	'posts_per_page'=> 5,
	'post__in' => $post_in,
	'post__not_in' => $sticky_posts,
	'orderby' => 'post__in',
);
$st_query = new WP_Query($args);

if( $st_query->have_posts() === true ) {
	while( $st_query->have_posts() === true ) {
		$wp_upload_dir = wp_upload_dir();

		$st_query->the_post();
?>
<div class="toc clearfix">
<?php
		if( isset( $luxe['thumbnail_visible'] ) ) {
?>
<div class="term"><a href="<?php the_permalink() ?>" aria-hidden="true"><?php
			$attachment_id = false;
			$post_thumbnail = has_post_thumbnail();

			if( $post_thumbnail === false && isset( $luxe['no_img'] ) ) {
				$attachment_id = thk_get_image_id_from_url( $luxe['no_img'] );
				if( $attachment_id !== false ) $post_thumbnail = true;
			}

			if( $post_thumbnail === true ) {	// サムネイル
				$thumb = 'thumb100';
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src( $image_id, $thumb );
				if( isset( $image_url[0] ) ) {
					$image_path = str_replace( $wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $image_url[0] );

					if( file_exists( $image_path ) === false ) {
						$thumb = 'thumbnail';
					}
				}
				else {
					$thumb = 'thumbnail';
				}
				if( $attachment_id !== false ) {
					echo wp_get_attachment_image( $attachment_id );
				}
				else {
					the_post_thumbnail( $thumb );
				}
			}
			else {
?><img src="<?php echo TURI; ?>/images/no-img-100x100.png" alt="No Image" title="No Image" width="100" height="100" />
<?php
			}
?></a>
</div>
<?php
		}
?>
<div class="excerpt">
<h3><a href="<?php the_permalink(); ?>" aria-label="<?php echo __( 'Related Posts', 'luxeritas' ); ?>"><?php the_title(); ?></a></h3>
<p><?php echo apply_filters( 'thk_excerpt_no_break', 40 ); ?></p>
</div>
</div>
<?php
	}
}
else {
?>
<p class="no-related"><?php echo __( 'No related posts yet.', 'luxeritas' ); ?></p>
<?php
}
wp_reset_postdata();
?>
</div>
