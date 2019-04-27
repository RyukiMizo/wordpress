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

if( class_exists( 'Appearance' ) === false ):
class Appearance {
	public function __construct() {
	}

	public static $appearance = array(
		'container_max_width'		=> true,
		'overall_image'			=> true,
		'list_view'			=> true,
		'sticky_no_excerpt'		=> true,
		'pagination_visible'		=> true,
		'related_visible'		=> true,
		'next_prev_nav_visible'		=> true,
		'next_prev_nav_page_visible'	=> true,
		'front_page_post_title'		=> true,
		'grid_home'			=> true,
		'grid_home_first'		=> true,
		'grid_home_widget'		=> true,
		'grid_category'			=> true,
		'grid_category_first'		=> true,
		'grid_category_widget'		=> true,
		'grid_archive'			=> true,
		'grid_archive_first'		=> true,
		'grid_archive_widget'		=> true,
		'posts_list_middle_widget_wide'	=> true,
		'grid_tile_order'		=> true,
		'excerpt_length'		=> true,
		'break_excerpt'			=> true,
		'excerpt_opacity'		=> true,
		'excerpt_length_tile'		=> true,
		'break_excerpt_tile'		=> true,
		'excerpt_opacity_tile'		=> true,
		'excerpt_length_card'		=> true,
		'break_excerpt_card'		=> true,
		'excerpt_opacity_card'		=> true,
		'excerpt_priority'		=> true,
		'read_more_text'		=> true,
		'read_more_short_title'		=> true,
		'short_title_length'		=> true,
		'read_more_text_tile'		=> true,
		'read_more_short_title_tile'	=> true,
		'short_title_length_tile'	=> true,
		'read_more_text_card'		=> true,
		'read_more_short_title_card'	=> true,
		'short_title_length_card'	=> true,
		'column3'			=> true,
		'column_home'			=> true,
		'column_post'			=> true,
		'column_page'			=> true,
		'column_archive'		=> true,
		'side_position'			=> true,
		'column3_position'		=> true,
		'column3_reverse'		=> true,
		'content_discrete'		=> true,
		'side_discrete'			=> true,
		'content_side_discrete'		=> true,
		'title_position'		=> true,
		'head_margin_top'		=> true,
		'head_padding_top'		=> true,
		'head_padding_right'		=> true,
		'head_padding_bottom'		=> true,
		'head_padding_left'		=> true,
		'bootstrap_header'		=> true,
		'header_border'			=> true,
		'header_border_wide'		=> true,
		'bootstrap_footer'		=> true,
		'footer_border'			=> true,
		'copyright_border'		=> true,
		'hide_mobile_footer'		=> true,
		'foot_widget'			=> true,
		'contents_border'		=> true,
		'pagination_area_border'	=> true,
		'cont_border_radius'		=> true,
		'cont_padding_top'		=> true,
		'cont_padding_right'		=> true,
		'cont_padding_bottom'		=> true,
		'cont_padding_left'		=> true,
		'side_1_width'			=> true,
		'side_2_width'			=> true,
		'hide_mobile_sidebar'		=> true,
		'sidebar_border'		=> true,
		'side_border_radius'		=> true,
		'comment_visible'		=> true,
		'trackback_visible'		=> true,
		'comment_page_visible'		=> true,
		'trackback_page_visible'	=> true,
		'comment_list_view'		=> true,
		'pings_reply_button'		=> true,
		'header_catchphrase_change'	=> true,
		'header_catchphrase_visible'	=> true,
		'home_text'			=> true,
		'page_top_text'			=> true,
		'page_top_icon'			=> true,
		'page_top_radius'		=> true,
		'page_top_color'		=> true,
		'page_top_bg_color'		=> true,
		'post_date_visible'		=> true,
		'mod_date_visible'		=> true,
		'category_meta_visible'		=> true,
		'tag_meta_visible'		=> true,
		'tax_meta_visible'		=> true,
		'post_date_u_visible'		=> true,
		'mod_date_u_visible'		=> true,
		'category_meta_u_visible'	=> true,
		'tag_meta_u_visible'		=> true,
		'tax_meta_u_visible'		=> true,
		'list_post_date_visible'	=> true,
		'list_mod_date_visible'		=> true,
		'list_category_meta_visible'	=> true,
		'list_tag_meta_visible'		=> true,
		'list_tax_meta_visible'		=> true,
		'list_post_date_u_visible'	=> true,
		'list_mod_date_u_visible'	=> true,
		'list_category_meta_u_visible'	=> true,
		'list_tag_meta_u_visible'	=> true,
		'list_tax_meta_u_visible'	=> true,
		'thumbnail_visible'		=> true,
		'noimage_visible'		=> true,
		'thumbnail_border'		=> true,
		'thumbnail_layout'		=> true,
		'thumbnail_is_size'		=> true,
		'thumbnail_is_size_tile'	=> true,
		'thumbnail_tile_width_full'	=> true,
		'thumbnail_tile_width_full_s'	=> true,
		'thumbnail_tile_align_center'	=> true,
		'thumbnail_tile_align_center_s'	=> true,
		'thumbnail_is_size_card'	=> true,
		'font_priority'			=> true,
		'font_alphabet'			=> true,
		'font_japanese'			=> true,
		'font_size_scale'		=> true,
		'font_size_body'		=> true,
		'font_size_site_title'		=> true,
		'font_size_desc'		=> true,
		'font_size_excerpt'		=> true,
		'font_size_post'		=> true,
		'font_size_post_title'		=> true,
		'font_size_post_h2'		=> true,
		'font_size_post_h3'		=> true,
		'font_size_post_h4'		=> true,
		'font_size_post_h5'		=> true,
		'font_size_post_h6'		=> true,
		'font_size_post_li'		=> true,
		'font_size_post_pre'		=> true,
		'font_size_post_blockquote'	=> true,
		'font_size_meta'		=> true,
		'font_size_breadcrumb'		=> true,
		'font_size_gnavi'		=> true,
		'font_size_comments'		=> true,
		'font_size_side'		=> true,
		'font_size_side_h3'		=> true,
		'font_size_side_h4'		=> true,
		'font_size_foot'		=> true,
		'font_size_foot_h4'		=> true,
		'body_color'			=> true,
		'body_link_color'		=> true,
		'body_hover_color'		=> true,
		'head_color'			=> true,
		'head_link_color'		=> true,
		'head_hover_color'		=> true,
		'foot_color'			=> true,
		'foot_link_color'		=> true,
		'foot_hover_color'		=> true,
		'body_bg_color'			=> true,
		'body_transparent'		=> true,
		'cont_bg_color'			=> true,
		'cont_border_color'		=> true,
		'cont_transparent'		=> true,
		'side_bg_color'			=> true,
		'side_border_color'		=> true,
		'side_transparent'		=> true,
		'head_bg_color'			=> true,
		'head_border_color'		=> true,
		'head_transparent'		=> true,
		'foot_bg_color'			=> true,
		'foot_border_color'		=> true,
		'foot_transparent'		=> true,
		'copyright_bg_color'		=> true,
		'copyright_border_color'	=> true,
		'breadcrumb_view'		=> true,
		'breadcrumb_top_buttom_padding'	=> true,
		'breadcrumb_left_right_padding'	=> true,
		'breadcrumb_color'		=> true,
		'breadcrumb_bg_color'		=> true,
		'breadcrumb_border'		=> true,
		'breadcrumb_radius'		=> true,
		'breadcrumb_border_color'	=> true,
		'global_navi_visible'		=> true,
		'global_navi_position'		=> true,
		'global_navi_mobile_type'	=> true,
		'global_navi_open_close'	=> true,
		'global_navi_sticky'		=> true,
		'global_navi_shadow'		=> true,
		'global_navi_translucent'	=> true,
		'global_navi_scroll_up_sticky'	=> true,
		'global_navi_auto_resize'	=> true,
		'global_navi_center'		=> true,
		'global_navi_sep'		=> true,
		'gnavi_color'			=> true,
		'gnavi_bar_bg_color'		=> true,
		'gnavi_bg_color'		=> true,
		'gnavi_hover_color'		=> true,
		'gnavi_bg_hover_color'		=> true,
		'gnavi_current_color'		=> true,
		'gnavi_bg_current_color'	=> true,
		'gnavi_border_top_color'	=> true,
		'gnavi_border_bottom_color'	=> true,
		'gnavi_separator_color'		=> true,
		'gnavi_border_top_width'	=> true,
		'gnavi_border_bottom_width'	=> true,
		'gnavi_top_buttom_padding'	=> true,
		'gnavi_bar_top_buttom_padding'	=> true,
		'head_band_visible'		=> true,
		'head_band_wide'		=> true,
		'head_band_fixed'		=> true,
		'head_band_height'		=> true,
		'head_band_color'		=> true,
		'head_band_hover_color'		=> true,
		'head_band_bg_color'		=> true,
		'head_band_border_bottom_color'	=> true,
		'head_band_border_bottom_width'	=> true,
		'head_band_search'		=> true,
		'head_search_color'		=> true,
		'head_search_bg_color'		=> true,
		'head_search_transparent'	=> true,
		'head_band_follow_icon'		=> true,
		'head_band_follow_color'	=> true,
		'head_band_rss'			=> true,
		'head_band_feedly'		=> true,
		'anime_sitename'		=> true,
		'anime_thumbnail'		=> true,
		'anime_sns_buttons'		=> true,
		'anime_global_navi'		=> true,
		'lazyload_contents'		=> true,
		'lazyload_thumbs'		=> true,
		'lazyload_avatar'		=> true,
		'lazyload_sidebar'		=> true,
		'lazyload_footer'		=> true,
		'lazyload_noscript'		=> true,
		'lazyload_effect'		=> true,
		'gallery_type'			=> true,
		'add_class_external'		=> true,
		'add_external_icon'		=> true,
		'external_icon_type'		=> true,
		'external_icon_color'		=> true,
		'add_target_blank'		=> true,
		'add_rel_nofollow'		=> true,
		'author_visible'		=> true,
		'author_page_type'		=> true,
		'blogcard_enable'		=> true,
		'blogcard_embedded'		=> true,
		'blogcard_max_width'		=> true,
		'blogcard_radius'		=> true,
		'blogcard_shadow'		=> true,
		'blogcard_img_position'		=> true,
		'blogcard_img_border'		=> true,
		'blogcard_img_shadow'		=> true,
		'blogcard_img_radius'		=> true,
		'toc_auto_insert'		=> true,
		'toc_amp'			=> true,
		'toc_number_of_headings'	=> true,
		'toc_single_enable'		=> true,
		'toc_page_enable'		=> true,
		'toc_hierarchy'			=> true,
		'toc_jump_position'		=> true,
		'toc_start_status'		=> true,
		'toc_title'			=> true,
		'toc_css'			=> true,
		'toc_show_button'		=> true,
		'toc_hide_button'		=> true,
		'toc_width'			=> true,
		'toc_color'			=> true,
		'toc_bg_color'			=> true,
		'toc_border_color'		=> true,
		'toc_button_color'		=> true,
		'toc_button_bg_color'		=> true,
		'sns_tops_type'			=> true,
		'sns_tops_position'		=> true,
		'sns_tops_enable'		=> true,
		'sns_tops_count'		=> true,
		'sns_tops_multiple'		=> true,
		'sns_bottoms_type'		=> true,
		'sns_bottoms_position'		=> true,
		'sns_bottoms_enable'		=> true,
		'sns_bottoms_count'		=> true,
		'sns_bottoms_multiple'		=> true,
		'sns_bottoms_msg'		=> true,
		'sns_toppage_view'		=> true,
		'sns_page_view'			=> true,
		'twitter_share_tops_button'	=> true,
		'facebook_share_tops_button'	=> true,
		'google_share_tops_button'	=> true,
		'linkedin_share_tops_button'	=> true,
		'hatena_share_tops_button'	=> true,
		'pocket_share_tops_button'	=> true,
		'line_share_tops_button'	=> true,
		'rss_share_tops_button'		=> true,
		'feedly_share_tops_button'	=> true,
		'twitter_share_bottoms_button'	=> true,
		'facebook_share_bottoms_button'	=> true,
		'google_share_bottoms_button'	=> true,
		'linkedin_share_bottoms_button'	=> true,
		'hatena_share_bottoms_button'	=> true,
		'pocket_share_bottoms_button'	=> true,
		'line_share_bottoms_button'	=> true,
		'rss_share_bottoms_button'	=> true,
		'feedly_share_bottoms_button'	=> true,
		// カスタマイズ(その他)
		'categories_a_inner'		=> true,
		'archives_a_inner'		=> true,
	);

	public static function design() {
		$ret = self::$appearance;
		unset(
			$ret['header_catchphrase_change'],
			$ret['head_band_search'],
			$ret['head_band_rss'],
			$ret['head_band_feedly'],
			$ret['global_navi_mobile_type'],
			$ret['global_navi_open_close'],
			$ret['global_navi_sticky'],
			$ret['global_navi_shadow'],
			$ret['global_navi_translucent'],
			$ret['global_navi_scroll_up_sticky'],
			$ret['lazyload_contents'],
			$ret['lazyload_thumbs'],
			$ret['lazyload_avatar'],
			$ret['lazyload_sidebar'],
			$ret['lazyload_footer'],
			$ret['lazyload_noscript'],
			$ret['lazyload_effect'],
			$ret['gallery_type'],
			$ret['add_class_external'],
			$ret['add_external_icon'],
			$ret['external_icon_type'],
			$ret['external_icon_color'],
			$ret['add_target_blank'],
			$ret['add_rel_nofollow'],
			$ret['author_visible'],
			$ret['author_page_type'],
			$ret['blogcard_enable'],
			$ret['blogcard_embedded'],
			$ret['blogcard_max_width'],
			$ret['blogcard_radius'],
			$ret['blogcard_shadow'],
			$ret['blogcard_img_position'],
			$ret['blogcard_img_border'],
			$ret['blogcard_img_shadow'],
			$ret['blogcard_img_radius'],
			$ret['toc_auto_insert'],
			$ret['toc_amp'],
			$ret['toc_number_of_headings'],
			$ret['toc_single_enable'],
			$ret['toc_page_enable'],
			$ret['toc_hierarchy'],
			$ret['toc_start_status'],
			$ret['toc_title'],
			$ret['toc_css'],
			$ret['toc_show_button'],
			$ret['toc_hide_button'],
			$ret['toc_width'],
			$ret['toc_color'],
			$ret['toc_bg_color'],
			$ret['toc_border_color'],
			$ret['toc_button_color'],
			$ret['toc_button_bg_color'],
			$ret['sns_tops_type'],
			$ret['sns_tops_position'],
			$ret['sns_tops_enable'],
			$ret['sns_tops_count'],
			$ret['sns_tops_multiple'],
			$ret['sns_bottoms_type'],
			$ret['sns_bottoms_position'],
			$ret['sns_bottoms_enable'],
			$ret['sns_bottoms_count'],
			$ret['sns_bottoms_multiple'],
			$ret['sns_bottoms_msg'],
			$ret['sns_toppage_view'],
			$ret['sns_page_view'],
			$ret['twitter_share_tops_button'],
			$ret['facebook_share_tops_button'],
			$ret['google_share_tops_button'],
			$ret['linkedin_share_tops_button'],
			$ret['hatena_share_tops_button'],
			$ret['pocket_share_tops_button'],
			$ret['line_share_tops_button'],
			$ret['rss_share_tops_button'],
			$ret['feedly_share_tops_button'],
			$ret['twitter_share_bottoms_button'],
			$ret['facebook_share_bottoms_button'],
			$ret['google_share_bottoms_button'],
			$ret['linkedin_share_bottoms_button'],
			$ret['hatena_share_bottoms_button'],
			$ret['pocket_share_bottoms_button'],
			$ret['line_share_bottoms_button'],
			$ret['rss_share_bottoms_button'],
			$ret['feedly_share_bottoms_button']
		 );
		return  $ret;
	}

	public static $images = array(
		'title_img'	=> true,
		'one_point_img'	=> true,
		'body_bg_img'	=> true,
		'side_bg_img'	=> true,
		'head_bg_img'	=> true,
		'logo_img'	=> true,
		'no_img'	=> true,
	);
}
endif;
