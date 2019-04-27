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

global $luxe, $observe;

unset( $luxe['meta_under'] );

if( $luxe['grid_tile_order'] !== 'ThumbTM' && $luxe['grid_tile_order'] !== 'ThumbMT' ) get_template_part('meta');
if( $luxe['grid_tile_order'] === 'MTThumb' ) {
?>
<h2 class="entry-title" itemprop="headline name"><a href="<?php the_permalink(); ?>" class="entry-link" itemprop="url"><?php the_title(); ?></a></h2>
<?php
}
?>
<figure class="term">
<?php
if( isset( $luxe['thumbnail_visible'] ) ) {
	$attachment_id = false;
	$post_thumbnail = has_post_thumbnail();

	if( $post_thumbnail === false && isset( $luxe['no_img'] ) ) {
		$attachment_id = thk_get_image_id_from_url( $luxe['no_img'] );
		if( $attachment_id !== false ) $post_thumbnail = true;
	}

	if( $post_thumbnail === true ) {	// サムネイル
		$thumb = $luxe['thumbnail_is_size_tile'];
?>
<a href="<?php the_permalink() ?>" aria-hidden="true"><?php
		if( $attachment_id !== false ) {
			echo wp_get_attachment_image( $attachment_id, $thumb, 0, array( 'itemprop' => 'image', 'class' => 'thumbnail' ) );
		}
		else {
			$attachment_id = get_post_thumbnail_id();
			if( thk_thumbnail_exists( $attachment_id, $thumb ) === false ) {
				$thumb = 'full';
			}
			the_post_thumbnail( $thumb, array( 'itemprop' => 'image', 'class' => 'thumbnail' ) );
		}
?></a>
<?php
	}
	elseif( isset( $luxe['noimage_visible'] ) ) {
		$no_img_png = 'no-img-320x180.png';
		$no_img_wid = 320;
		$no_img_hgt = 180;

		switch( $luxe['thumbnail_is_size_tile'] ) {
			case 'thumb75':
				$no_img_png = 'no-img-75x75.png';
				$no_img_wid = 75;
				$no_img_hgt = 75;
				break;
			case 'thumbnail':
				$no_img_png = 'no-img-150x150.png';
				$no_img_wid = 150;
				$no_img_hgt = 150;
				break;
			case 'medium':
			case 'user_thumb_1':
			case 'user_thumb_2':
			case 'user_thumb_3':
				$no_img_png = 'no-img-300x225.png';
				$no_img_wid = 300;
				$no_img_hgt = 225;
				break;
			case 'large':
			case 'full':
				$no_img_png = 'no-img.png';
				$no_img_wid = 1024;
				$no_img_hgt = 768;
				break;
			default:
				break;
		}

		$no_img_org = '<img src="' . TURI . '/images/' . $no_img_png . '" itemprop="image" class="thumbnail" alt="No Image" title="No Image" width="' . $no_img_wid . '" height="' . $no_img_hgt . '" />';
		if( !isset( $luxe['lazyload_thumbs'] ) ) {
			$no_img = $no_img_org;
		}
		else {
			$no_img = '<img src="' . $luxe['trans_image'] . '" data-src="' . TURI . '/images/' . $no_img_png . '" itemprop="image" class="lazy thumbnail" alt="No Image" title="No Image" width="' . $no_img_wid . '" height="' . $no_img_hgt . '" />';
			if( isset( $luxe['lazyload_noscript'] ) ) {
				$no_img .= '<noscript>' . $no_img_org . '</noscript>';
			}
		}
?>
<a href="<?php the_permalink() ?>" aria-hidden="true"><?php echo $no_img; ?></a>
<?php
	}

	if( isset( $luxe['lazyload_thumbs'] ) && $observe < 3 ) {
		echo '<script>thklazy()</script>';
	}
	++$observe;
}
?>
</figure><!--/.term-->
<?php
if( $luxe['grid_tile_order'] === 'ThumbMT' ) get_template_part('meta');
if( $luxe['grid_tile_order'] !== 'MTThumb' ) {
?>
<h2 class="entry-title" itemprop="headline name"><a href="<?php the_permalink(); ?>" class="entry-link" itemprop="url"><?php the_title(); ?></a></h2>
<?php
}

if( $luxe['grid_tile_order'] === 'ThumbTM' ) get_template_part('meta');

if( isset( $luxe['excerpt_length_tile'] ) && (int)$luxe['excerpt_length_tile'] > 0 ) {
?>
<div class="excerpt" itemprop="description"><div class="exsp">
<?php
	if( !isset( $luxe['break_excerpt_tile'] ) ) {
		echo apply_filters( 'thk_excerpt', $luxe['excerpt_length_tile'], '' );
	}
	else {
		echo apply_filters( 'thk_excerpt_no_break', $luxe['excerpt_length_tile'], '' );
	}
?>
</div></div>
<?php
}
// 記事を読むリンク
if( !empty( $luxe['read_more_text_tile'] ) ) {
	$length = isset( $luxe['short_title_length_tile'] ) ? $luxe['short_title_length_tile'] : 8;
?>
<p class="read-more"><a href="<?php the_permalink(); ?>" class="read-more-link" aria-hidden="true" itemprop="url"><?php echo ( isset( $luxe['read_more_short_title_tile'] ) ) ? read_more_title_add( $luxe['read_more_text_tile'], $length ) : $luxe['read_more_text_tile']; ?></a></p>
<?php
}
