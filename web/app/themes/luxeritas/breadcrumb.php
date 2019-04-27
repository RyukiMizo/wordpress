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

global $luxe, $awesome, $post, $cat;
$_is_single = is_single();

$far = 'far ';
$fa_file = 'fa-file';

if( $awesome === 4 ) {
	$far = 'fa ';
	$fa_file = 'fa-file-o';
}
?>
<div itemprop="breadcrumb">
<ol id="breadcrumb">
<?php
	if( is_front_page() === true ) {
?>
<li><i class="fa fas fa-home"></i><?php echo $luxe['home_text']; ?><i class="arrow">&gt;</i></li>
<?php
	}
	elseif( is_page() === true ) {
		$i = 2;
		$parents = array_reverse( get_post_ancestors( $post->ID ) );
?>
<li><i class="fa fas fa-home"></i><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a><i class="arrow">&gt;</i></li><?php
		if( empty( $parents ) ) {
?>
<li><i class="<?php echo $far, $fa_file; ?>"></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
		}
		else {
			foreach ( $parents as $p_id ){
?>
<li><i class="fa fas fa-folder"></i><a href="<?php echo get_page_link( $p_id );?>"><?php echo get_page( $p_id )->post_title; ?></a><i class="arrow">&gt;</i></li>
<?php
				++$i;
			}
?>
<li><i class="<?php echo $far, $fa_file; ?>"></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
		}
	}
	elseif( is_attachment() === true ) {
?>
<li><i class="fa fas fa-home"></i><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a><i class="arrow">&gt;</i></li><?php
?><li><i class="<?php echo $far, $fa_file; ?>"></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
	}
	elseif( $_is_single === true || is_category() === true ) {
		$cat_obj = $_is_single === true ? get_the_category() : array( get_category( $cat ) );
		if( !empty( $cat_obj ) && is_wp_error( $cat_obj ) === false ) {
			$html = '';
			$html_array = array();
			$pars = get_category( $cat_obj[0]->parent );
?>
<li><i class="fa fas fa-home"></i><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a><i class="arrow">&gt;</i></li><?php

			while( $pars && !is_wp_error( $pars ) && $pars->cat_ID != 0 ) {
				$html_array[] = '<li><i class="fa fas fa-folder"></i><a href="' . get_category_link($pars->cat_ID) . '">' . $pars->name . '</a><i class="arrow">&gt;</i></li>';
				$pars = get_category( $pars->parent );
			}
			if( !empty( $html_array ) ) $html_array = array_reverse( $html_array );

			foreach( (array)$html_array as $val ) {
				$html .= $val;
			}

			$title = '' . $cat_obj[0]->name . '';
			if( is_category() === true ) {
				$title = '<h1>' . $cat_obj[0]->name . '</h1>';
			}
			echo $html,
				'<li><i class="fa fas fa-folder-open"></i><a href="',
				get_category_link($cat_obj[0]->cat_ID), '">', $title, '</a></li>';
		}
		else {
?>
<li><i class="fa fas fa-home"></i><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a><i class="arrow">&gt;</i></li><?php

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
?>
<li><i class="fa fas fa-home"></i><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a><i class="arrow">&gt;</i></li><?php
?><li content="2"><i class="fa fas fa-folder"></i><h1><?php
		if( is_tag() === true ) {
			single_tag_title();
		}
		elseif( is_tax() === true ) {
			single_term_title();
		}
		elseif( is_day() === true ) {
			 echo get_the_date( __( 'F j, Y', 'luxeritas' ) );
		}
		elseif( is_month() === true ) {
			echo get_the_date( __( 'F Y', 'luxeritas' ) );
		}
		elseif( is_year() === true ) {
			echo get_the_date( __( 'Y', 'luxeritas' ) );
		}
		elseif( is_author() === true ) {
			echo esc_html(get_queried_object()->display_name);
		}
		elseif( is_search() === true ) {
			echo sprintf( __( 'Search results of [%s]', 'luxeritas' ), esc_html( $s ) );
		}
		elseif( is_post_type_archive() === true ) {
			echo post_type_archive_title( '', false );
		}
?></h1></li>
<?php
	}
	else {
?><li><i class="fa fas fa-home"></i><a href="<?php echo THK_HOME_URL; ?>"><?php echo $luxe['home_text']; ?></a><i class="arrow">&gt;</i></li>
<?php
		if( is_404() === true ) {
?><li><i class="<?php echo $far, $fa_file; ?>"></i><?php echo __( 'Page not found', 'luxeritas' ); ?></li>
<?php
		}
	}
?>
</ol><!--/breadcrumb-->
</div>
