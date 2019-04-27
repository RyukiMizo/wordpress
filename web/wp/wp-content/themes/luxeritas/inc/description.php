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

/*---------------------------------------------------------------------------
 * タグ名やカテゴリ名を meta keyords に変換
 *---------------------------------------------------------------------------*/
if( function_exists( 'tag_to_keywords' ) === false ):
function tag_to_keywords() {
	global $wp_query;
	$keys = '';

	if( is_single() === true ) {
		$cat_array = get_the_category( $wp_query->post->ID );
		if( is_array( $cat_array ) === true ) {
			foreach( $cat_array as $value) {
				$keys .= esc_html( $value->cat_name ) . ', ';
			}
			$tag_array = get_the_tags( $wp_query->post->ID );
		}
		if( is_array( $tag_array ) === true ) {
			foreach ( $tag_array as $value ) {
				$keys .= esc_html( $value->name ) . ', ';
			}
		}
		$keys = rtrim( $keys, ', ' );
	}
	elseif( get_query_var('cat') ) {
		$keys .= single_cat_title( '', false );
	}
	elseif( is_tag() === true ) {
		$keys .= single_tag_title( '', false );
	}
	elseif( is_month() === true ) {
		$keys .= get_the_date( __( 'F Y', 'luxeritas' ) );
	}
	return $keys;
}
endif;

/*---------------------------------------------------------------------------
 * オリジナルディスクリプション挿入
 *---------------------------------------------------------------------------*/
add_filter( 'wp_head', function() use( $luxe ) {
	$desc = apply_filters( 'thk_create_description', '' );
?>
<meta name="description" content="<?php echo $desc; ?>" />
<?php
	$keywords = '';
	if( is_singular() === true ) {
		global $post;
		$k = trim( get_post_meta( $post->ID, 'add-keywords', true ), ',' );
		$keys = explode( ',', $k );
		foreach( $keys as $val ) {
			$keywords .= trim( $val ) . ', ';
		}
		$keywords = trim( $keywords );
		$keywords = trim( $keywords, ',' );
	}
	if( $luxe['meta_keywords'] !== 'none' ) {
		if( is_single() === true || is_category() === true || is_tag() === true || is_month() === true ) {
			$keywords .= ', ' . tag_to_keywords( 'tags' );
		}
	}

	if( !empty( $keywords ) ) {
?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php
	}

	if( isset( $luxe['pwa_theme_color'] ) && stripos( $luxe['pwa_theme_color'], '#' ) < 1 ) {
?>
<meta name="theme-color" content="<?php echo $luxe['pwa_theme_color']; ?>">
<?php
	}
	if( isset( $luxe['prevent_tel_links'] ) || isset( $luxe['prevent_email_links'] ) || isset( $luxe['prevent_address_links'] ) ) {
		$format_detection = '';
		if( isset( $luxe['prevent_tel_links'] ) ) {
			$format_detection .= 'telephone=no,';
		}
		if( isset( $luxe['prevent_email_links'] ) ) {
			$format_detection .= 'email=no,';
		}
		if( isset( $luxe['prevent_address_links'] ) ) {
			$format_detection .= 'address=no,';
		}
		$format_detection = rtrim( $format_detection, ',');
?>
<meta name="format-detection" content="<?php echo $format_detection; ?>">
<?php
	}
}, 5 );

/*---------------------------------------------------------------------------
 * OGP 挿入
 *---------------------------------------------------------------------------*/
add_filter( 'wp_head', function() use( $luxe ) {
	global $post;

	$_is_singular = is_singular();

	if( isset( $luxe['facebook_ogp_enable'] ) || isset( $luxe['twitter_card_enable'] ) ) {
		$url = '';
		$image = '';
		$width = '';
		$height = '';
		$img_alt = '';
		$title = wp_get_document_title();
		$blog_name = get_bloginfo('name');
		//$site_name = $blog_name . ' ' . thk_title_separator( '|' ) . ' ' . THK_DESCRIPTION;
		if( $_is_singular === true ) {
			$cont = $post->post_content;
			$preg = '/<img.*?src=(["\'])(.+?)\1.*?>/i';

			$url = get_the_permalink();

			$og_img = get_post_meta( $post->ID, 'og_img', true );
			$post_thumbnail = has_post_thumbnail();

			if( !empty( $og_img ) ) {
				$image = $og_img;
				$img_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
			}
			elseif( !empty( $post_thumbnail ) ) {
				$img_id = get_post_thumbnail_id();
				$img_arr = wp_get_attachment_image_src( $img_id, 'full');
				$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
				$image = $img_arr[0];
			}
			elseif( preg_match( $preg, $cont, $img_url ) ) {
				$image = $img_url[2];
			}
			elseif( isset( $luxe['og_img'] ) ) {
				$image = $luxe['og_img'];
			}
			else {
				$uri = TURI === SURI ? TURI : SURI;
				$image = $uri . '/images/og.png';
			}

			if( !empty( $img_alt ) ) $img_alt = esc_attr( $img_alt );
		}
		else {
			$url = THK_HOME_URL;

			if( get_header_image() === true ){
				$image = get_header_image();
			}
			elseif( isset( $luxe['og_img'] ) ) {
				$image = $luxe['og_img'];
			}
			else {
				$uri = TURI === SURI ? TURI : SURI;
				$image = $uri . '/images/og.png';
			}
		}
		$img_info = thk_get_image_size( $image );

		if( is_array( $img_info ) === true ) {
			$width  = $img_info[0];
			$height = $img_info[1];
		}
		$desc = apply_filters( 'thk_create_description', '', 90 );
	}
	if( isset( $luxe['facebook_ogp_enable'] ) ) {
		require( INC . 'locale.php' );
		$loc = new thk_locale();
		$og_locale = $loc->thk_locale_wp_2_ogp( get_bloginfo('language') );
?>
<meta property="og:type" content="<?php echo $_is_singular === true ? 'article' : 'website'; ?>" />
<meta property="og:url" content="<?php echo $url; ?>" />
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:description" content="<?php echo $desc; ?>" />
<meta property="og:image" content="<?php echo $image; ?>" />
<?php if( !empty( $width ) ) { ?>
<meta property="og:image:width" content="<?php echo $width; ?>" />
<?php } ?>
<?php if( !empty( $height ) ) { ?>
<meta property="og:image:height" content="<?php echo $height; ?>" />
<?php } ?>
<?php if( !empty( $img_alt ) ) { ?>
<meta property="og:image:alt" content="<?php echo $img_alt; ?>" />
<?php } ?>
<meta property="og:site_name" content="<?php echo $blog_name; ?>" />
<meta property="og:locale" content="<?php echo $og_locale; ?>" />
<?php if( isset( $luxe['facebook_admin'] ) ) { ?>
<meta property="fb:admins" content="<?php echo $luxe['facebook_admin']; ?>" />
<?php } ?>
<?php if( isset( $luxe['facebook_app_id'] ) ) { ?>
<meta property="fb:app_id" content="<?php echo $luxe['facebook_app_id']; ?>" />
<?php } ?>
<?php
		if( $_is_singular === true ) {
			$cat = get_the_category();
			$cat = isset( $cat[0] ) ? $cat[0] : null;

			$published_time = get_post( $post->ID )->post_date;
			$published_time = str_replace( ' ', 'T', $published_time ) . 'Z';
			$modified_time = get_post( $post->ID )->post_modified;
			$modified_time = str_replace( ' ', 'T', $modified_time ) . 'Z';

			if( !empty( $cat->cat_name ) ) {
?>
<meta property="article:section" content="<?php echo $cat->cat_name; ?>" />
<?php
			}
?>
<meta property="article:published_time" content="<?php echo $published_time ?>" />
<meta property="article:modified_time" content="<?php echo $modified_time ?>" />
<?php
		}
	}
	if( isset( $luxe['twitter_card_enable'] ) ) {
?>
<meta name="twitter:card" content="<?php echo $luxe['twitter_card_type']; ?>" />
<?php
		if( !isset( $luxe['facebook_ogp_enable'] ) ) {
?>
<meta name="twitter:url" content="<?php echo $url; ?>" />
<meta name="twitter:title" content="<?php echo $title; ?>" />
<meta name="twitter:description" content="<?php echo $desc; ?>" />
<meta name="twitter:image" content="<?php echo $image; ?>" />
<?php
		}
?>
<meta name="twitter:domain" content="<?php echo $_SERVER['SERVER_NAME']; ?>" />
<?php if( isset( $luxe['twitter_id'] ) ) { ?>
<meta name="twitter:creator" content="@<?php echo $luxe['twitter_id']; ?>" />
<meta name="twitter:site" content="@<?php echo $luxe['twitter_id']; ?>" />
<?php } ?>
<?php
	}
}, 6 );
