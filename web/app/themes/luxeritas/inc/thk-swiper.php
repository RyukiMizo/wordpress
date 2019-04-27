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

if( function_exists('thk_swiper') === false ):
function thk_swiper( $args, $title, $item_types, $ids = null, $item_max, $show_max, $thumb = 'medium', $height = 'auto', $heightpx = 0, $width = 'auto', $slide_bg = 'transparent', $navigation, $next_prev, $nav_color, $titleview = null, $efect = 'none', $darkness = null, $center = 'post', $no_lazyload = null, $autoplay = 0 ) {
	$cargs = array();

	if( $item_types === 'cat_list' && ( is_single() === true || is_category() === true ) ) {
		$cat = null;
		if( is_category() === false ) {
			$category = get_the_category();
			if( empty( $category ) ) return;
			$cat = $category[0]->cat_ID;
		}
		else {
			$cat = get_queried_object_id();
		}
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'cat' => $cat );
	}
	elseif( $item_types === 'tag_list' && ( is_single() === true || is_tag() === true ) ) {
		$tag_id = null;
		if( is_tag() === false ) {
			$tags = get_tags();
			if( empty( $tags ) ) return;
			$tag_id = $tags[0]->term_taxonomy_id;
		}
		else {
			$tag_id = get_queried_object_id();
		}
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'tag_id' => $tag_id );
	}
	elseif( ( $item_types === 'cat_list' || $item_types === 'tag_list' ) && ( is_year() === true || is_month() === true || is_date() === true ) ) {
		$year  = get_query_var('year');
		$month = get_query_var('monthnum');
		$day   = get_query_var('day');

		if( is_year() === true ) {
			$cargs = array( 'posts_per_archive_page' => $item_max, 'post_status' => 'publish', 'date_query' => array( 'year' => $year ) );
		}
		elseif( is_month() === true ) {
			$cargs = array( 'posts_per_archive_page' => $item_max, 'post_status' => 'publish', 'date_query' => array( 'year' => $year, 'month' => $month ) );
		}
		else {
			$cargs = array( 'posts_per_archive_page' => $item_max, 'post_status' => 'publish', 'date_query' => array( 'year' => $year, 'month' => $month, 'day' => $day ) );
		}
	}
	elseif( $item_types === 'page_list' ) {
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'post_type' => 'page' );
	}
	elseif( $item_types === 'specified' && !empty( $ids ) ) {
		$specifieds = null;
		if( $item_types === 'specified' && !empty( $ids ) ) {
			$specifieds  = array();
			$post_not_in = array();
			$arr = explode( ',', $ids );

			foreach( (array)$arr as $value ) {
				$specifieds = array_merge( $specifieds, explode( "\n", $value ) );
			}

			$sticky_posts = get_option( 'sticky_posts' );

			foreach( (array)$sticky_posts as $value ) {
				if( in_array( $value, $specifieds ) === false ) {
					$post_not_in[] = $value;
				}
			}

			if( count( $specifieds ) < $item_max ) {
				$item_max = count( $specifieds );
			}
			$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'post__in' => $specifieds, 'post__not_in' => $post_not_in, 'post_type' => 'any' );
		}
	}
	elseif( $item_types === 'all_list' || is_home() === true || is_front_page() === true ) {
		$found_posts = wp_count_posts( 'post' );
		if( (int)$found_posts->publish < $item_max ) $item_max = (int)$found_posts->publish;
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'post_type' => 'post' );
	}
	else {
		return;
	}

	$cquery = new WP_Query( $cargs );

	if( $cquery->found_posts < $item_max ) $item_max = $cquery->found_posts;
	if( $show_max > $item_max ) $show_max = $item_max - 1;
	if( $show_max <= 0 ) $show_max = 1;

	echo "<!--[if (gte IE 10)|!(IE)]><!-->\n";
	echo $args['before_widget'];
	if( !empty( $title ) ) echo $args['before_title'], $title, $args['after_title'];

	$max_height = '';
	if( $height !== 'auto' ) {
		$max_height = $heightpx . 'px';
	}
	else {
		$max_height = $thumb === 'thumbnail' ? '150px' : '300px';
	}
?>
<div class="swiper-container" style="display:none">
<div class="swiper-wrapper">
<?php
	global $luxe, $awesome;
	$_is_singular = is_singular();
	$post_id = null;
	$idx = 0;
	$i = 0;
	if( $_is_singular === true) $post_id = get_the_ID();

	if( $cquery->have_posts() === true ) {
		while( $cquery->have_posts() === true ) {
			$cquery->the_post();
			$attachment_id = false;
			$post_thumbnail = has_post_thumbnail();

			if( $post_thumbnail === false && isset( $luxe['no_img'] ) ) {
				$attachment_id = thk_get_image_id_from_url( $luxe['no_img'] );
				if( $attachment_id !== false ) $post_thumbnail = true;
			}

			if( $post_thumbnail === true ) {
?>
<a href="<?php the_permalink() ?>" class="swiper-slide"><?php
				if( $attachment_id !== false ) {
					$thumb_img_tag = wp_get_attachment_image( $attachment_id );
				}
				else {
					$thumb_img_tag = get_the_post_thumbnail( $cquery->ID, $thumb );
				}

				// Javascript が無効なら、そもそも表示されないので <noscript> は不要なので消す
				$e = strpos( $thumb_img_tag, '<noscript>' ) ? strstr( $thumb_img_tag, '<noscript>', true ) : $thumb_img_tag;

				if( $no_lazyload != 0 ) {
					$e = str_replace( 'class="lazy ', 'class="', $e );
					$e = str_replace( 'data-srcset', 'srcset', $e );
					$e = preg_replace( '/(<img[^>]+?)src=".+?trans\.png" data-src=(.+?) \/>/im', '$1src=$2 />', $e );
				}
				echo $e;
?><?php if( isset( $titleview ) ) { ?><p class="swiper-title"><?php the_title(); ?></p><?php } ?></a>
<?php
			}
			else {
				$no_img_png = 'no-img-400x300.png';
				$no_img_wid = 400;
				$no_img_hgt = 300;

				if( $thumb === 'thumbnail' ) {
					$no_img_png = 'no-img.png';
					$no_img_wid = 150;
					$no_img_hgt = 150;
				}
				elseif( $thumb === 'medium' ) {
					$no_img_png = 'no-img-300x225.png';
					$no_img_wid = 300;
					$no_img_hgt = 225;
				}
				elseif( $thumb === 'thumb320' ) {
					$no_img_png = 'no-img-320x180.png';
					$no_img_wid = 320;
					$no_img_hgt = 180;
				}
?>
<a href="<?php the_permalink() ?>" class="swiper-slide"><img src="<?php echo TURI; ?>/images/<?php echo $no_img_png; ?>" itemprop="image" class="thumbnail" alt="No Image" title="No Image" width="<?php echo $no_img_wid; ?>" height="<?php echo $no_img_hgt; ?>" /><?php if( isset( $titleview ) ) { ?><p class="swiper-title"><?php the_title(); ?></p><?php } ?></a>
<?php
			}

			if( $cquery->post->ID === $post_id ) $idx = $i;
			++$i;
		}
	}
	wp_reset_postdata();

	if( $center !== 'post' ) $idx = 0;
?>
</div>
<?php
	if( $next_prev !== 'none' ) {
?>
<div class="swiper-button-prev"></div>
<div class="swiper-button-next"></div>
<?php
	}
	if( $navigation !== 'none' ) {
?>
<div class="swiper-pagination"></div>
<?php
	}
	$min_css_file = $awesome === 4 ? 'thk-swiper.min.css' : 'thk-swiper-5.min.css';

	$min_css = array( TPATH . DSEP . 'styles' . DSEP . $min_css_file, TDEL . '/styles/' . $min_css_file );
	$min_css[1] .= file_exists( $min_css[0] ) === true ? '?v=' . filemtime( $min_css[0] ) : '?v=' . $_SERVER['REQUEST_TIME'];

	$min_js = array( TPATH . DSEP . 'js' . DSEP . 'thk-swiper.min.js', TDEL . '/js/thk-swiper.min.js' );
	$min_js[1] .= file_exists( $min_js[0] ) === true ? '?v=' . filemtime( $min_js[0] ) : '?v=' . $_SERVER['REQUEST_TIME'];

	$swiper_js = array( TPATH . DSEP . 'js' . DSEP . 'swiper.min.js', TDEL . '/js/swiper.min.js' );
	$swiper_js[1] .= file_exists( $swiper_js[0] ) === true ? '?v=' . filemtime( $swiper_js[0] ) : '?v=' . $_SERVER['REQUEST_TIME'];
?>
</div>
<script>(function() {
var elm = document.querySelector('#<?php echo $args['widget_id']; ?> .swiper-container'),
c = elm.style;
c.maxHeight='<?php echo $max_height?>';
c.display='block';
c.visibility='hidden';
})();</script>
<script src="<?php echo $min_js[1] ?>"></script>
<script>thk_swiper( '<?php echo $swiper_js[1] ?>', '<?php echo $min_css[1] ?>',<?php
echo
	"'", $args['widget_id'], "'", ',',
	$idx, ',',
	$item_max, ',',
	$show_max, ',',
	"'", $height, "'", ',',
	$heightpx, ',',
	"'", $width, "'", ',',
	"'", $slide_bg, "'", ',',
	"'", $navigation, "'", ',',
	"'", $next_prev, "'", ',',
	"'", $nav_color, "'", ',',
	"'", $efect, "'", ',',
	"'", $center, "'", ',',
	"'", $darkness, "'", ',',
	$autoplay
; ?> );</script>
<?php
	echo $args['after_widget'];
	echo "<!--<![endif]-->\n";
}
endif;
