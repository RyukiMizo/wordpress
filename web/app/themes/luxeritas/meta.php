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

$visible = array( 'P' => false, 'M' => false, 'C' => false, 'T' => false, 'X' => false );
$_is_singular = is_singular();

if( $_is_singular === true ) {
	if( isset( $luxe['meta_under'] ) ) {
		if( isset( $luxe['post_date_u_visible'] ) )		$visible['P'] = true;
		if( isset( $luxe['mod_date_u_visible'] ) )		$visible['M'] = true;
		if( isset( $luxe['category_meta_u_visible'] ) )		$visible['C'] = true;
		if( isset( $luxe['tag_meta_u_visible'] ) )		$visible['T'] = true;
		if( isset( $luxe['tax_meta_u_visible'] ) )		$visible['X'] = true;
	}
	else {
		if( isset( $luxe['post_date_visible'] ) )		$visible['P'] = true;
		if( isset( $luxe['mod_date_visible'] ) )		$visible['M'] = true;
		if( isset( $luxe['category_meta_visible'] ) )		$visible['C'] = true;
		if( isset( $luxe['tag_meta_visible'] ) )		$visible['T'] = true;
		if( isset( $luxe['tax_meta_visible'] ) )		$visible['X'] = true;
	}
}
else {
	if( isset( $luxe['meta_under'] ) ) {
		if( isset( $luxe['list_post_date_u_visible'] ) )	$visible['P'] = true;
		if( isset( $luxe['list_mod_date_u_visible'] ) )		$visible['M'] = true;
		if( isset( $luxe['list_category_meta_u_visible'] ) )	$visible['C'] = true;
		if( isset( $luxe['list_tag_meta_u_visible'] ) )		$visible['T'] = true;
		if( isset( $luxe['list_tax_meta_u_visible'] ) )		$visible['X'] = true;
	}
	else {
		if( isset( $luxe['list_post_date_visible'] ) )		$visible['P'] = true;
		if( isset( $luxe['list_mod_date_visible'] ) )		$visible['M'] = true;
		if( isset( $luxe['list_category_meta_visible'] ) )	$visible['C'] = true;
		if( isset( $luxe['list_tag_meta_visible'] ) )		$visible['T'] = true;
		if( isset( $luxe['list_tax_meta_visible'] ) )		$visible['X'] = true;
	}
}

if( $visible['P'] === true || $visible['M'] === true || $visible['C'] === true || $visible['T'] === true || $visible['X'] === true ) {
	$under = ( isset( $luxe['meta_under'] ) ) ? ' meta-u' : '';
	$metatag = '<p class="meta' . $under . '">';
	$mdfdate  = get_the_modified_date('Ymd');
	$postdate = get_the_date('Ymd');
	$published = '';
	$meta = '';

	if( $visible['P'] === true || $visible['M'] === true ) {
		$far = 'far ';
		$fa_clock  = 'fa-clock';
		$fa_repeat = 'fa-redo-alt';
		$fa_calen  = 'fa-calendar-alt';

		if( $awesome === 4 ) {
			$far = 'fa ';
			$fa_clock  = 'fa-clock-o';
			$fa_repeat = 'fa-repeat';
			$fa_calen  = 'fa-calendar';
		}

		if( $_is_singular === true ) {
			$meta .= '<i class="' . $far . $fa_clock . '"></i>';
			$published = ' published';
		}
		elseif( isset( $luxe['meta_under'] ) && ( ( $visible['P'] === false && $visible['M'] === false ) || ( $visible['P'] === false && $visible['M'] === true ) ) ) {
			$meta .= '<i class="fa fas ' . $fa_repeat . '"></i>';
		}
		else {
			$meta .= '<i class="' . $far . $fa_calen . '"></i>';
		}

		if( empty( $postdate ) && empty( $mdfdate ) ) {
		}
		elseif( empty( $postdate ) && $visible['M'] === true ) {
			$meta .= sprintf(
				'<span class="date' . $published . '"><time class="entry-date updated" datetime="%1$s" itemprop="dateModified">%2$s</time></span>',
				get_the_modified_date( 'c' ), get_the_modified_date()
			);
		}
		else {
			if( $postdate < $mdfdate ) {
				if( $visible['P'] === true && $visible['M'] === true ) {
					if( $luxe['published'] === 'updated' ) {
						$meta .= sprintf(
							'<span class="date' . $published . '"><meta itemprop="datePublished" content="%1$s" />%2$s</span>' .
							'<i class="fa fas ' . $fa_repeat . '"></i>' .
							'<span class="date"><time class="entry-date updated" datetime="%3$s" itemprop="dateModified">%4$s</time></span>',
							get_the_date( 'c' ), get_the_date(), get_the_modified_date( 'c' ), get_the_modified_date()
						);
					}
					else {
						$meta .= sprintf(
							'<span class="date' . $published . '"><time class="entry-date updated" datetime="%1$s" itemprop="datePublished">%2$s</time></span>' .
							'<i class="fa fas ' . $fa_repeat . '"></i>' .
							'<span class="date"><meta itemprop="dateModified" content="%3$s">%4$s</span>',
							get_the_date( 'c' ), get_the_date(), get_the_modified_date( 'c' ), get_the_modified_date()
						);
					}
				}
				elseif( $visible['P'] === true ) {
					$meta .= sprintf(
						'<span class="date' . $published . '"><time class="entry-date updated" datetime="%1$s" itemprop="datePublished">%2$s</time></span>',
						get_the_date( 'c' ), get_the_date()
					);
				}
				elseif( $visible['M'] === true ) {
					$meta .= sprintf(
						'<span class="date' . $published . '"><time class="entry-date updated" datetime="%1$s" itemprop="dateModified">%2$s</time></span>',
						get_the_modified_date( 'c' ), get_the_modified_date()
					);
				}
			}
			else {
				if( $_is_singular === false && isset( $luxe['meta_under'] ) && isset( $luxe['list_post_date_visible'] ) ) {
					$meta = '';
				}
				else {
					if( $visible['P'] === true || $visible['M'] === true ) {
						$meta .= sprintf(
							'<span class="date' . $published . '"><time class="entry-date updated" datetime="%1$s" itemprop="datePublished">%2$s</time></span>',
							get_the_date( 'c' ), get_the_date()
						);
					}
				}
			}
		}
	}

	if( $visible['C'] === true ) {
		$category = null;
		$cat_array = get_the_category( $wp_query->post->ID );
		if( is_array( $cat_array ) === true ) {
			foreach( $cat_array as $value) {
				$category .= ', <a href="' . get_category_link( $value->cat_ID ) . '">' . esc_html( $value->cat_name ) . '</a>';
			}
			$category = ltrim( $category, ', ' );
		}

		if( !empty( $category ) ) {
			$meta .= '<i class="fa fas fa-folder"></i><span class="category" itemprop="keywords">' . $category . '</span>';
		}
	}

	if( $visible['T'] === true ) {
		$tags = null;
		$tag_array = get_the_tags( $wp_query->post->ID );
		if( is_array( $tag_array ) === true ) {
			foreach( $tag_array as $value ) {
				$tags .= ', <a href="' . get_tag_link( $value->term_id ) . '">' . esc_html( $value->name ) . '</a>';
			}
			$tags = ltrim( $tags, ', ' );
		}

		if( !empty( $tags ) ) {
			$meta .= '<i class="fa fas fa-tags"></i><span class="tags" itemprop="keywords">' . $tags . '</span>';
		}
	}

	if( $visible['X'] === true ) {
		$taxs = null;
		$tax_names = array();
		$taxonomy_array = array();

		$taxonomies = get_taxonomies();

		foreach( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( $wp_query->post->ID, $taxonomy );
			foreach ( (array)$terms as $tax ) {
				if( isset( $tax->taxonomy ) ) {
					$tax_names[] = $tax->taxonomy;
				}
			}
		}

		foreach( (array)array_unique( $tax_names ) as $value ) {
			$taxonomy_array += get_the_terms( $wp_query->post->ID, $value );
		}

		foreach( (array)$taxonomy_array as $value ) {
			$taxs .= ', <a href="' . get_term_link( $value->term_id ) . '">' . esc_html( $value->name ) . '</a>';
		}

		$taxs = ltrim( $taxs, ', ' );

		if( !empty( $taxs ) ) {
			$meta .= '<i class="fa fas fa-tag"></i><span class="taxs">' . $taxs . '</span>';
		}
	}

	if( !empty( $meta ) ) {
		echo $metatag, $meta, '</p>';
	}
}
