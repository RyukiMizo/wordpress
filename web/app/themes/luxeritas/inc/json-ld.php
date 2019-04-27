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

add_filter( 'thk_json_ld', function() {
	global $luxe, $post, $cat;

	$jsonld = '';
	$_is_single = is_single();
	$_is_singular = is_singular();

	$thk_org_id = get_queried_object_id();
	$thk_org_url = wp_get_canonical_url( $thk_org_id );
	$author_name = '';

	if( $_is_singular === true ) {
		$author = isset( $post->post_author ) ? get_userdata( $post->post_author ) : '';
		if( isset( $author->ID ) ) {
			$author_name = get_the_author_meta( 'display_name', $author->ID );
		}
	}

	$prefix = '<script type="application/ld+json">';
	$suffix = '</script>';

	if( $luxe['html_compress'] === 'none' ) {
		$prefix .= "\n";
		$suffix = "\n" . $suffix . "\n";
	}

	/*---------------------------------------------------------------------------
	 * WPHeader
	 *---------------------------------------------------------------------------*/
	$wpheader = [
		"@context"		=> "http://schema.org",
		"@type"			=> "WPHeader",
	];
	if( $_is_singular === true ) {
		$title = get_the_title( $thk_org_id );
		$wpheader += [
			"about"			=> $title,
			"headline"		=> $title,
			"alternativeHeadline"	=> apply_filters( 'thk_create_description', '' ),
			"datePublished"		=> get_the_time('Y/m/d', $thk_org_id),
			"dateModified"		=> get_the_modified_time('Y/m/d', $thk_org_id),
			"author"		=> array(
				"@type"			=> "Person",
				"name"			=> $author_name,
			),
		];
	}
	else {
		$title = wp_get_document_title();
		$wpheader += [
			"about"			=> $title,
			"headline"		=> $title,
		];
	}

	$jsonld .= $prefix . @json_encode( $wpheader ) . $suffix;

	/*---------------------------------------------------------------------------
	 * Article
	 *---------------------------------------------------------------------------*/
	if( $_is_singular === true ) {
		$logo = '';
		if( isset( $luxe['amp'] ) && isset( $luxe['amp_logo'] ) ) {
			$logo = $luxe['amp_logo'];
		}
		elseif( !isset( $luxe['amp'] ) && isset( $luxe['site_logo'] ) ) {
			$logo = $luxe['site_logo'];
		}
		else {
			$logo .= TURI . '/images/site-logo.png';
		}
		$logo_info = thk_get_image_size( $logo );
		$logo_w = 600;
		$logo_h = 60;

		if( is_array( $logo_info ) === true ) {
			$logo_w = $logo_info[0];
			$logo_h = $logo_info[1];

			if( $logo_info[0] >= 600 ) {
				$logo_w = 600;
				$logo_h = round( $logo_w * $logo_info[1] / $logo_info[0] );
			}
			if( $logo_h >= 60 ) {
				$logo_h = 60;
				$logo_w = round( $logo_h * $logo_info[0] / $logo_info[1] );
			}
		}

		$thumb = '';
		$thumb_info = false;
		$thumb_w = 696;
		$thumb_h = 696;

		if( isset( $luxe['thumbnail_visible'] ) ) {
			$thumb_id  = get_post_thumbnail_id( $thk_org_id );
			$thumb_url = wp_get_attachment_image_src( $thumb_id, true );
			$thumb = $thumb_url[0];
		}
		if( empty( $thumb ) ) {
			$no_img_png = 'no-img.png';
			$thumb = TURI . '/images/no-img.png';
		}
		else {
			$thumb_info = thk_get_image_size( $thumb );
		}

		if( is_array( $thumb_info ) === true ) {
			$thumb_w = $thumb_info[0];
			$thumb_h = $thumb_info[1];

			if( $thumb_info[0] < 696 ) {
				$thumb_w = 696;
				$thumb_h = round( $thumb_w * $thumb_info[1] / $thumb_info[0] );
			}
		}

		$publisher = 'Organization';
		if( isset( $luxe['site_name_type'] ) ) {
			if( $luxe['site_name_type'] === 'Organization' && isset( $luxe['organization_type'] ) ) {
				$publisher = $luxe['organization_type'];
			}
		}

		$article = [
			"@context"		=> "http://schema.org",
			"@type"			=> "Article",
			"mainEntityOfPage"	=> array(
				"@type"			=> "WebPage",
				"@id"			=> $thk_org_url,
			),
			"headline"		=> get_the_title( $thk_org_id ),
			"image"			=> array(
				"@type"			=> "ImageObject",
				"url"			=> $thumb,
				"width"			=> $thumb_w,
				"height"		=> $thumb_h,
			),
			"datePublished"		=> get_the_time('Y/m/d', $thk_org_id),
			"dateModified"		=> get_the_modified_time('Y/m/d', $thk_org_id),
			"author"		=> array(
				"@type"			=> "Person",
				"name"			=> $author_name,
			),
			"publisher"			=> array(
				"@type"			=> $publisher,
				"name"			=> THK_SITENAME,
				"description"		=> isset( $luxe['header_catchphrase_change'] ) ? $luxe['header_catchphrase_change'] : THK_DESCRIPTION,
				"logo"			=> array(
					"@type"			=> "ImageObject",
					"url"			=> $logo,
					"width"			=> $logo_w,
					"height"		=> $logo_h, "\n",
				),
			),
			"description"		=> apply_filters( 'thk_create_description', '' ),
		];

		$jsonld .= $prefix . @json_encode( $article ) . $suffix;
	}

	/*---------------------------------------------------------------------------
	 * Organization
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['site_name_type'] ) && $luxe['site_name_type'] !== 'WebSite' ) {
		$organization_type = 'Organization';
		if( isset( $luxe['organization_type'] ) ) $organization_type = $luxe['organization_type'];

		$organization = [
			"@context"		=> "http://schema.org",
			"@type"			=> $organization_type,
			"url"			=> THK_HOME_URL,
			"name"			=> THK_SITENAME,
			"description"		=> apply_filters( 'thk_create_description', '' ),
			"brand"			=> array(
				"@type"			=> "Thing",
				"name"			=> THK_SITENAME,
			),
		];

		if( isset( $luxe['organization_logo'] ) && $luxe['organization_logo'] === 'set' && isset( $luxe['org_logo'] ) ) {
			$logo_w = 0;
			$logo_h = 0;
			$logo_info = thk_get_image_size( $luxe['org_logo'] );
			if( is_array( $logo_info ) === true ) {
				$logo_w = $logo_info[0];
				$logo_h = $logo_info[1];
			}
			$organization += [
				"image"			=> array(
					"@type"			=> "ImageObject",
					"url"			=> $luxe['org_logo'],
					"width"			=> $logo_w,
					"height"		=> $logo_h,
				),
				"logo"			=> $luxe['org_logo'],
			];
		}

		$jsonld .= $prefix . @json_encode( $organization ) . $suffix;
	}

	/*---------------------------------------------------------------------------
	 * BreadcrumbList
	 *---------------------------------------------------------------------------*/
	$itemListElement[] = [
		"@type"			=> "ListItem",
		"name"			=> $luxe['home_text'],
		"position"		=> 1,
		"item"			=> THK_HOME_URL,
	];

	if( is_page() === true && is_home() === false && is_front_page() === false ) {
		$i = 2;
		$parents = array_reverse( get_post_ancestors( $post->ID ) );

		if( empty( $parents ) ) {
			$itemListElement[] = [
				"@type"			=> "ListItem",
				"name"			=> get_the_title(),
				"position"		=> 2,
				"item"			=> get_the_permalink(),
			];
		}
		else {
			foreach ( $parents as $p_id ){
				$itemListElement[] = [
					"@type"			=> "ListItem",
					"name"			=> get_page( $p_id )->post_title,
					"position"		=> $i,
					"item"			=> get_page_link( $p_id ),
				];
				++$i;
			}
			$itemListElement[] = [
				"@type"			=> "ListItem",
				"name"			=> get_the_title(),
				"position"		=> $i,
				"item"			=> get_the_permalink(),
			];
		}
	}
	elseif( is_attachment() === true ) {
		$itemListElement[] = [
			"@type"			=> "ListItem",
			"name"			=> get_the_title(),
			"position"		=> 2,
			"item"			=> get_the_permalink(),
		];
	}
	elseif( $_is_single === true || is_category() === true ) {
		$cat_obj = $_is_single === true ? get_the_category() : array( get_category( $cat ) );
		if( !empty( $cat_obj ) && is_wp_error( $cat_obj ) === false ) {
			$i = 2;
			$html = null;
			$sort_array = array();
			$pars = get_category( $cat_obj[0]->parent );

			while( $pars && !is_wp_error( $pars ) && $pars->cat_ID != 0 ) {
				$sort_array[] = [
					"@type"			=> "ListItem",
					"name"			=> $pars->name,
					"position"		=> "<!--position-->",
					"item"			=> get_category_link( $pars->cat_ID ),
				];
				$pars = get_category( $pars->parent );
			}
			if( !empty( $sort_array ) ) $sort_array = array_reverse( $sort_array );

			$sort_array[] = [
				"@type"			=> "ListItem",
				"name"			=> $cat_obj[0]->name,
				"position"		=> "<!--position-->",
				"item"			=> get_category_link( $cat_obj[0]->cat_ID ),
			];

			if( $_is_single === true ) {
				$sort_array[] = [
					"@type"			=> "ListItem",
					"name"			=> get_the_title(),
					"position"		=> "<!--position-->",
					"item"			=> get_the_permalink(),
				];
			}

			foreach( (array)$sort_array as $key => $val ) {
				$sort_array[$key]['position'] = str_replace( '<!--position-->', $i, $val['position'] );
				++$i;
			}

			$itemListElement[] = $sort_array;
		}
	}
	elseif(
		is_tag() === true	||
		is_tax() === true	||
		is_day() === true	||
		is_month() === true	||
		is_year() === true	||
		is_author() === true	||
		is_search() === true	||
		is_post_type_archive() === true
	) {
		if( is_tag() === true ) {
			$name = single_tag_title( '', false );
		}
		elseif( is_tax() === true ) {
			$name = single_term_title( '', false );
		}
		elseif( is_day() === true ) {
			$name = get_the_date( __( 'F j, Y', 'luxeritas' ) );
		}
		elseif( is_month() === true ) {
			$name = get_the_date( __( 'F Y', 'luxeritas' ) );
		}
		elseif( is_year() === true ) {
			$name = get_the_date( __( 'Y', 'luxeritas' ) );
		}
		elseif( is_author() === true ) {
			$name = esc_html(get_queried_object()->display_name);
		}
		elseif( is_search() === true ) {
			if( !empty( $s ) ) {
				$name = sprintf( __( 'Search results of [%s]', 'luxeritas' ), esc_html( $s ) );
			}
			else {
				$name = 'Search results';
			}
		}
		elseif( is_post_type_archive() === true ) {
			$name = post_type_archive_title( '', false );
		}
		$http = is_ssl() ? 'https' : 'http' . '://';

		$itemListElement[] = [
			"@type"			=> "ListItem",
			"name"			=> $name,
			"position"		=> 2,
			"item"			=> $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],
		];
	}

	$breadcrumb = [
		"@context" => "http://schema.org",
		"@type" => "BreadcrumbList",
		"itemListElement" => $itemListElement
	];

	$jsonld .= $prefix . @json_encode( $breadcrumb ) . $suffix;

	/*---------------------------------------------------------------------------
	 * SiteNavigationElement
	 *---------------------------------------------------------------------------*/
	if( $luxe['global_navi_visible'] === true ) {
		// wp_get_nav_menu_items 使うより wp_nav_menu の結果を加工した方が楽だった
		$navi = wp_nav_menu(
			array(
				'theme_location' => 'global-nav',
				'container'      => '',
				'menu_class'      => '',
				'depth' => '3',
				'echo' => false,
			)
		);
		$nav_array = explode( "<li", $navi );

		foreach( $nav_array as $key => $val ) {
			if( stripos( $val, 'href=' ) === false ) {
				unset( $nav_array[$key] );
				continue;
			}
			$val = strstr( $val, '</a>', true );
			$nav_array[$key] = explode( '>', str_replace( array( '"', "'", 'href=', '</a>' ), '', stristr( $val, 'href=' ) ) );
		}

		$SiteNavigationElement = [];

		foreach( $nav_array as $val ) {
			$SiteNavigationElement[] = [
				"@context"	=> "http://schema.org",
				"@type"		=> "SiteNavigationElement",
				"name"		=> $val[1],
				"url"		=> $val[0],
			];
		}

		$navigation = [
			"@context"	=> "http://schema.org",
			"@graph"	=> $SiteNavigationElement,
		];

		$jsonld .= $prefix . @json_encode( $navigation ) . $suffix;
	}

	/*---------------------------------------------------------------------------
	 * Person
	 *---------------------------------------------------------------------------*/
	if( $_is_singular === true ) {
		$profile_url = THK_HOME_URL;

		if( $luxe['author_page_type'] === 'auth' ) {
			$profile_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
		}
		elseif( $luxe['author_page_type'] !== 'auth' && isset( $luxe['thk_author_url'] ) ) {
			$profile_url = $luxe['thk_author_url'];
		}

		$person = [
			"@context"		=> "http://schema.org",
			"@type"			=> "Person",
			"name"			=> $author_name,
			"url"			=> $profile_url,
		];

		$jsonld .= $prefix . @json_encode( $person ) . $suffix;
	}

	/*---------------------------------------------------------------------------
	 * echo
	 *---------------------------------------------------------------------------*/
	return $jsonld;
}, 9, 1 );
