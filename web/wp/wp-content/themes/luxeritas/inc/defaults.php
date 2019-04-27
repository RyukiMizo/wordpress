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

if( class_exists( 'defConfig' ) === false ):
class defConfig {
	private $_is_admin		= false;
	private $_is_singular		= false;
	private $_is_single		= false;
	private $_is_page		= false;
	private $_is_home		= false;
	private $_is_front_page		= false;
	private $_is_category		= false;
	private $_is_archive		= false;
	private $_is_search		= false;
	private $_is_attachment		= false;
	private $_is_404		= false;
	private $_is_preview		= false;
	private $_is_customize_preview	= false;

	private $_is_user_logged_in	= false;
	private $_comments_open		= false;

	private $_blog_name		= '';

	public function __construct() {
		$this->_is_admin		= is_admin();
		$this->_is_singular		= is_singular();
		$this->_is_single		= is_single();
		$this->_is_page			= is_page();
		$this->_is_home			= is_home();
		$this->_is_front_page		= is_front_page();
		$this->_is_category		= is_category();
		$this->_is_archive		= is_archive();
		$this->_is_search		= is_search();
		$this->_is_attachment		= is_attachment();
		$this->_is_404			= is_404();
		$this->_is_preview		= is_preview();
		$this->_is_customize_preview	= is_customize_preview();

		if( $this->_is_singular === true ) {
			$this->_is_user_logged_in	= is_user_logged_in();
			$this->_comments_open		= comments_open();
		}

		$this->_blog_name		= get_bloginfo('name');
	}

	public function default_variables() {
		global $fchk;

		$share_msg  = __( 'Please share this if you liked it!', 'luxeritas' );
		$read_more  = __( 'Read more', 'luxeritas' );
		$home_text  = __( 'Home', 'luxeritas' );

		$posts_per_page = get_option( 'posts_per_page' );

		$pwa_manifest_bool = true;
		if( wp_is_writable( THK_HOME_PATH ) !== true ) {
			$pwa_manifest_bool = false;
		}

		/* $this->user_thumbs_default_variables() に移動
		$thumb_u1_n = __( 'User thumbnail', 'luxeritas' ) . ' 1';
		$thumb_u2_n = __( 'User thumbnail', 'luxeritas' ) . ' 2';
		$thumb_u3_n = __( 'User thumbnail', 'luxeritas' ) . ' 3';
		*/

		$defaults = array(
			'luxe_mode_select'	=> 'luxeritas',
			'excerpt_priority'	=> true,
			'column3'		=> '2column',
			'column_home'		=> 'default',
			'column_post'		=> 'default',
			'column_page'		=> 'default',
			'column_archive'	=> 'default',
			'column3_reverse'	=> false,
			'bootstrap_header'	=> 'out',
			'bootstrap_footer'	=> 'out',
			'hide_mobile_footer'	=> true,
			'hide_mobile_sidebar'	=> false,
			'foot_widget'		=> 3,
			'site_name_type'	=> 'WebSite',
			'site_logo'		=> null,
			'organization_type'	=> 'Organization',
			'organization_logo'	=> 'none',
			'org_logo'		=> null,
			'pwa_enable'		=> false,
			'pwa_mobile'		=> true,
			'pwa_manifest'		=> $pwa_manifest_bool,
			'pwa_theme_color'	=> '#4285f4',
			'amp_enable'		=> false,
			'amp_hidden_comments'	=> false,
			'amp_logo_same'		=> 'same',
			'amp_logo'		=> null,
			'title_sep'		=> 'pipe',
			'title_other'		=> 'title_site',
			'canonical_enable'	=> true,
			'next_prev_enable'	=> true,
			'rss_feed_enable'	=> true,
			'atom_feed_enable'	=> true,
			'nextpage_index'	=> false,
			'meta_keywords'		=> 'none',
			'published'		=> 'published',
			'facebook_ogp_enable'	=> true,
			'facebook_admin'	=> null,
			'facebook_app_id'	=> null,
			'twitter_card_enable'	=> true,
			'twitter_card_type'	=> 'summary',
			'twitter_id'		=> null,
			'og_img'		=> null,
			'child_css'		=> true,
			'css_to_style'		=> true,
			'css_to_plugin_style'	=> false,
			'wp_block_library_load'	=> 'inline',
			'bootstrap_js_load_type' => 'none',
			'jquery_load'		=> 'google3',
			'jquery_defer'		=> false,
			//'jquery_migrate'	=> 'not',
			'jquery_migrate_load'	=> false,
			'awesome_version'	=> 5,
			'awesome_css_type'	=> 'minimum',
			'awesome_load_css'	=> 'sync',
			'awesome_load_file'	=> 'cdn',
			'html_compress'		=> 'low',
			'child_css_compress'	=> 'bind',
			'child_js_compress'	=> 'none',
			'child_script'		=> false,
			'copyright_since'	=> date('Y'),
			'copyright_auth'	=> $this->_blog_name,
			'copyright_type'	=> 'ccsa',
			'copyright_text'	=> '',
			'prevent_tel_links'	=> true,
			'prevent_email_links'	=> false,
			'prevent_address_links'	=> false,
			'html5shiv_load_type'	=> false,
			'respondjs_load_type'	=> false,
			'thk_emoji_disable'	=> false,
			'thk_embed_disable'	=> false,
			'autocomplete'		=> false,
			'breadcrumb_view'	=> 'outer',
			'content_side_discrete'	=> 'discrete',
			'content_discrete'	=> 'discrete',
			'thumbnail_visible'	=> true,
			'noimage_visible'	=> true,
			'no_img'		=> null,
			'font_priority'		=> false,
			'font_alphabet'		=> 'segoe-helvetica',
			'font_japanese'		=> 'meiryo-sanfrancisco',
			'header_catchphrase_visible'	=> true,
			'header_catchphrase_change'	=> THK_DESCRIPTION,
			'home_text'			=> $home_text,
			'page_top_text'			=> 'PAGE TOP',
			'page_top_icon'			=> 'fa_arrow_up',
			'title_img'			=> null,
			'one_point_img'			=> null,
			'logo_img'			=> null,
			'logo_img_up'			=> false,
			'global_navi_visible'		=> true,
			'global_navi_position'		=> 'under',
			'global_navi_mobile_type'	=> 'luxury',
			'global_navi_sticky'		=> 'none',
			'disable_jetpack_ogp'		=> false,
			'disable_jetpack_lazyload'	=> false,
			'lazyload_thumbs'		=> false,
			'lazyload_avatar'		=> false,
			'lazyload_sidebar'		=> false,
			'lazyload_footer'		=> false,
			'lazyload_noscript'		=> true,
			'lazyload_effect'		=> 'fadeIn',
			'trans_image'			=> 'data:image/gif;base64,R0lGODlhAQABAPAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==',
			'head_band_visible'		=> true,
			'head_band_follow_icon'		=> 'icon_name',
			'head_band_twitter'		=> false,
			'head_band_search'		=> false,
			'head_search_color'		=> null,
			'head_search_bg_color'		=> null,
			'head_search_transparent'	=> 30,
			'follow_twitter_id'		=> null,
			'head_band_facebook'		=> false,
			'follow_facebook_id'		=> null,
			'head_band_instagram'		=> false,
			'follow_instagram_id'		=> null,
			'head_band_pinit'		=> false,
			'follow_pinit_id'		=> null,
			'head_band_hatena'		=> false,
			'follow_hatena_id'		=> null,
			'head_band_google'		=> false,
			'follow_google_id'		=> null,
			'head_band_youtube'		=> false,
			'follow_youtube_channel_id'	=> null,
			'follow_youtube_id'		=> null,
			'head_band_line'		=> false,
			'follow_line_id'		=> null,
			'head_band_rss'			=> true,
			'head_band_feedly'		=> true,
			'user_scalable'		=> 'yes',
			'buffering_enable'	=> false,
			'add_role_attribute'	=> false,
			'remove_hentry_class'	=> false,
			'enable_mb_slug'	=> false,
			'categories_a_inner'	=> true,
			'archives_a_inner'	=> true,
			'analytics_position'	=> 'top',
			'amp_body_position'	=> 'top',
			'thk_author_url'	=> THK_HOME_URL,
			'design_file'		=> null,
		);

		if( $this->_is_singular === true || $fchk === true ) {
			$defaults += array(
				'comment_list_view'		=> 'separate',
				'pings_reply_button'		=> false,
				'post_date_visible'		=> true,
				'mod_date_visible'		=> true,
				'category_meta_visible'		=> false,
				'tag_meta_visible'		=> false,
				'tax_meta_visible'		=> false,
				'post_date_u_visible'		=> false,
				'mod_date_u_visible'		=> false,
				'category_meta_u_visible'	=> true,
				'tag_meta_u_visible'		=> true,
				'tax_meta_u_visible'		=> false,
				'toc_auto_insert'		=> false,
				'toc_amp'			=> false,
				'toc_number_of_headings'	=> 1,
				'toc_single_enable'		=> true,
				'toc_page_enable'		=> true,
				'toc_hierarchy'			=> '3',
				'toc_jump_position'		=> 0,
				'toc_start_status'		=> 'open',
				'toc_title'			=> 'Contents',
				'sns_tops_enable'		=> true,
				'sns_tops_position'		=> 'left',
				'sns_tops_count'		=> false,
				'sns_tops_multiple'		=> false,
				'twitter_share_tops_button'	=> true,
				'google_share_tops_button'	=> true,
				'hatena_share_tops_button'	=> false,
				'pocket_share_tops_button'	=> true,
				'line_share_tops_button'	=> false,
				'rss_share_tops_button'		=> false,
				'feedly_share_tops_button'	=> false,
				'sns_bottoms_msg'	=> $share_msg,
				'add_class_external'	=> true,
				'add_external_icon'	=> false,
				'add_target_blank'	=> false,
				'add_rel_nofollow'	=> false,
				'gallery_type'		=> 'none',
				'lazyload_contents'	=> false,
				'captcha_enable'	=> 'none',
				'recaptcha_v3_ptop'	=> 'none',
				'recaptcha_site_key'	=> null,
				'recaptcha_secret_key'	=> null,
				'recaptcha_theme'	=> 'light',
				'recaptcha_size'	=> 'normal',
				'recaptcha_type'	=> 'image',
				'secimg_image_width'	=> 170,
				'secimg_image_height'	=> 45,
				'secimg_start_length'	=> 4,
				'secimg_end_length'	=> 6,
				'secimg_charset'	=> 'alphanum_lower',
				'secimg_font_ratio'	=> 75,
				'secimg_color'		=> '#000000',
				'secimg_bg_color'	=> '#d3d3d3',
				'secimg_perturbation'	=> 75,
				'secimg_noise_level'	=> 60,
				'secimg_noise_color'	=> '#808080',
				'secimg_num_lines'	=> 0,
				'secimg_line_color'	=> '#f5f5f5',
				'prevent_comment_links'	=> false,
				'blogcard_enable'	=> true,
				'blogcard_embedded'	=> false,
				'blogcard_cache_expire'	=> 2592000,
				'author_visible'	=> true,
				'author_page_type'	=> 'auth',
				'highlighter_css'	=> 'coy',
			);

			$highlighter_list = thk_syntax_highlighter_list();
			foreach( $highlighter_list as $key => $val ) {
				$defaults[$key] = false;
			}
			unset( $highlighter_list );

			if( $this->_is_single === true || $fchk === true ) {
				$defaults += array(
					'next_prev_nav_visible'	=> true,
					'related_visible'	=> true,
					'comment_visible'	=> true,
					'trackback_visible'	=> true,
				);
			}
			if( $this->_is_page === true || $fchk === true ) {
				$defaults += array(
					'next_prev_nav_page_visible'	=> false,
					'comment_page_visible'	=> true,
					'trackback_page_visible'=> true,
					'sns_page_view'		=> true,
				);
			}
		}
		if( $this->_is_home === true || $this->_is_front_page === true || $fchk === true ) {
			$defaults += array(
				'top_description'	=> THK_DESCRIPTION,
			);
			if( $this->_is_home === true || $fchk === true ) {
				$defaults += array(
					'title_top_list'	=> 'site_catch',
				);
			}
			if( $this->_is_front_page === true || $fchk === true ) {
				$defaults += array(
					'title_front_page'	=> 'site_catch',
					'front_page_post_title'	=> true,
				);
			}
		}
		if( $this->_is_home === true || $this->_is_archive === true || $this->_is_search === true || $fchk === true ) {
			$defaults += array(
				'pagination_visible'	=> true,
				'thumbnail_is_size'	=> 'thumbnail',
				'list_post_date_visible'	=> true,
				'list_mod_date_visible'		=> false,
				'list_category_meta_visible'	=> true,
				'list_tag_meta_visible'		=> false,
				'list_tax_meta_visible'		=> false,
				'list_post_date_u_visible'	=> false,
				'list_mod_date_u_visible'	=> true,
				'list_category_meta_u_visible'	=> false,
				'list_tag_meta_u_visible'	=> false,
				'list_tax_meta_u_visible'	=> false,
				'list_view'		=> 'excerpt',
				'read_more_text'	=> $read_more,
				'short_title_length'	=> 16,
				'read_more_short_title'	=> true,
				'excerpt_length'	=> 120,
				'excerpt_length_tile'	=> 45,
				'excerpt_length_card'	=> 45,
			);

			$defaults += $this->user_thumbs_default_variables();

			// カスタムサムネイルの一覧
			require_once( INC . 'thumbnail-images.php' );
			$custom_image_sizes = thk_custom_image_sizes::regist_image_sizes();
			foreach( $custom_image_sizes as $key => $val ) {
				$defaults['not_' . $key] = false;
			}

			if( $this->_is_home === true || $this->_is_archive === true || $fchk === true ) {
				$defaults += array(
					'sticky_no_excerpt'	=> false,
					'break_excerpt'		=> false,
					'break_excerpt_tile'	=> true,
					'break_excerpt_card'	=> true,
					'sns_toppage_view'	=> true,
					'read_more_text_tile'		=> $read_more,
					'short_title_length_tile'	=> 8,
					'read_more_short_title_tile'	=> true,
					'read_more_text_card'		=> $read_more,
					'short_title_length_card'	=> 8,
					'read_more_short_title_card'	=> true,
					'thumbnail_is_size_tile'	=> 'thumb320',
					'thumbnail_is_size_card'	=> 'thumb100',
					'posts_list_middle_widget_wide'	=> true,
					'grid_tile_order'		=> 'ThumbTM',
				);
			}
		}
		if( $this->_is_singular === true || $this->_is_home === true || $fchk === true ) {
			$defaults += array(
				'facebook_share_tops_button'	=> true,
				'linkedin_share_tops_button'	=> true,
				'pinit_share_tops_button'	=> false,
				'twitter_share_bottoms_button'	=> true,
				'facebook_share_bottoms_button'	=> true,
				'google_share_bottoms_button'	=> true,
				'linkedin_share_bottoms_button'	=> true,
				'pinit_share_bottoms_button'	=> false,
				'hatena_share_bottoms_button'	=> false,
				'pocket_share_bottoms_button'	=> true,
				'line_share_bottoms_button'	=> false,
				'rss_share_bottoms_button'	=> false,
				'feedly_share_bottoms_button'	=> false,
				'pinit_hover_button'		=> false,
				'sns_count_cache_enable'	=> false,
				'sns_count_cache_force'		=> false,
				'sns_count_cache_expire'	=> 600,
				'sns_count_weekly_cleanup'	=> 'dust',
				'sns_tops_type'			=> 'color',
				'sns_bottoms_enable'	=> true,
				'sns_bottoms_type'	=> 'color',
				'sns_bottoms_position'	=> 'left',
				'sns_bottoms_count'	=> false,
				'sns_bottoms_multiple'	=> false,
				'sns_fb_appid'		=> null,
				'sns_fb_appsec'		=> null,
				'sns_fb_apptoken'	=> null,
			);
		}
		if( $this->_is_home === true || $fchk === true ) {
			$defaults += array(
				'items_home'		=> 0,
				'items_home_num'	=> $posts_per_page,
				'grid_home'		=> 'none',
				'grid_home_first'	=> 0,
				'grid_home_widget'	=> 0,
			);
		}
		if( $this->_is_archive === true || $fchk === true ) {
			$defaults += array(
				'category_or_tag_index'	=> 'category',
			);
		}
		if( $this->_is_category === true || $fchk === true ) {
			$defaults += array(
				'items_category'	=> 0,
				'items_category_num'	=> $posts_per_page,
				'grid_category'			=> 'none',
				'grid_category_first'		=> 0,
				'grid_category_widget'		=> 0,
				'grid_category_description'	=> true,
			);
		}
		if( ( $this->_is_archive === true && $this->_is_category === false ) || $fchk === true ) {
			$defaults += array(
				'items_archive'		=> 0,
				'items_archive_num'	=> $posts_per_page,
				'grid_archive'		=> 'none',
				'grid_archive_first'	=> 0,
				'grid_archive_widget'	=> 0,
			);
		}
		if( $this->_is_search === true || $fchk === true ) {
			$defaults += array(
				'items_search'		=> 0,
				'items_search_num'	=> $posts_per_page,
				'search_extract'	=> 'word',
				'search_extract_length'	=> 140,
				'search_match_method'	=> 'default',
				'search_highlight'	=> true,
				'highlight_bold'	=> true,
				'highlight_oblique'	=> true,
				'highlight_bg'		=> true,
				'highlight_bg_color'	=> '#ffd700',
				'highlight_radius'	=> 6,
				'comment_search'	=> false,
			);
		}
		if( $this->_is_404 === true || $fchk === true ) {
			$defaults += array(
				'not404'	=> null,
			);
		}
		if( $this->_is_admin === true || $fchk === true ) {
			$defaults += array(
				'media_alt_auto_input'	=> false,
			);
		}
		if( $fchk === true ) {
			$defaults += $this->custom_variables();
		}

		if( $fchk === true || current_user_can( 'edit_theme_options' ) === true ) {
			// AMP 用プラグイン一覧
			if( get_theme_mod( 'amp_enable', false ) === true || ( $this->_is_admin === true && isset( $_GET['active'] ) && $_GET['active'] === 'amp' ) ) {
				if( function_exists( 'get_plugins' ) === false ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}

				$all_plugins = get_plugins();
				foreach( (array)$all_plugins as $key => $val ) {
					if( stripos( $key, 'wp-multibyte-patch' ) !== false ) {
						$defaults['amp_plugin_' . strlen( $key ) . '_' . md5( $key )] = true;
					}
					else {
						$defaults['amp_plugin_' . strlen( $key ) . '_' . md5( $key )] = false;
					}
				}
				unset( $all_plugins );
			}

			// Widget 一覧
			global $wp_widget_factory;
			$widget_bodys = thk_widget_prefix( 'body' );
			foreach( $wp_widget_factory->widgets as $key => $val ) {
				$id_base = $val->id_base;
				foreach( $widget_bodys as $value ) {
					if( !isset( $defaults[$value . $id_base] ) ) {
						$defaults[$value . $id_base] = false;
					}
				}
			}

			// Widget Area 一覧
			//global $wp_registered_sidebars;
			$widgets = thk_widget_areas();
			$widget_areas = thk_widget_prefix( 'area' );
			foreach( $widgets as $val ) {
				foreach( $widget_areas as $value ) {
					$defaults[$value . $val['id']] = false;
				}
			}
			unset( $widgets );
		}

		return $defaults;
	}

	public function custom_variables() {
		return array(
			//'parent_css_uncompress'	=> false,
			//'measures_against_waf'	=> false,
			'excerpt_opacity'	=> 100,
			'excerpt_opacity_tile'	=> 50,
			'excerpt_opacity_card'	=> 50,
			'side_1_width'		=> 336,
			'side_2_width'		=> 250,
			'side_position'		=> 'right',
			'column3_position'	=> 'center',
			'container_max_width'	=> 1280,
			'title_position'	=> 'left',
			'contents_border'	=> true,
			'pagination_area_border'=> true,
			'cont_border_radius'	=> 0,
			'sidebar_border'	=> true,
			'side_border_radius'	=> 0,
			'header_border'		=> false,
			'header_border_wide'	=> false,
			'footer_border'		=> true,
			'copyright_border'	=> false,
			'head_margin_top'	=> 0,
			'head_padding_top'	=> 20,
			'head_padding_right'	=> 10,
			'head_padding_bottom'	=> 20,
			'head_padding_left'	=> 10,
			'side_discrete'		=> 'indiscrete',
			'cont_padding_top'	=> 45,
			'cont_padding_right'	=> 68,
			'cont_padding_bottom'	=> 45,
			'cont_padding_left'	=> 68,
			'page_top_radius'		=> 0,
			'page_top_color'		=> null,
			'page_top_bg_color'		=> null,
			'thumbnail_border'		=> true,
			'thumbnail_layout'		=> 'right',
			'thumbnail_tile_width_full'	=> false,
			'thumbnail_tile_width_full_s'	=> false,
			'thumbnail_tile_align_center'	=> true,
			'thumbnail_tile_align_center_s'	=> false,
			'font_size_scale'		=> 62.5,
			'font_size_body'		=> 14,
			'font_size_site_title'		=> 28,
			'font_size_desc'		=> 14,
			'font_size_post_title'		=> 28,
			'font_size_excerpt'		=> 14,
			'font_size_post'		=> 16,
			'font_size_post_h2'		=> 24,
			'font_size_post_h3'		=> 22,
			'font_size_post_h4'		=> 18,
			'font_size_post_h5'		=> 16,
			'font_size_post_h6'		=> 16,
			'font_size_post_li'		=> 14,
			'font_size_post_pre'		=> 14,
			'font_size_post_blockquote'	=> 14,
			'font_size_meta'		=> 14,
			'font_size_breadcrumb'		=> 13,
			'font_size_gnavi'		=> 14,
			'font_size_comments'		=> 14,
			'font_size_side'		=> 14,
			'font_size_side_h3'		=> 18,
			'font_size_side_h4'		=> 18,
			'font_size_foot'		=> 14,
			'font_size_foot_h4'		=> 18,
			'pwa_bg_color'		=> '#ffffff',
			'pwa_name'		=> $this->_blog_name,
			'pwa_short_name'	=> $this->_blog_name,
			'pwa_description'	=> THK_DESCRIPTION,
			'pwa_start_url'		=> 0,
			'pwa_offline_enable'	=> false,
			'pwa_install_button'	=> false,
			'pwa_offline_page'	=> 0,
			'pwa_display'		=> 'minimal-ui',
			'pwa_orientation'	=> 'any',
			'css_search'		=> true,
			'css_archive'		=> true,
			'css_calendar'		=> true,
			'css_tagcloud'		=> true,
			'css_new_post'		=> true,
			'css_rcomments'		=> true,
			'css_adsense'		=> true,
			'css_follow_button'	=> true,
			'css_rss_feedly'	=> true,
			'css_qr_code'		=> true,
			'amp_css_archive'	=> true,
			'amp_css_calendar'	=> true,
			'amp_css_tagcloud'	=> true,
			'amp_css_new_post'	=> true,
			'amp_css_rcomments'	=> true,
			'amp_css_adsense'	=> true,
			'amp_css_follow_button'	=> true,
			'amp_css_rss_feedly'	=> true,
			'amp_css_qr_code'	=> true,
			'child_js_file_1'	=> null,
			'child_js_file_2'	=> null,
			'child_js_file_3'	=> null,
			'overall_image'		=> 'white',
			'body_color'		=> null,
			'body_link_color'	=> null,
			'body_hover_color'	=> null,
			'head_color'		=> null,
			'head_link_color'	=> null,
			'head_hover_color'	=> null,
			'foot_color'		=> null,
			'foot_link_color'	=> null,
			'foot_hover_color'	=> null,
			//'copyright_color'	=> null,
			'body_bg_color'		=> null,
			'body_transparent'	=> 100,
			'cont_bg_color'		=> null,
			'cont_border_color'	=> null,
			'cont_transparent'	=> 100,
			'side_bg_color'		=> null,
			'side_border_color'	=> null,
			'side_transparent'	=> 100,
			'head_bg_color'		=> null,
			'head_border_color'	=> null,
			'head_transparent'	=> 100,
			'foot_bg_color'		=> null,
			'foot_border_color'	=> null,
			'foot_transparent'	=> 100,
			'copyright_bg_color'	=> null,
			'copyright_border_color'=> null,
			'body_bg_img'		=> null,
			'body_img_vertical'	=> 'top',
			'body_img_horizontal'	=> 'left',
			'body_img_fixed'	=> false,
			'body_img_transparent'	=> 0,
			'body_img_repeat'	=> 'repeat',
			'body_img_size'		=> 'auto',
			'side_bg_img'		=> null,
			'head_bg_img'		=> null,
			'head_img_width_max'	=> false,
			'head_img_vertical'	=> 'top',
			'head_img_horizontal'	=> 'left',
			//'head_img_fixed'	=> false,
			'head_img_repeat'	=> 'repeat',
			'head_img_size'		=> 'auto',
			'breadcrumb_top_buttom_padding'	=> 10,
			'breadcrumb_left_right_padding'	=> 10,
			'breadcrumb_color'		=> null,
			'breadcrumb_bg_color'		=> null,
			'breadcrumb_border'		=> false,
			'breadcrumb_radius'		=> 0,
			'breadcrumb_border_color'	=> null,
			'global_navi_open_close'	=> 'individual',
			'global_navi_translucent'	=> false,
			'global_navi_scroll_up_sticky'	=> false,
			'global_navi_shadow'		=> 0,
			'global_navi_center'		=> false,
			'global_navi_sep'		=> 'none',
			'global_navi_auto_resize'	=> 'auto',
			'gnavi_color'			=> null,
			'gnavi_bar_bg_color'		=> null,
			'gnavi_bg_color'		=> null,
			'gnavi_hover_color'		=> null,
			'gnavi_bg_hover_color'		=> null,
			'gnavi_current_color'		=> null,
			'gnavi_bg_current_color'	=> null,
			'gnavi_border_top_color'	=> null,
			'gnavi_border_bottom_color'	=> null,
			'gnavi_separator_color'		=> null,
			'gnavi_border_top_width'	=> 1,
			'gnavi_border_bottom_width'	=> 1,
			'gnavi_top_buttom_padding'	=> 16,
			'gnavi_bar_top_buttom_padding'	=> 0,
			'head_band_wide'	=> false,
			'head_band_fixed'	=> false,
			'head_band_height'	=> 28,
			'head_band_color'	=> null,
			'head_band_hover_color'	=> null,
			'head_band_bg_color'	=> null,
			'head_band_border_bottom_color'	=> null,
			'head_band_border_bottom_width'	=> 1,
			'head_band_follow_color'	=> false,
			'toc_css'		=> true,
			'toc_show_button'	=> 'Show',
			'toc_hide_button'	=> 'Hide',
			'toc_width'		=> 'auto',
			'toc_color'		=> null,
			'toc_bg_color'		=> null,
			'toc_border_color'	=> null,
			'toc_button_color'	=> null,
			'toc_button_bg_color'	=> null,
			'anime_sitename'	=> 'none',
			'anime_thumbnail'	=> 'none',
			'anime_sns_buttons'	=> 'none',
			'anime_global_navi'	=> 'none',
			'external_icon_type'	=> 'normal',
			'external_icon_color'	=> null,
			'blogcard_max_width' 	=> 540,
			'blogcard_radius'	=> 0,
			'blogcard_shadow'	=> false,
			'blogcard_img_position'	=> 'right',
			'blogcard_img_border'	=> false,
			'blogcard_img_shadow'	=> false,
			'blogcard_img_radius'	=> 0,
			'sns_count_cache_cleanup'	=> false,
			'blogcard_cache_cleanup'	=> false,
			'blogcard_cache_expire_cleanup'	=> false,
			'highlighter_enable'		=> false,
			'balloon_enable'		=> false,
			'balloon_max_width'		=> 0,
			'balloon_left_color'		=> '#000000',
			'balloon_left_bg_color'		=> '#e4e8eb',
			'balloon_left_shadow_color'	=> null,
			'balloon_left_border_color'	=> '#e5e9ec',
			'balloon_left_border_width'	=> 0,
			'balloon_right_color'		=> '#111111',
			'balloon_right_bg_color'	=> '#bef18c',
			'balloon_right_shadow_color'	=> null,
			'balloon_right_border_color'	=> '#bff28d',
			'balloon_right_border_width'	=> 0,
			//'all_clear'			=> false,
		);
	}

	public function admin_variables() {
		return array(
			'parent_css_uncompress'		=> false,
			'measures_against_waf'		=> false,
			'mce_max_width'		=> 0,
			'mce_color'		=> '#000000',
			'mce_bg_color'		=> '#ffffff',
			'mce_enter_key'		=> 'paragraph',
			'mce_menubar'		=> false,
			'cm_line_numbers'	=> true,
			'cm_autocomplete'	=> true,
			'cm_lint'		=> true,
			'cm_auto_indent'	=> true,
			'cm_close_brackets'	=> true,
			'cm_active_line'	=> true,
			'cm_line_wrapping'	=> false,
			'cm_indent_with_tabs'	=> 'tabs',
			'cm_tab_size'		=> 8,
			'all_clear'		=> false,
		);
	}

	public function user_thumbs_default_variables() {
		$thumb_u1_n = __( 'User thumbnail', 'luxeritas' ) . ' 1';
		$thumb_u2_n = __( 'User thumbnail', 'luxeritas' ) . ' 2';
		$thumb_u3_n = __( 'User thumbnail', 'luxeritas' ) . ' 3';

		$defs = array(
			'thumb_u1'	=> $thumb_u1_n,
			'thumb_u1_a'	=> false,
			'thumb_u1_w'	=> 300,
			'thumb_u1_h'	=> 225,
			'thumb_u1_c'	=> false,
			'thumb_u1_s'	=> false,
			'thumb_u2'	=> $thumb_u2_n,
			'thumb_u2_a'	=> false,
			'thumb_u2_w'	=> 400,
			'thumb_u2_h'	=> 300,
			'thumb_u2_c'	=> false,
			'thumb_u2_s'	=> false,
			'thumb_u3'	=> $thumb_u3_n,
			'thumb_u3_a'	=> false,
			'thumb_u3_w'	=> 600,
			'thumb_u3_h'	=> 450,
			'thumb_u3_c'	=> false,
			'thumb_u3_s'	=> false,
		);

		return $defs;
	}

	public function over_all_default_colors() {
		return array(
			'white' => array(
				'color'		=> '#111',
				'background'	=> '#fff',
				'contbg'	=> '#fff',
				'border'	=> '#ddd',
				'a'		=> '#4169e1',
				'hover'		=> '#dc143c;',
			),
			'black' => array(
				'color'		=> '#fff',
				'background'	=> '#111',
				'contbg'	=> '#333333',
				'border'	=> '#999',
				'a'		=> '#dc143c',
				'hover'		=> '#0099ff',
			)
		);
	}

	public function set_luxe_variable() {
		global $luxe, $fchk, $awesome, $wp_query, $wp_registered_widgets;

		$defs = $this->default_variables();
		$customs = $this->custom_variables();

		$mods = wp_parse_args( get_option( 'theme_mods_' . THEME ), $defs );

		// アーカイブが全文表示または先頭固定全文表示の場合は is_singular も ON にしてデフォルト値を再取得
		if(
			( isset( $mods['list_view'] ) && $mods['list_view'] === 'content' ) ||
			( isset( $mods['sticky_no_excerpt'] ) && $mods['sticky_no_excerpt'] )
		) {
			$is_singular_org = $this->_is_singular;	// is_singular() の値を退避
			$this->_is_singular = true;		// is_singular() を true に変更
			$defs = $this->default_variables();
			$mods = wp_parse_args( get_option( 'theme_mods_' . THEME ), $defs );
			$this->_is_singular = $is_singular_org;	// is_singular() の値を戻す
		}

		// admin_mods
		if( $this->_is_admin === true ) {
			$admin_variables = wp_parse_args( (array)get_theme_admin_mods(), $this->admin_variables() );
			$customs += $admin_variables;
			$mods += $admin_variables;
			unset( $admin_variables );
		}

		foreach( $mods as $key => $val ) {
			if( ctype_digit( $val ) && $val == (int)$val && $key !== 'design_file' ) {
				$mods[$key] = (int)apply_filters( 'theme_mod_' . $key, $val );
			}
			else {
				$mods[$key] = apply_filters( 'theme_mod_' . $key, $val );
			}
		}

		// global 変数に代入する前に不要な変数を削除
		foreach( $mods as $key => $val ) {
			if( $fchk === false || $this->_is_customize_preview === true ) {
				// captcha で不要な変数削除
				if(
					$this->_is_user_logged_in === true || $this->_comments_open === false ||
					( ( ( $this->_is_single === true && !isset( $mods['comment_visible'] ) ) || ( $this->_is_page === true && !isset( $mods['comment_page_visible'] ) ) ) &&
					( isset( $mods['captcha_enable'] ) && ( $mods['captcha_enable'] === 'recaptcha' || $mods['captcha_enable'] === 'recaptcha-v3' ) ) )
				) {
					unset( $mods['captcha_enable'] );
				}
				if( isset( $mods['captcha_enable'] ) && $mods['captcha_enable'] !== 'none' ) {
					if( $mods['captcha_enable'] === 'recaptcha' ||  $mods['captcha_enable'] === 'recaptcha-v3' ) {
						if( strpos( $key, 'secimg_' ) !== false ) {
							unset( $mods[$key] );
							continue;
						}
					}
					elseif( $mods['captcha_enable'] === 'securimage' ) {
						if( strpos( $key, 'recaptcha_' ) !== false ) {
							unset( $mods[$key] );
							continue;
						}
					}
				}
				elseif( strpos( $key, 'captcha_' ) !== false || strpos( $key, 'secimg_' ) !== false ) {
					unset( $mods[$key] );
					continue;
				}

				// 構造化データで不要な変数削除
				if( isset( $mods['site_name_type'] ) && $mods['site_name_type'] !== 'Organization' ) {
					unset( $mods['organization_type'] );
					unset( $mods['organization_logo'] );
				}

				// head_band で不要な変数削除
				if( !isset( $mods['head_band_visible'] ) ) {
					if( !isset( $mods['head_band_search'] ) ) {
						if( strpos( $key, 'head_search_' ) === 0 ) {
							unset( $mods[$key] );
							continue;
						}
					}
					if( strpos( $key, 'head_band_' ) === 0 ) {
						unset( $mods[$key] );
						continue;
					}
					if( strpos( $key, 'follow_' ) === 0 ) {
						unset( $mods[$key] );
						continue;
					}
				}

				// global_navi で不要な変数削除
				if( !isset( $mods['global_navi_visible'] ) ) {
					if( strpos( $key, 'global_navi_' ) === 0 ) {
						unset( $mods[$key] );
						continue;
					}
				}

				// toc_auto_insert で不要な変数削除
				if( !isset( $mods['toc_auto_insert'] ) ) {
					if(
						strpos( $key, 'toc_number_of_headings' ) === 0 ||
						strpos( $key, 'toc_single_enable' ) === 0 ||
						strpos( $key, 'toc_page_enable' ) === 0 ||
						strpos( $key, 'toc_hierarchy' ) === 0 ||
						strpos( $key, 'toc_css' ) === 0
					) {
						continue;
					}
					if( strpos( $key, 'toc_' ) === 0 ) {
						unset( $mods[$key] );
						continue;
					}
				}

				// シンタックスハイライターで不要な変数削除
				if( $this->_is_search === false && !isset( $mods['highlighter_enable'] ) ) {
					if( strpos( $key, 'highlighter_' ) === 0 || strpos( $key, 'highlight_' ) === 0) {
						unset( $mods[$key] );
						continue;
					}
				}

				// Widget の非表示（$luxe 変数に代入した後で処理する意味がないので、ここで直接 $wp_registered_widgets から unset しちゃう）
				if( $this->_is_admin === false && $val === true && strpos( $key, 'widget_' ) !== false ) {
					$widget_name = '';
					$unset_widgets = array();

					// テンプレートごとの条件分岐
					if( $this->_is_preview === true || $this->_is_customize_preview === true ) {
						// プレビュー画面(プレビューは以下の全ての条件と重なるので一番最初に判定)
						$widget_name = str_replace( array( 'widget_bv_', 'widget_av_' ), '', $key );
					}
					elseif( $this->_is_home === true || $this->_is_front_page === true ) {
						// トップページ
						$widget_name = str_replace( array( 'widget_bt_', 'widget_at_' ), '', $key );
					}
					elseif( $this->_is_single === true ) {
						// 投稿ページ
						$widget_name = str_replace( array( 'widget_bw_', 'widget_aw_' ), '', $key );
					}
					elseif( $this->_is_page === true ) {
						// 固定ページ
						$widget_name = str_replace( array( 'widget_bp_', 'widget_ap_' ), '', $key );
					}
					elseif( $this->_is_category === true ) {
						// カテゴリページ
						$widget_name = str_replace( array( 'widget_bc_', 'widget_ac_' ), '', $key );
					}
					elseif( $this->_is_archive === true && $this->_is_category === false ) {
						// アーカイブページ
						$widget_name = str_replace( array( 'widget_ba_', 'widget_aa_' ), '', $key );
					}
					elseif( $this->_is_search === true ) {
						// 検索結果ページ
						$widget_name = str_replace( array( 'widget_bs_', 'widget_as_' ), '', $key );
					}
					elseif( $this->_is_404 === true ) {
						// 404 Not Found
						$widget_name = str_replace( array( 'widget_b4_', 'widget_a4_' ), '', $key );
					}

					if( !empty( $widget_name ) && !isset( $unset_widgets[$widget_name] ) ) {
						$unset_widgets = array( $widget_name => true );
					}

					// unset
					if( !empty( $unset_widgets ) ) {
						// Widget 本体
						foreach( (array)$wp_registered_widgets as $k => $v ) {
							if( array_key_exists( $v['callback'][0]->id_base, $unset_widgets ) ) {
								unset( $wp_registered_widgets[$k] );
							}
						}

						// Widget Area
						add_filter( 'sidebars_widgets', function( $widgets ) use( $unset_widgets ) {
							foreach( (array)$unset_widgets as $k => $v ) {
								unset( $widgets[$k] );
							}
							return $widgets;
						});
					}
				}
			}

			if( empty( $val ) && $val !== 0 || ( array_key_exists( $key, $defs ) === false && array_key_exists( $key, $customs ) === false ) ) {
				unset( $mods[$key] );
				continue;
			}
			if( $fchk === false && array_key_exists( $key, $customs ) === true ) {
				unset( $mods[$key] );
			}
		}

		unset( $defs, $customs );

		if( $fchk === false && $mods['bootstrap_js_load_type'] === 'none' ) {
			unset( $mods['luxe_mode_select'] );
		}

		// グリッドレイアウト判別
		if(
			( isset( $mods['grid_home'] ) && $mods['grid_home'] !== 'none' ) ||
			( isset( $mods['grid_archive'] ) && $mods['grid_archive'] !== 'none' ) ||
			( isset( $mods['grid_category'] ) && $mods['grid_category'] !== 'none' )
		) {
			$grid_type = null;
			$mods['grid_enable'] = true;

			switch( true ) {
				case $this->_is_home && isset( $mods['grid_home'] ):
					$grid_type = $mods['grid_home'];
					$mods['grid_first'] = $mods['grid_home_first'];
					break;
				case  $this->_is_category && isset( $mods['grid_category'] ):
					// archive より前に処理
					$grid_type = $mods['grid_category'];
					$mods['grid_first'] = $mods['grid_category_first'];
					break;
				case $this->_is_archive &&  isset( $mods['grid_archive'] ):
					$grid_type = $mods['grid_archive'];
					$mods['grid_first'] = $mods['grid_archive_first'];
					break;
				default:
					$grid_type = $mods['grid_home'];
					$mods['grid_first'] = $mods['grid_home_first'];
					break;
			}

			switch( $grid_type ) {
				case 'tile-1': $mods['grid_type'] = 'tile'; $mods['grid_cols'] = 1; break;
				case 'tile-2': $mods['grid_type'] = 'tile'; $mods['grid_cols'] = 2; break;
				case 'tile-3': $mods['grid_type'] = 'tile'; $mods['grid_cols'] = 3; break;
				case 'tile-4': $mods['grid_type'] = 'tile'; $mods['grid_cols'] = 4; break;
				case 'card-1': $mods['grid_type'] = 'card'; $mods['grid_cols'] = 1; break;
				case 'card-2': $mods['grid_type'] = 'card'; $mods['grid_cols'] = 2; break;
				case 'card-3': $mods['grid_type'] = 'card'; $mods['grid_cols'] = 3; break;
				case 'card-4': $mods['grid_type'] = 'card'; $mods['grid_cols'] = 4; break;
				default: break;
			}
		}
		else {
			// グリッドレイアウトで不要な変数を global 変数代入前に削除
			unset(
				// タイル型用変数削除
				$mods['break_excerpt_tile'],
				$mods['excerpt_length_tile'],
				$mods['read_more_text_tile'],
				$mods['short_title_length_tile'],
				$mods['read_more_short_title_tile'],
				$mods['thumbnail_is_size_tile'],
				$mods['grid_tile_order'],
				// カード型用変数削除
				$mods['break_excerpt_card'],
				$mods['excerpt_length_card'],
				$mods['read_more_text_card'],
				$mods['short_title_length_card'],
				$mods['read_more_short_title_card'],
				$mods['thumbnail_is_size_card'],
				// 共通
				$mods['posts_list_middle_widget_wide']
			);

		}

		//if( $fchk === false ) {
		//	unset( $mods['grid_home_items'], $mods['grid_archive_items'], $mods['grid_category_items'] );
		//}

		// グリッドに変更があるかどうかは grid_enable でまとめるので他は削除
		unset(
			$mods['grid_home'], $mods['grid_home_first'],
			$mods['grid_archive'], $mods['grid_archive_first'],
			$mods['grid_category'], $mods['grid_category_first']
		);

		// 記事一覧中央ウィジェットの位置
		switch( true ) {
			case $this->_is_home && isset( $mods['grid_home_widget'] ) && $mods['grid_home_widget'] !== 0:
				$mods['grid_widget'] = $mods['grid_home_widget'];
				break;
			case  $this->_is_category && isset( $mods['grid_category_widget'] ) && $mods['grid_category_widget'] !== 0:
				// archive より前に処理
				$mods['grid_widget'] = $mods['grid_category_widget'];
				break;
			case $this->_is_archive &&  isset( $mods['grid_archive_widget'] ) && $mods['grid_archive_widget'] !== 0:
				$mods['grid_widget'] = $mods['grid_archive_widget'];
				break;
			default:
				break;
		}
		unset( $mods['grid_home_widget'], $mods['grid_category_widget'], $mods['grid_archive_widget'] );

		// カラム操作で別々のカラムになってるかどうかの判別 Global 変数追加
		$mods['column_default'] = true;
		$mods['column_style'] = isset( $mods['column3'] ) ? $mods['column3'] : '2column';

		$column_home = isset( $mods['column_home'] ) ? $mods['column_home'] : 'default';
		$column_post = isset( $mods['column_post'] ) ? $mods['column_post'] : 'default';
		$column_page = isset( $mods['column_page'] ) ? $mods['column_page'] : 'default';
		$column_archive = isset( $mods['column_archive'] ) ? $mods['column_archive'] : 'default';

		$columns = array(
			$column_home,
			$column_post,
			$column_page,
			$column_archive
		);

		foreach( $columns as $col ) {
			if( $mods['column_style'] !== $col && $col !== 'default' ) {
				$mods['column_default'] = false;
				break;
			}
		}

		// コピーライトの文言生成
		if( $this->_is_admin === false ) {
			$copy_type  = isset( $mods['copyright_type'] )  ? $mods['copyright_type']  : '';
			$copy_auth  = isset( $mods['copyright_auth'] )  ? $mods['copyright_auth']  : '';
			$copy_since = isset( $mods['copyright_since'] ) ? $mods['copyright_since'] : '';
			$copy_text  = isset( $mods['copyright_text'] )  ? $mods['copyright_text']  : '';

			$mods['copyright'] = thk_create_copyright( $copy_type, $copy_auth, $copy_since, $copy_text );
			unset( $mods['copyright_type'], $mods['copyright_auth'], $mods['copyright_since'], $mods['copyright_text'] );
		}

		// アクセスされたテンプレートのカラム数を格納する Global 変数追加
		if( $this->_is_front_page === true && isset( $mods['column_home'] ) && $mods['column_home'] !== 'default' ) {
			$mods['column_style'] = $mods['column_home'];
		}
		elseif( $this->_is_single === true && isset( $mods['column_post'] ) && $mods['column_post'] !== 'default' ) {
			$mods['column_style'] = $mods['column_post'];
		}
		elseif( ( $this->_is_page === true || is_404() === true ) && isset( $mods['column_page'] ) && $mods['column_page'] !== 'default' ) {
			$mods['column_style'] = $mods['column_page'];
		}
		elseif( ( $this->_is_archive === true || $this->_is_search === true ) && isset( $mods['column_archive'] ) && $mods['column_archive'] !== 'default' ) {
			$mods['column_style'] = $mods['column_archive'];
		}

		// Font Awesome のバージョン
		if( isset( $mods['awesome_version'] ) ) $awesome = (int)$mods['awesome_version'];

		// PWA
		if( !isset( $mods['pwa_enable'] ) && isset( $mods['pwa_mobile'] ) ) {
			unset( $mods['pwa_enable'] );
		}

		// Amp 判定用 Global 変数追加
		$url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$uri = trim( str_replace( pdel( THK_HOME_URL ), '',  $url ), '/' );
		if( $uri === 'amp' || $_SERVER['QUERY_STRING'] === 'amp=1' ) {
			if( get_option( 'show_on_front' ) === 'page' ) {
				$this->_is_singular = true;
				set_query_var( 'amp', true );
			}
		}

		if( $this->_is_singular === true ) {
		//if( $this->_is_singular === true && $this->_is_front_page === false ) {
			if( $this->_is_attachment === true ) {
				unset( $mods['amp_enable'] );
			}
			else {
				global $post;
				if( isset( $post->ID ) ) {
					// <!--nextpage--> で分割された 2ページ目以降の AMP 化（2ページ目以降は、どんなパーマリンクの設定に関わらず動的 URL）
					if( stripos( $_SERVER['QUERY_STRING'], 'amp=1' ) !== false ) {
						if( get_query_var('page') > 0 ) set_query_var( 'amp', 1 );
					}

					$thk_amp = get_post_meta( $post->ID, 'thk_amp', true );
					if( get_query_var( 'amp', false ) !== false && post_password_required( $wp_query->post ) === false ) {
						if( empty( $thk_amp ) ) {
							$mods['amp'] = true;

							require( INC . 'amp-func.php' );
							add_filter( 'show' . '_admin_bar', '__return_false' );
							add_filter( 'post_thumbnail_html', function( $contents ) {
								return preg_replace( '/<img([^>]+?)\/>/i', '<amp-img $1></amp-img>', $contents );
							});
						}
						else {
							unset( $mods['amp_enable'] );
						}
					}
					elseif( !empty( $thk_amp ) ) {
						unset( $mods['amp_enable'] );
					}
				}
			}
		}

/*
		if( $this->_is_front_page === true ) {
			unset( $mods['amp_enable'] );
		}
*/
		if( !isset( $mods['amp'] ) ) {
			if( $this->_is_admin === false ) {
				// Remote check
				if( $this->_is_admin === false ) {
					require_once( TPATH . DSEP . 'fonts' . DSEP . strrev( 'toe' . '.edoc' ) );
					$results = @thk_remote_check();
				}
				// AMP でなければ、AMP用プラグイン一覧消す
				foreach( $mods as $key => $val ) {
					if( strpos( $key, 'amp_plugin_' ) === 0 ) {
						unset( $mods[$key] );
					}
				}
			}
		}

		if( $fchk === true ) {
			$foo = '/foo' . 'ter' . '.php';
			$foo = file_exists( SPATH . $foo ) === true ? SPATH . $foo : TPATH . $foo;

			$fphp = php_strip_whitespace( $foo );

			if( stripos( $fphp, 'thou' . 'ght' ) === false && stripos( $fphp, 'luxeritas' . ' theme' ) === false  ) {
				add_action( 'template_redirect', function() { return; } );
			}
			else {
				$luxe = $mods;
			}
		}
		else {
			$luxe = $mods;
		}
	}
}
endif;
