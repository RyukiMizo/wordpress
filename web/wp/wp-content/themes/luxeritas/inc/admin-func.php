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

/* For debugging
global $wp_actions, $wp_filter, $wp_current_filter;
*/

$luxe_defaults = array();

add_filter( 'jpeg_quality', function( $arg ) { return 100; } );

/*---------------------------------------------------------------------------
 * after_setup_theme
 *---------------------------------------------------------------------------*/
add_action( 'after_setup_theme', function() {
	$referer = wp_get_raw_referer();

	if( stripos( (string)$referer, 'wp-admin/widgets.php' ) !== false ) {
		if( stripos( $_SERVER['REQUEST_URI'], 'wp-admin/admin-ajax.php' ) !== false ) {
			thk_options_modify();
		}
	}

	if( stripos( (string)$referer, 'wp-admin/options-permalink.php' ) !== false ) {
		if( stripos( $_SERVER['REQUEST_URI'], 'options-permalink.php' ) !== false ) {
			require( INC . 'rewrite-rules.php' );
			add_action( 'init', 'thk_add_endpoint', 11 );
		}
	}
	elseif( stripos( (string)$referer, 'wp-admin/upgrade.php' ) !== false ) {
		require( INC . 'rewrite-rules.php' );
		add_action( 'init', 'thk_add_endpoint', 11 );
	}

	// SSL にリダイレクトされてるのに home_url や site_url が https:// になってなかったら管理画面で警告出す
	if( is_ssl() === true ) {
		if( stripos( home_url(), 'https://' ) === false || stripos( site_url(), 'https://' ) === false ) {
			add_action( 'admin_notices', function() {
				echo '<div class="notice notice-warning is-dismissible"><p>', __( 'Address (URL) of &quot;Settings -&gt; General&quot; is not set to SSL (https://). Please check the setting.', 'luxeritas' ), '</p></div>';
			});
		}
	}

	// 子テーマのファイル存在チェック（存在してなかったら親からコピー）
	if( TPATH !== SPATH ) {
		$files = array(
			'add-amp-body.php',
			'add-analytics.php',
			'add-analytics-head.php',
			'add-footer.php',
			'add-header.php',
		);
		foreach( $files as $val ) {
			if( file_exists( SPATH . DSEP . $val ) === false ) {
				@copy( TPATH . DSEP . $val, SPATH . DSEP . $val );
			}
		}
	}

	// ajax 処理
	if( isset( $_POST ) ) {
		// 一括処理系
		if( isset( $_POST['luxe_reget_sns'] ) || isset( $_POST['luxe_regen_thumb'] ) ) {
			require( INC . 'luxe-batch.php' );

			// SNS カウントキャッシュ一括取得処理
			if( isset( $_POST['luxe_reget_sns'] ) ) {
				if( check_ajax_referer( 'luxe_reget_sns', 'luxe_nonce' ) ) {
					luxe_batch::luxe_reget_sns();
				}
			}
			// サムネイル一括再構築処理
			if( isset( $_POST['luxe_regen_thumb'] ) ) {
				if( check_ajax_referer( 'luxe_regen_thumb', 'luxe_nonce' ) ) {
					luxe_batch::luxe_regen_thumb();
				}
			}
		}

		// ショートコード登録時のポップアップ
		if( isset( $_POST['sc_popup_nonce'] ) ) {
			// nonce チェック
			if( wp_verify_nonce( $_POST['sc_popup_nonce'], 'shortcode_popup' ) ) {
				add_action( 'wp_ajax_thk_shortcode_regist', function() {
					$name = trim( esc_attr( stripslashes( $_POST['name'] ) ) );
					$code_file = SPATH . DSEP . 'shortcodes' . DSEP . $name . '.inc';
					require_once( INC . 'optimize.php' );
					global $wp_filesystem;
					$filesystem = new thk_filesystem();
					if( $filesystem->init_filesystem( site_url() ) === false ) return false;
					$codes = $wp_filesystem->get_contents_array( $code_file );
					$len = count( $codes );
					unset( $codes[0],  $codes[1], $codes[$len-1], $codes[$len-2] );
					foreach( (array)$codes as $val ) echo $val;
					exit;
				});
			}
		}

		// TinyMCE set
		if( isset( $_POST['mce_popup_nonce'] ) ) {
			if( wp_verify_nonce( $_POST['mce_popup_nonce'], 'mce_popup' ) ) {
				add_action( 'wp_ajax_thk_mce_settings', function() {
					if( isset( $_POST['mce_menubar'] ) ) {
						if( $_POST['mce_menubar'] === 'true' ) {
							$_POST['mce_menubar'] = true;
						}
						else {
							unset( $_POST['mce_menubar'] );
						}
					}
					thk_customize_result_set( 'mce_color', 'text', 'admin' );
					thk_customize_result_set( 'mce_bg_color', 'text', 'admin' );
					thk_customize_result_set( 'mce_max_width', 'number', 'admin' );
					thk_customize_result_set( 'mce_enter_key', 'radio', 'admin' );
					thk_customize_result_set( 'mce_menubar', 'checkbox', 'admin' );
				});
			}
		}

		// Editor button settings
		if( isset( $_POST['editor_settings_nonce'] ) ) {
			if( wp_verify_nonce( $_POST['editor_settings_nonce'], 'settings_nonce' ) ) {
				/*
				 * Visual Editor
				 */
				add_action( 'wp_ajax_v_editor_settings', function() {
					/*** ビジュアルエディタのボタン 1段目 ***/
					$buttons_1 = array();
					$buttons_default_1 = array();

					// POST で受け取った配列
					foreach( $_POST['buttons_1'] as $val ) {
						$buttons_1[$val] = true;
					}

					// デフォルトの配列
					$v_buttons_default_1 = thk_mce_buttons_1();
					foreach( $v_buttons_default_1 as $key => $val ) {
						$buttons_default_1[$key] = true;
					}

					// デフォルト配列と異なってる時だけ DB に保存 ( DB の無駄を出さないため)
					if( $buttons_1 !== $buttons_default_1 ) {
						set_theme_admin_mod( 'veditor_buttons_1', $buttons_1 );
					}
					else {
						remove_theme_admin_mod( 'veditor_buttons_1' );
					}

					/*** ビジュアルエディタのボタン 2段目 ***/
					$buttons_2 = array();
					$buttons_default_2 = array();

					// POST で受け取った配列
					foreach( $_POST['buttons_2'] as $val ) {
						$buttons_2[$val] = true;
					}

					// デフォルトの配列
					$v_buttons_default_2 = thk_mce_buttons_2();
					foreach( $v_buttons_default_2 as $key => $val ) {
						$buttons_default_2[$key] = true;
					}

					// デフォルト配列と異なってる時だけ DB に保存 ( DB の無駄を出さないため)
					if( $buttons_2 !== $buttons_default_2 ) {
						set_theme_admin_mod( 'veditor_buttons_2', $buttons_2 );
					}
					else {
						remove_theme_admin_mod( 'veditor_buttons_2' );
					}
				});
				add_action( 'wp_ajax_v_editor_restore', function() {
					remove_theme_admin_mod( 'veditor_buttons_1' );
					remove_theme_admin_mod( 'veditor_buttons_2' );
				});

				/*
				 * Text Editor
				 */
				add_action( 'wp_ajax_t_editor_settings', function() {
					$buttons_d = array();
					foreach( $_POST['buttons_d'] as $val ) {
						$buttons_d[$val] = true;
					}
					if( !empty( $buttons_d ) ) {
						set_theme_admin_mod( 'teditor_buttons_d', $buttons_d );
					}
					else {
						remove_theme_admin_mod( 'teditor_buttons_d' );
					}
				});
				add_action( 'wp_ajax_t_editor_restore', function() {
					remove_theme_admin_mod( 'teditor_buttons_d' );
				});
			}
		}
	}

	// WP 4.9 以降で追加された(勝手な推測による)ウィジェットマッピングへの対抗処置
	if( stripos( $_SERVER['REQUEST_URI'], 'wp-admin/themes.php' ) !== false ) {
		$luxe_widget = get_theme_admin_mod( 'thk_sidebars_widgets', null );

		if( isset( $_REQUEST['activated'] ) ) {
			//  他テーマから移行してきた完全なご新規さんの場合の処理 (前テーマのウィジェット配置からマッピング)
			$old_theme = trim( (string)get_option( 'theme_switched' ) );

			if( empty( $old_theme ) && defined( 'WP_DEFAULT_THEME' ) !== false ) {
				$old_theme = WP_DEFAULT_THEME;
			}
			$old_theme_mods = get_option( 'theme_mods_' . $old_theme );

			//  Luxeritas -> 他テーマ -> Luxeritas の場合は何もしない
			if( isset( $old_theme_mods['sidebars_widgets']['data'] ) && empty( $luxe_widget ) ) {
				$luxe_widget = $old_theme_mods['sidebars_widgets']['data'];
				$probabilities = array( 'header' => array(), 'footer' => array(), 'sidebar' => array() );

				if( $old_theme !== 'luxeritas' && $old_theme !== 'luxech' ) {
					foreach( (array)$luxe_widget as $key => $val ) {
						if( $key === 'wp_inactive_widgets' ) {
							continue;
						}
						elseif( stripos( $key, 'header' ) !== false || stripos( $key, 'top' ) !== false ) {
							$probabilities['header'] += $val;
						}
						elseif( stripos( $key, 'footer' ) !== false || stripos( $key, 'bottom' ) !== false ) {
							$probabilities['footer'] += $val;
						}
						else {
							$probabilities['sidebar'] += $val;
						}
						$luxe_widget[$key] = array();
					}

					$luxe_widget['side-h3'] = $probabilities['sidebar'];
					$luxe_widget['head-under'] = $probabilities['header'];
					$luxe_widget['footer-left'] = $probabilities['footer'];
				}

				set_theme_admin_mod( 'thk_sidebars_widgets', $luxe_widget );
			}
		}
		add_action( 'shutdown', function() use( $luxe_widget ) {
			if( !empty( $luxe_widget ) ) {
				update_option( 'sidebars_widgets', $luxe_widget );
			}
		});
	}

	// オプションに変更があったらウィジェットの配置をバックアップ
	add_action( 'updated_option', function() {
		$luxe_widget = get_option( 'sidebars_widgets' );
		set_theme_admin_mod( 'thk_sidebars_widgets', $luxe_widget );
	}, 70 );
});

/*---------------------------------------------------------------------------
 * WordPress 管理画面に「Luxeritas」を追加する
 *---------------------------------------------------------------------------*/
add_action( 'admin_menu', function() {
	get_template_part( 'inc/customize' );

	$customize = new luxe_customize();

	$linefeed = get_locale() === 'ja' ? ' ' : '<br />';

	luxe_menu_page(
		'Luxeritas ' . __( 'Customizer', 'luxeritas' ),
		'Luxeritas',
		'manage_options',
		'luxe',
		array( $customize, 'luxe_custom_form' ),
		'dashicons-layout',
		59
	);
	luxe_submenu_page(
		'luxe',
		'Luxeritas ' . __( 'Customizer', 'luxeritas' ),
		__( 'Customize', 'luxeritas' ),
		'manage_options',
		'luxe',
		array( $customize, 'luxe_custom_form' )
	);
	luxe_submenu_page(
		'luxe',
		'Luxeritas Customize',
		__( 'Customize', 'luxeritas' ) . $linefeed .'(' . __( 'Appearance', 'luxeritas' ) . ')',
		'manage_options',
		'customize.php?return=' . urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) . '&amp;luxe=custom',
		''
	);
	luxe_submenu_page(
		'luxe',
		'Luxeritas ' . __( 'Management features', 'luxeritas' ),
		__( 'Management features', 'luxeritas' ),
		'manage_options',
		'luxe_man',
		array( $customize, 'luxe_custom_form' )
	);
	luxe_submenu_page(
		'luxe',
		'Luxeritas ' . __( 'Registration phrases', 'luxeritas' ),
		__( 'Registration phrases', 'luxeritas' ),
		'manage_options',
		'luxe_code',
		array( $customize, 'luxe_custom_form' )
	);
	luxe_submenu_page(
		'luxe',
		'Design select',
		__( 'Design select', 'luxeritas' ),
		'manage_options',
		'luxe_design',
		array( $customize, 'luxe_custom_form' )
	);
	luxe_submenu_page(
		'luxe',
		__( 'Speed settings', 'luxeritas' ),
		__( 'Speed settings', 'luxeritas' ),
		'manage_options',
		'luxe_fast',
		array( $customize, 'luxe_custom_form' )
	);
	luxe_submenu_page(
		'luxe',
		'SNS ' . __( 'Counter', 'luxeritas' ),
		'SNS ' . __( 'Counter', 'luxeritas' ),
		'manage_options',
		'luxe_sns',
		array( $customize, 'luxe_custom_form' )
	);
	luxe_submenu_page(
		'luxe',
		__( 'Child Theme Editor', 'luxeritas' ),
		__( 'Child Theme Editor', 'luxeritas' ),
		'manage_options',
		'luxe_edit',
		array( $customize, 'luxe_custom_form' )
	);
});

/*---------------------------------------------------------------------------
 * カスタマイズ内容の変更反映
 *---------------------------------------------------------------------------*/
add_action( 'admin_init', function() {
	global $luxe, $luxe_defaults;

	if(
		isset( $_REQUEST['page'] ) && isset( $_POST['_wpnonce'] ) && isset( $_POST['option_page'] ) &&
		( $_GET['page'] === 'luxe' || substr( $_REQUEST['page'], 0, 5 ) === 'luxe_' )
	) {
		if( $_POST['option_page'] === 'sns_get' || isset( $_POST['init_process'] ) ) {
			return true;
		}

		if( TPATH === SPATH ) {
			if( $_REQUEST['page'] === 'luxe_design' || $_REQUEST['page'] === 'luxe_code' || $_REQUEST['page'] === 'luxe_edit' ) {
				add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'The theme selected is not the child theme, but the parent theme', 'luxeritas' ), 'error' );
				return false;
			}
		}

		// options.php を経由してないので、ここで nonce のチェック
		if( check_admin_referer( $_POST['option_page'] . '-options', '_wpnonce' ) ) {
			$conf = new defConfig();
			//$luxe_defaults = $conf->default_variables();
			$luxe_defaults = wp_parse_args( $conf->default_variables(), $conf->custom_variables() );
			$luxe_defaults = wp_parse_args( $conf->admin_variables(), $luxe_defaults );
			$err = false;

			if( $_POST['option_page'] === 'seo' ) {
				// SEO
				thk_customize_result_set( 'canonical_enable', 'checkbox' );
				thk_customize_result_set( 'next_prev_enable', 'checkbox' );
				thk_customize_result_set( 'rss_feed_enable', 'checkbox' );
				thk_customize_result_set( 'atom_feed_enable', 'checkbox' );
				thk_customize_result_set( 'top_description', 'text' );
				thk_customize_result_set( 'site_name_type', 'radio' );
				thk_customize_result_set( 'site_logo', 'text' );
				thk_customize_result_set( 'organization_type', 'select' );
				thk_customize_result_set( 'organization_logo', 'radio' );
				thk_customize_result_set( 'org_logo', 'text' );
				thk_customize_result_set( 'meta_keywords', 'radio' );
				thk_customize_result_set( 'published', 'select' );
				thk_customize_result_set( 'category_or_tag_index', 'radio' );
				thk_customize_result_set( 'nextpage_index', 'checkbox' );
			}
			if( $_POST['option_page'] === 'ogp' ) {
				// OGP
				thk_customize_result_set( 'facebook_ogp_enable', 'checkbox' );
				thk_customize_result_set( 'facebook_admin', 'text' );
				thk_customize_result_set( 'facebook_app_id', 'text' );
				thk_customize_result_set( 'twitter_card_enable', 'checkbox' );
				thk_customize_result_set( 'twitter_card_type', 'select' );
				thk_customize_result_set( 'twitter_id', 'text' );
				thk_customize_result_set( 'og_img', 'text' );
				thk_customize_result_set( 'disable_jetpack_ogp', 'checkbox' );
			}
			elseif( $_POST['option_page'] === 'title' ) {
				// Title
				thk_customize_result_set( 'title_sep', 'radio' );
				thk_customize_result_set( 'title_top_list', 'radio' );
				thk_customize_result_set( 'title_front_page', 'radio' );
				thk_customize_result_set( 'title_other', 'radio' );
			}
			elseif( $_POST['option_page'] === 'pagination' ) {
				// Title
				thk_customize_result_set( 'items_home', 'radio' );
				thk_customize_result_set( 'items_home_num', 'number' );
				thk_customize_result_set( 'items_category', 'radio' );
				thk_customize_result_set( 'items_category_num', 'number' );
				thk_customize_result_set( 'items_archive', 'radio' );
				thk_customize_result_set( 'items_archive_num', 'number' );
				thk_customize_result_set( 'items_search', 'radio' );
				thk_customize_result_set( 'items_search_num', 'number' );
			}
			elseif( $_POST['option_page'] === 'amp' ) {
				// AMP
				thk_customize_result_set( 'amp_enable', 'checkbox' );
				thk_customize_result_set( 'amp_hidden_comments', 'checkbox' );
				if( function_exists( 'get_plugins' ) === false ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}
				$all_plugins = get_plugins();
				foreach( (array)$all_plugins as $key => $val ) {
					//if( is_plugin_active( $key ) === true ) {
						thk_customize_result_set( 'amp_plugin_' . strlen( $key ) . '_' . md5( $key ), 'checkbox' );
					//}
				}
				thk_customize_result_set( 'amp_logo_same', 'radio' );
				thk_customize_result_set( 'amp_logo', 'text' );
			}
			elseif( $_POST['option_page'] === 'pwa' ) {
				// PWA
				thk_customize_result_set( 'pwa_theme_color', 'text' );
				thk_customize_result_set( 'pwa_bg_color', 'text' );
				thk_customize_result_set( 'pwa_manifest', 'checkbox' );
				thk_customize_result_set( 'pwa_enable', 'checkbox' );
				thk_customize_result_set( 'pwa_mobile', 'checkbox' );
				thk_customize_result_set( 'pwa_name', 'text' );
				thk_customize_result_set( 'pwa_short_name', 'text' );
				thk_customize_result_set( 'pwa_description', 'text' );
				thk_customize_result_set( 'pwa_start_url', 'select' );
				thk_customize_result_set( 'pwa_offline_enable', 'checkbox' );
				thk_customize_result_set( 'pwa_install_button', 'checkbox' );
				thk_customize_result_set( 'pwa_offline_page', 'select' );
				thk_customize_result_set( 'pwa_display', 'select' );
				thk_customize_result_set( 'pwa_orientation', 'select' );
			}
			elseif( $_POST['option_page'] === 'optimize' ) {
				// HTML
				thk_customize_result_set( 'html_compress', 'select' );
				thk_customize_result_set( 'child_css_compress', 'select' );
				thk_customize_result_set( 'child_js_compress', 'select' );
				thk_customize_result_set( 'child_js_file_1', 'text' );
				thk_customize_result_set( 'child_js_file_2', 'text' );
				thk_customize_result_set( 'child_js_file_3', 'text' );
			}
			elseif( $_POST['option_page'] === 'style' ) {
				// Mode select
				thk_customize_result_set( 'luxe_mode_select', 'radio' );
				// Inline Style
				thk_customize_result_set( 'css_to_style', 'checkbox' );
				thk_customize_result_set( 'wp_block_library_load', 'select' );
				thk_customize_result_set( 'css_to_plugin_style', 'checkbox' );
				// Child CSS
				thk_customize_result_set( 'child_css', 'checkbox' );
				// Font Awesome
				thk_customize_result_set( 'awesome_load_css', 'select' );
				thk_customize_result_set( 'awesome_version', 'radio' );
				thk_customize_result_set( 'awesome_css_type', 'radio' );
				thk_customize_result_set( 'awesome_load_file', 'radio' );
				// Widget CSS
				$widget_css = array(
					'css_search',
					'css_archive',
					'css_calendar',
					'css_tagcloud',
					'css_new_post',
					'css_rcomments',
					'css_adsense',
					'css_follow_button',
					'css_rss_feedly',
					'css_qr_code',
				);
				$widget_no_amp = array(
					'css_search'	=> true,
				);
				foreach( $widget_css as $val ) {
					thk_customize_result_set( $val, 'checkbox' );
					if( !isset( $widget_no_amp[$val] ) ) {
						thk_customize_result_set( 'amp_' . $val, 'checkbox' );
					}
				}
			}
			elseif( $_POST['option_page'] === 'script' ) {
				// jQuery
				thk_customize_result_set( 'jquery_load', 'select' );
				thk_customize_result_set( 'jquery_migrate_load', 'checkbox' );
				// jQuery defer
				thk_customize_result_set( 'jquery_defer', 'checkbox' );
				// Bootstrap Plugin
				thk_customize_result_set( 'bootstrap_js_load_type', 'select' );
				// Other Javascript
				thk_customize_result_set( 'child_script', 'checkbox' );
				thk_customize_result_set( 'html5shiv_load_type', 'checkbox' );
				thk_customize_result_set( 'respondjs_load_type', 'checkbox' );
				thk_customize_result_set( 'thk_emoji_disable', 'checkbox' );
				thk_customize_result_set( 'thk_embed_disable', 'checkbox' );
			}
			elseif( $_POST['option_page'] === 'search' ) {
				thk_customize_result_set( 'search_extract', 'radio' );
				thk_customize_result_set( 'search_match_method', 'radio' );
				thk_customize_result_set( 'comment_search', 'checkbox' );
				thk_customize_result_set( 'autocomplete', 'checkbox' );
				thk_customize_result_set( 'search_highlight', 'checkbox' );
				thk_customize_result_set( 'highlight_bold', 'checkbox' );
				thk_customize_result_set( 'highlight_oblique', 'checkbox' );
				thk_customize_result_set( 'highlight_bg', 'checkbox' );
				thk_customize_result_set( 'highlight_bg_color', 'text' );
				thk_customize_result_set( 'search_extract_length', 'text' );
				thk_customize_result_set( 'highlight_radius', 'text' );
			}
			elseif( $_POST['option_page'] === 'captcha' ) {
				thk_customize_result_set( 'captcha_enable', 'radio' );
				thk_customize_result_set( 'recaptcha_site_key', 'text' );
				thk_customize_result_set( 'recaptcha_secret_key', 'text' );
				thk_customize_result_set( 'recaptcha_v3_ptop', 'select' );
				thk_customize_result_set( 'recaptcha_theme', 'select' );
				thk_customize_result_set( 'recaptcha_size', 'select' );
				thk_customize_result_set( 'recaptcha_type', 'select' );
				thk_customize_result_set( 'secimg_image_width', 'text' );
				thk_customize_result_set( 'secimg_image_height', 'text' );
				thk_customize_result_set( 'secimg_start_length', 'text' );
				thk_customize_result_set( 'secimg_end_length', 'text' );
				thk_customize_result_set( 'secimg_charset', 'select' );
				thk_customize_result_set( 'secimg_font_ratio', 'range' );
				thk_customize_result_set( 'secimg_color', 'select' );
				thk_customize_result_set( 'secimg_bg_color', 'select' );
				thk_customize_result_set( 'secimg_perturbation', 'range' );
				thk_customize_result_set( 'secimg_noise_level', 'range' );
				thk_customize_result_set( 'secimg_noise_color', 'select' );
				thk_customize_result_set( 'secimg_num_lines', 'text' );
				thk_customize_result_set( 'secimg_line_color', 'select' );
			}
			elseif( $_POST['option_page'] === 'copyright' ) {
				thk_customize_result_set( 'copyright_since', 'text' );
				thk_customize_result_set( 'copyright_auth', 'text' );
				thk_customize_result_set( 'copyright_type', 'radio' );
				thk_customize_result_set( 'copyright_text', 'textarea' );
			}
			elseif( $_POST['option_page'] === 'others' ) {
				thk_customize_result_set( 'not404', 'select' );
				thk_customize_result_set( 'buffering_enable', 'checkbox' );
				thk_customize_result_set( 'add_role_attribute', 'checkbox' );
				thk_customize_result_set( 'remove_hentry_class', 'checkbox' );
				thk_customize_result_set( 'enable_mb_slug', 'checkbox' );
				thk_customize_result_set( 'disable_jetpack_lazyload', 'checkbox' );
				thk_customize_result_set( 'media_alt_auto_input', 'checkbox' );
				thk_customize_result_set( 'prevent_tel_links', 'checkbox' );
				thk_customize_result_set( 'prevent_email_links', 'checkbox' );
				thk_customize_result_set( 'prevent_address_links', 'checkbox' );
				thk_customize_result_set( 'prevent_comment_links', 'checkbox' );
				thk_customize_result_set( 'user_scalable', 'radio' );
				thk_customize_result_set( 'categories_a_inner', 'checkbox' );
				thk_customize_result_set( 'archives_a_inner', 'checkbox' );
				thk_customize_result_set( 'parent_css_uncompress', 'checkbox', 'admin' );
				thk_customize_result_set( 'measures_against_waf', 'checkbox', 'admin' );
			}
			elseif( $_POST['option_page'] === 'thumbnail' ) {
				require_once( INC . 'thumbnail-images.php' );
				$custom_image_sizes = thk_custom_image_sizes::regist_image_sizes();
				foreach( $custom_image_sizes as $key => $val ) {
					// チェックが付いてる方がデフォルトなので checked の結果を反転させる( DB の無駄を無くすため )
					if( !isset( $_POST['not_' . $key] ) ) {
						$_POST['not_' . $key] = true;
					}
					else {
						unset( $_POST['not_' . $key] );
					}
					thk_customize_result_set( 'not_' . $key, 'checkbox' );
				}

				thk_customize_result_set( 'thumb_u1', 'text' );
				thk_customize_result_set( 'thumb_u1_a', 'checkbox' );
				thk_customize_result_set( 'thumb_u1_w', 'number' );
				thk_customize_result_set( 'thumb_u1_h', 'number' );
				thk_customize_result_set( 'thumb_u1_c', 'checkbox' );
				thk_customize_result_set( 'thumb_u1_s', 'checkbox' );

				thk_customize_result_set( 'thumb_u2', 'text' );
				thk_customize_result_set( 'thumb_u2_a', 'checkbox' );
				thk_customize_result_set( 'thumb_u2_w', 'number' );
				thk_customize_result_set( 'thumb_u2_h', 'number' );
				thk_customize_result_set( 'thumb_u2_c', 'checkbox' );
				thk_customize_result_set( 'thumb_u2_s', 'checkbox' );

				thk_customize_result_set( 'thumb_u3', 'text' );
				thk_customize_result_set( 'thumb_u3_a', 'checkbox' );
				thk_customize_result_set( 'thumb_u3_w', 'number' );
				thk_customize_result_set( 'thumb_u3_h', 'number' );
				thk_customize_result_set( 'thumb_u3_c', 'checkbox' );
				thk_customize_result_set( 'thumb_u3_s', 'checkbox' );
			}
			elseif( $_POST['option_page'] === 'widget' ) {
				// Widget
				global $wp_widget_factory;
				$thk_widget = array();
				$widget_bodys = thk_widget_prefix( 'body' );

				foreach( $wp_widget_factory->widgets as $key => $val ) {
					$id_base = $val->id_base;
					if( !isset( $thk_widget[$id_base] ) ) {
						$thk_widget[$id_base] = $val->name;
					}
				}
				foreach( (array)$thk_widget as $key => $val ) {
					foreach( $widget_bodys as $value ) {
						thk_customize_result_set( $value . $key, 'checkbox' );
					}
				}
				// Widget Area
				//global $wp_registered_sidebars;
				$widgets = thk_widget_areas();
				$widget_areas = thk_widget_prefix( 'area' );

				foreach( $widgets as $val ) {
					foreach( $widget_areas as $value ) {
						thk_customize_result_set( $value . $val['id'], 'checkbox' );
					}
				}
				unset( $widgets );
			}
			elseif( $_POST['option_page'] === 'restore' || $_POST['option_page'] === 'restore_appearance' ) {
				require( INC . 'restore.php' );
			}
			elseif( $_POST['option_page'] === 'reset' ) {
				thk_customize_result_set( 'all_clear', 'checkbox', 'admin' );
				thk_customize_result_set( 'sns_count_cache_cleanup', 'checkbox' );
				thk_customize_result_set( 'blogcard_cache_cleanup', 'checkbox' );
				thk_customize_result_set( 'blogcard_cache_expire_cleanup', 'checkbox' );
			}
			elseif( $_POST['option_page'] === 'phrase' || $_POST['option_page'] === 'phrase_options' ) {
				if( $_POST['option_page'] === 'phrase' ) {
					require( INC . 'phrase-regist.php' );
				}
			}
			elseif( $_POST['option_page'] === 'shortcode' || $_POST['option_page'] === 'shortcode_options') {
				if( $_POST['option_page'] === 'shortcode' ) {
					require( INC . 'shortcode-regist.php' );
				}
			}
			elseif( $_POST['option_page'] === 'phrase_sample' || $_POST['option_page'] === 'shortcode_sample' ) {
				if( $_POST['option_page'] === 'phrase_sample' ) {
					require( INC . 'phrase-sample.php' );
				}
				elseif( $_POST['option_page'] === 'shortcode_sample' ) {
					require( INC . 'shortcode-sample.php' );
					thk_customize_result_set( 'highlighter_css', 'select' );
				}
				thk_customize_result_set( 'balloon_enable', 'checkbox' );
				thk_customize_result_set( 'balloon_max_width', 'number' );
				thk_customize_result_set( 'balloon_left_color', 'text' );
				thk_customize_result_set( 'balloon_left_bg_color', 'text' );
				thk_customize_result_set( 'balloon_left_shadow_color', 'text' );
				thk_customize_result_set( 'balloon_left_border_color', 'text' );
				thk_customize_result_set( 'balloon_left_border_width', 'number' );
				thk_customize_result_set( 'balloon_right_color', 'text' );
				thk_customize_result_set( 'balloon_right_bg_color', 'text' );
				thk_customize_result_set( 'balloon_right_shadow_color', 'text' );
				thk_customize_result_set( 'balloon_right_border_color', 'text' );
				thk_customize_result_set( 'balloon_right_border_width', 'number' );
			}
			elseif( $_POST['option_page'] === 'design_upload' ) {
				require( INC . 'design-upload.php' );
			}
			elseif( $_POST['option_page'] === 'design_select' && isset( $_POST['design_select'] ) ) {
				require( INC . 'appearance-settings.php' );
				$appearance_design = Appearance::design();

				if( empty( $_POST['design_select'] ) ) {
					remove_theme_mod( 'design_file' );
					foreach( $appearance_design as $key => $val ) {
						remove_theme_mod( $key );
					}
				}
				else {
					set_theme_mod( 'design_file', (string)$_POST['design_select'] );
					$json_file = SPATH . DSEP . 'design' . DSEP . $_POST['design_select'] . DSEP . 'luxe-appearance.json';

					if( file_exists( $json_file ) === true ) {
						global $wp_filesystem;

						require_once( INC . 'optimize.php' );
						$filesystem = new thk_filesystem();
						if( $filesystem->init_filesystem( site_url() ) === false ) return false;

						$json = $wp_filesystem->get_contents( $json_file );
						$json = (array)@json_decode( $json );
						$json_error = json_error_code_to_msg( json_last_error() );

						foreach( $appearance_design as $key => $val ) {
							remove_theme_mod( $key );
							if( isset( $json[$key] ) ) {
								set_theme_mod( $key, $json[$key] );
							}
						}
					}
					else {
						foreach( $appearance_design as $key => $val ) {
							remove_theme_mod( $key );
						}
					}
				}
			}
			elseif( ( $_POST['option_page'] === 'design_delete' && isset( $_POST['design_delete'] ) ) || ( $_POST['option_page'] === 'design_reset' && isset( $_POST['design_reset'] ) && $_POST['design_reset'] === 'default-template' ) ) {
				global $wp_filesystem;
				require_once( INC . 'optimize.php' );

				$filesystem = new thk_filesystem();
				if( $filesystem->init_filesystem( site_url() ) === false ) return false;

				$del_base = isset( $_POST['design_reset'] ) ? 'default-template' : $_POST['design_delete'];
				$del_dir = SPATH . DSEP . 'design' . DSEP . $del_base . DSEP;

				if( $wp_filesystem->delete( $del_dir, true ) === false ) {
					add_settings_error( 'luxe-custom', $_POST['option_page'], 'An attempt to delete the directory failed.', 'error' );
				}

				if( isset( $_POST['design_reset'] ) && $_POST['design_reset'] === 'default-template' ) {
					$src = TPATH . DSEP . 'default-template';
					$dst = SPATH . DSEP . 'design';

					if( $wp_filesystem->is_dir( $src ) === true && $wp_filesystem->is_dir( $dst ) === true ) {
						$dst .= DSEP . 'default-template';
						if( $result = $wp_filesystem->mkdir( $dst, FS_CHMOD_DIR ) === true ) {
							$result = copy_dir( $src, $dst );
							@copy( $src . DSEP . 'screenshot-en_US.png', $dst . DSEP . 'screenshot.png' );
						}
					}
				}
				else {
					$current_design = get_theme_mod( 'design_file', null );

					if( $current_design === $_POST['design_delete'] ) {
						require( INC . 'appearance-settings.php' );
						$appearance_design = Appearance::design();

						remove_theme_mod( 'design_file' );

						foreach( $appearance_design as $key => $val ) {
							remove_theme_mod( $key );
						}
					}
				}
			}
			elseif( $_POST['option_page'] === 'design_create' ) {
				if( TPATH === SPATH ) {
					add_settings_error( 'luxe-custom', $_POST['option_page'],
						__( 'The theme selected is not the child theme, but the parent theme', 'luxeritas' ) . '<br />' .
						__( 'This feature can only be used when the child theme is selected.', 'luxeritas' ),
					'error' );
				}
				else {
					if( empty( $_POST['design_name'] ) ) {
						add_settings_error( 'luxe-custom', $_POST['option_page'],
							__( 'Filename is not entered.', 'luxeritas' ),
						'error' );

					}
					else {
						if( preg_match( '/^[0-9a-zA-Z-_]+$/', $_POST['design_name'] ) === 1 ) {
							if( class_exists('thk_create_design') === false ) {
								require( INC . 'design-create.php' );
							}
							$create_design = new thk_create_design();
							$create_design->create_design();
						}
						else {
							add_settings_error( 'luxe-custom', $_POST['option_page'],
								__( 'The filename contains characters that can&apos;t be used.', 'luxeritas' ),
							'error' );
						}
					}
				}
				$err = true;
			}
			elseif( $_POST['option_page'] === 'fast' ) {
				thk_customize_result_set( 'html_compress', 'select' );
				thk_customize_result_set( 'child_css_compress', 'select' );
				thk_customize_result_set( 'child_js_compress', 'select' );
				thk_customize_result_set( 'css_to_style', 'checkbox' );
				thk_customize_result_set( 'wp_block_library_load', 'select' );
				thk_customize_result_set( 'jquery_load', 'select' );
				thk_customize_result_set( 'jquery_defer', 'checkbox' );
				thk_customize_result_set( 'buffering_enable', 'checkbox' );
				thk_customize_result_set( 'lazyload_thumbs', 'checkbox' );
				thk_customize_result_set( 'lazyload_contents', 'checkbox' );
				thk_customize_result_set( 'lazyload_sidebar', 'checkbox' );
				thk_customize_result_set( 'lazyload_footer', 'checkbox' );
				thk_customize_result_set( 'lazyload_avatar', 'checkbox' );
				thk_customize_result_set( 'disable_jetpack_lazyload', 'checkbox' );
				thk_customize_result_set( 'sns_count_cache_enable', 'checkbox' );
				thk_customize_result_set( 'sns_count_cache_force', 'checkbox' );
				thk_customize_result_set( 'sns_count_cache_expire', 'select' );
			}
			elseif( $_POST['option_page'] === 'sns_setting' ) {
				thk_customize_result_set( 'sns_count_cache_enable', 'checkbox' );
				thk_customize_result_set( 'sns_count_cache_force', 'checkbox' );
				thk_customize_result_set( 'sns_count_cache_expire', 'select' );
				thk_customize_result_set( 'sns_count_weekly_cleanup', 'select' );
				thk_customize_result_set( 'sns_count_cache_cleanup', 'checkbox' );
			}
			elseif(
				$_POST['option_page'] === 'edit_style'		||
				$_POST['option_page'] === 'edit_script'		||
				$_POST['option_page'] === 'edit_header'		||
				$_POST['option_page'] === 'edit_footer'		||
				$_POST['option_page'] === 'edit_analytics'	||
				$_POST['option_page'] === 'edit_analytics_head'	||
				$_POST['option_page'] === 'edit_functions'	||
				$_POST['option_page'] === 'edit_amp_body'	||
				$_POST['option_page'] === 'edit_amp'		||
				$_POST['option_page'] === 'edit_visual'		||
				$_POST['option_page'] === 'design_style'	||
				$_POST['option_page'] === 'design_amp'
			) {
				if( TPATH === SPATH ) return false;

				require_once( INC . 'optimize.php' );
				global $wp_filesystem;

				$filesystem = new thk_filesystem();
				if( $filesystem->init_filesystem( site_url() ) === false ) return false;

				$save_file = null;
				$save_content = '';

				switch( $_POST['option_page'] ) {
					case 'edit_style':
						$save_file = SPATH . DSEP . 'style.css';
						break;
					case 'edit_script':
						$save_file = SPATH . DSEP . 'luxech.js';
						break;
					case 'edit_header':
						$save_file = SPATH . DSEP . 'add-header.php';
						break;
					case 'edit_footer':
						$save_file = SPATH . DSEP . 'add-footer.php';
						break;
					case 'edit_analytics':
						thk_customize_result_set( 'analytics_position', 'radio' );
						$save_file = SPATH . DSEP . 'add-analytics.php';
						break;
					case 'edit_analytics_head':
						$save_file = SPATH . DSEP . 'add-analytics-head.php';
						break;
					case 'edit_functions':
						$save_file = SPATH . DSEP . 'functions.php';
						break;
					case 'edit_amp_body':
						thk_customize_result_set( 'amp_body_position', 'radio' );
						$save_file = SPATH . DSEP . 'add-amp-body.php';
						break;
					case 'edit_amp':
						$save_file = SPATH . DSEP . 'style-amp.css';
						break;
					case 'edit_visual':
						$save_file = SPATH . DSEP . 'editor-style.css';
						break;
					case 'design_style':
						if( isset( $luxe['design_file'] ) ) {
							$save_file = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . 'style.css';
						}
						break;
					case 'design_amp':
						if( isset( $luxe['design_file'] ) ) {
							$save_file = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . 'style-amp.css';
						}
						break;
					default:
						break;
				}

				if( isset( $save_file ) ) {
					$save_content .= isset( $_POST['newcontent'] ) ? $_POST['newcontent'] : '';
					$save_content = str_replace( "\r\n", "\n", $save_content );
					$save_content = stripslashes_deep( thk_convert( $save_content ) );

					$theme = wp_get_theme( get_stylesheet() );
					if( $_POST['option_page'] === 'edit_style' && $theme->errors() ) {
						add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'This theme is broken.', 'luxeritas' ) . ' ' . $theme->errors()->get_error_message(), 'error' );
						$err = true;
					}
					if( $filesystem->file_save( $save_file, $save_content ) === false ) {
						add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Error saving file.', 'luxeritas' ), 'error' );
						$err = true;
					}
				}
				else {
					// エラーメッセージ初期化
					global $wp_settings_errors;
					$wp_settings_errors = array();
					$err = true;
				}

				// CodeMirror の設定
				thk_customize_result_set( 'cm_line_numbers', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_autocomplete', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_lint', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_auto_indent', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_close_brackets', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_active_line', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_line_wrapping', 'checkbox', 'admin' );
				thk_customize_result_set( 'cm_indent_with_tabs', 'radio', 'admin' );
				thk_customize_result_set( 'cm_tab_size', 'number', 'admin' );
			}

			if( $_POST['option_page'] === 'backup_child' ) {
				if( TPATH === SPATH ) {
					add_settings_error( 'luxe-custom', $_POST['option_page'],
						__( 'The theme selected is not the child theme, but the parent theme', 'luxeritas' ) . '<br />' .
						__( 'This feature can only be used when the child theme is selected.', 'luxeritas' ),
					'error' );
				}
				$err = true;
			}

			/*
                         * ショートコードの中で CSS や Javascript が必要なもの
			 */
			$shortcodes = get_phrase_list( 'shortcode', false, true );

			// 吹き出し
			if( isset( $shortcodes['balloon_left'] ) || isset( $shortcodes['balloon_right'] ) ) {
				$_POST['balloon_enable'] = true;
				set_theme_mod( 'balloon_enable', true );
			}
			//else {
			//	remove_theme_mod( 'balloon_enable' );
			//}

			// シンタックスハイライター
			$highlighter = thk_syntax_highlighter_list();
			$highlighter_active = false;

			foreach( $shortcodes as $key => $val ) {
				if( isset( $highlighter[$key] ) ) {
					if( $highlighter_active === false ) $highlighter_active = true;
					set_theme_mod( $key, true );
				}
				else {
					remove_theme_mod( $key );
				}
			}

			if( $highlighter_active === true ) {
				set_theme_mod( 'highlighter_enable', true );
			}
			else {
				remove_theme_mod( 'highlighter_enable' );
			}

			if( $err === false ) {
				add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Changes are properly reflected', 'luxeritas' ), 'updated' );
			}

			thk_regenerate_files();
			thk_cleanup();
		}
	}

	if( isset( $_GET['page'] ) && ( $_GET['page'] === 'luxe' || substr( $_GET['page'], 0, 5 ) === 'luxe_' ) ) {
		if( isset( $_POST['amp_enable'] ) || get_theme_mod( 'amp_enable', false ) === true ) {
			$amp_css_size = 0;
			if( file_exists( TPATH . DSEP . 'style-amp.min.css' ) === true ) {
				$amp_css_size += (int)filesize( TPATH . DSEP . 'style-amp.min.css' );
			}
			if( TPATH !== SPATH && file_exists( SPATH . DSEP . 'style-amp.min.css' ) === true ) {
				$amp_css_size += (int)filesize( SPATH . DSEP . 'style-amp.min.css' );
			}
			if( isset( $_POST['hide_mobile_sidebar'] ) || get_theme_mod( 'hide_mobile_sidebar', false ) === true ) {
				// サイドバー非表示時の body #main{flex:none;float:none;max-width:100%;} 分の 49byte をプラス
				$amp_css_size += 49;
			}
			if( isset( $_POST['hide_mobile_footer'] ) || get_theme_mod( 'hide_mobile_footer', false ) === true ) {
				// フッター非表示時の body #foot-in{padding:0} 分の 25byte をプラス
				$amp_css_size += 25;
			}
			if( $amp_css_size > 50000 ) {
				add_settings_error( 'luxe-custom', 'amp-css', sprintf( __( 'Stylesheet for AMP is too long. we saw %s bytes whereas the limit is 50000 bytes.', 'luxeritas' ), $amp_css_size ), 'error' );
			}
		}
		if( isset( $_POST['site_logo'] ) || get_theme_mod( 'site_logo', null ) !== null ) {
			$site_logo = '';
			if( isset( $_POST['site_logo'] ) ) {
				$site_logo = $_POST['site_logo'];
			}
			else {
				$site_logo = get_theme_mod( 'site_logo', null );
			}
			$logo_info = thk_get_image_size( $site_logo );
			if( ( isset( $logo_info[0] ) && (int)$logo_info[0] > 600 ) || ( isset( $logo_info[1] ) && (int)$logo_info[1] > 60 ) ) {
				add_settings_error( 'luxe-custom', 'site-logo', sprintf( __( 'The %s logo is too large.', 'luxeritas' ), __( 'Site', 'luxeritas' ) ) . ' (' . __( '* the image must be within 600px width, height 60px.', 'luxeritas' ) . ')', 'error' );
			}
		}
		if( isset( $_POST['amp_logo_same'] ) || get_theme_mod( 'amp_logo_same', 'smae' ) !== 'same' ) {
			if( isset( $_POST['amp_logo'] ) || get_theme_mod( 'amp_logo', null ) !== null ) {
				$amp_logo = '';
				if( isset( $_POST['amp_logo'] ) ) {
					$amp_logo = $_POST['amp_logo'];
				}
				else {
					$amp_logo = get_theme_mod( 'amp_logo', null );
				}
				$logo_info = thk_get_image_size( $amp_logo );
				if( ( isset( $logo_info[0] ) && (int)$logo_info[0] > 600 ) || ( isset( $logo_info[1] ) && (int)$logo_info[1] > 60 ) ) {
					add_settings_error( 'luxe-custom', 'amp-logo', sprintf( __( 'The %s logo is too large.', 'luxeritas' ), 'AMP' ) . ' (' . __( '* the image must be within 600px width, height 60px.', 'luxeritas' ) . ')', 'error' );
				}
			}
		}
	}

	/*
	 * file permission and owner check
	 */
	add_action( 'admin_notices', function() {
		global $luxe, $wp_actions;

		$filesystem = null;
		$dir_check  = true;

		// directories
		if( wp_is_writable( ABSPATH ) === false ) {
			_is_writable_error_msg( ABSPATH );
		}

		if( wp_is_writable( TPATH ) === false ) {
			_is_writable_error_msg( TPATH );
			$dir_check = false;
		}
		else {
			if( wp_is_writable( TPATH . DSEP . 'js' ) === false ) {
				_is_writable_error_msg( TPATH . DSEP . 'js' );
				$dir_check = false;
			}
		}
		if( TDEL !== SDEL ) {
			if( wp_is_writable( SPATH ) === false ) {
				_is_writable_error_msg( SPATH );
				$dir_check = false;
			}
		}

		// files
		if( $dir_check === true ) {
			$files = array(
				TPATH . DSEP . 'style.min.css',
				TPATH . DSEP . 'style.async.min.css',
				TPATH . DSEP . 'js' . DSEP . 'luxe.min.js',
				TPATH . DSEP . 'js' . DSEP . 'luxe.async.min.js'
			);

			// AMP
			if( isset( $luxe['amp_enable'] ) ) {
				$files[] = TPATH . DSEP . 'style-amp.min.css';
			}

			// 子テーマ
			if( TDEL !== SDEL ) {
				if( isset( $luxe['child_css'] ) ) {
					// 子テーマ CSS
					if( $luxe['child_css_compress'] !== 'none' ) $files[] = SPATH . DSEP . 'style.min.css';
				}
				if( !isset( $luxe['child_script'] ) ) {
					// 子テーマ Javascript
					if( $luxe['child_js_compress'] !== 'none' ) $files[] = SPATH . DSEP . 'luxech.min.js';
				}
				if( isset( $luxe['amp_enable'] ) ) {
					// 子テーマ AMP
					$files[] = SPATH . DSEP . 'style-amp.min.css';
				}
			}

			// jQuery
			if( $luxe['jquery_load'] === 'luxeritas' ) {
				$files[] = TPATH . DSEP . 'js' . DSEP . 'jquery.luxe.min.js';
			}

			foreach( $files as $val ) {
				if( file_exists( $val ) === false ) {
					if( class_exists( 'thk_filesystem' ) === false ) require( INC . 'optimize.php' );

					global $wp_filesystem;
					if( $filesystem === null ) {
						$filesystem = new thk_filesystem();
						$filesystem->init_filesystem();
					}

					$wp_filesystem->touch( $val );
					if( file_exists( $val ) === false || ( file_exists( $val ) === true && wp_is_writable( $val ) === false ) ) {
						_is_writable_error_msg( $val );
					}
					if( file_exists( $val ) === true ) $wp_filesystem->delete( $val );
				}
				elseif( file_exists( $val ) === true && wp_is_writable( $val ) === false ) {
					_is_writable_error_msg( $val );
				}
			}
		}

		// Luxeritas と Jetpack の LazyLoad が競合してる場合に管理画面で警告を出す
		foreach( $wp_actions as $key => $value ) {
			if( stripos( $key, 'jetpack_' ) === 0 ) {
				$luxe['fucking_jetpack'] = true;
				break;
			}
		}

		if( isset( $luxe['fucking_jetpack'] ) ) {
			$jetpack_active_modules = get_option('jetpack_active_modules');
			if( in_array( 'lazy-images', (array)$jetpack_active_modules, true ) === true ) {
				$jetpack_lazy_images = true;
			}

			if( isset( $jetpack_lazy_images ) ) {
				if( !isset( $luxe['disable_jetpack_lazyload'] ) && ( isset( $luxe['lazyload_thumbs'] ) || isset( $luxe['lazyload_contents'] ) || isset( $luxe['lazyload_avatar'] ) || isset( $luxe['lazyload_sidebar'] ) || isset( $luxe['lazyload_footer'] ) ) ) {
					echo '<div class="notice notice-warning is-dismissible"><p><a id="disable_jetpack_lazyload_msg" href="', admin_url( 'admin.php?page=luxe&active=others#disable_jetpack_lazyload' ), '">', __( 'Jetpack plugin and Luxeritas theme&apos;s Lazy Load function conflict.', 'luxeritas' ), '</a></p></div>';
				}
			}
			if( !isset( $luxe['disable_jetpack_ogp'] ) && ( isset( $luxe['facebook_ogp_enable'] ) || isset( $luxe['twitter_card_enable'] ) ) ) {
				echo '<div class="notice notice-warning is-dismissible"><p><a id="disable_jetpack_ogp_msg" href="', admin_url( 'admin.php?page=luxe&active=ogp#disable_jetpack_ogp' ), '">', __( 'Jetpack plugin and Luxeritas theme&apos;s OGP conflict.', 'luxeritas' ), '</a></p></div>';
			}
		}
		else {
			remove_theme_mod( 'disable_jetpack_ogp' );
			remove_theme_mod( 'disable_jetpack_lazyload' );
		}
	});
}, 10 );

add_action( 'init', function() {
	if( isset( $_GET['page'] ) && ( $_GET['page'] === 'luxe_man' || $_GET['page'] === 'luxe_design' ) && isset( $_POST['_wpnonce'] ) && isset( $_POST['option_page'] ) ) {
		if( check_admin_referer( $_POST['option_page'] . '-options', '_wpnonce' ) ) {
			// AMP のリライトルール追加
			if( $_POST['option_page'] === 'amp' ) {
				require( INC . 'rewrite-rules.php' );
				thk_add_endpoint();
			}

			if( $_POST['option_page'] === 'backup' || $_POST['option_page'] === 'backup_appearance' || $_POST['option_page'] === 'backup_child' ) {
				require( INC . 'backup.php' );
			}

			// サムネイル一括再構築
			if( $_POST['option_page'] === 'thumbnail' && isset( $_POST['init_process'] ) ) {
				if( isset( $_POST['regen_thumbs'] ) ) {
					add_action( 'shutdown', function() {
						echo '<script>jQuery("#regen_stop").css( "display", "inline-block" );</script>';
					}, 90 );
					require( INC . 'regenerate-thumbnail.php' );
					$regenerate = new thk_regenerate_thumbs();
					$regenerate->regen_thumbs();
				}
			}
		}
	}

	if( isset( $_GET['page'] ) && $_GET['page'] === 'luxe_sns' && isset( $_POST['_wpnonce'] ) && isset( $_POST['option_page'] ) ) {
		if( check_admin_referer( $_POST['option_page'] . '-options', '_wpnonce' ) ) {
			// SNS カウントキャッシュ CSV ダウンロード
			if( $_POST['option_page'] === 'sns_csv' ) {
				require_once( INC . 'optimize.php' );
				global $wp_filesystem;

				$filesystem = new thk_filesystem();
				if( $filesystem->init_filesystem( site_url() ) === false ) return false;

				$lst = array();
				$feed = 0;

				$wp_upload_dir = wp_upload_dir();
				$cache_dir = $wp_upload_dir['basedir'] . '/luxe-sns/';

				foreach( glob( $cache_dir. '*' ) as $val ) {
					$content = $wp_filesystem->get_contents( $val );
					$content = str_replace( "\n", ',', $content );
					$content = str_replace( home_url('/'), '/', $content );
					if( stripos( $content, ',' . 'r:' ) !== false ) {
						$tmp = explode( 'r:', $content );
						$feed = isset( $tmp[1] ) ? trim( $tmp[1], ',' ) : 0;
					}
					else {
						$content = str_replace( array( ',f:', ',g:', ',h:', ',l:', ',p:' ), ',', $content );
						$lst[] = $content;
					}
				}
				sort( $lst );

				$file = 'luxe-sns-count.csv';
				@ob_start();
				@header( 'Content-Description: File Transfer' );
				@header( 'Content-Type: text/csv; charset=' . get_option( 'blog_charset' ) );
				@header( 'Content-Disposition: attachment; filename=' . basename( $file ) );
				echo "URL,Facebook,Google+,Hatena,LinkedIn,Poket,Feedly\n";
				foreach( $lst as $val ) {
					echo $val . $feed . "\n";
				}
				@ob_end_flush();
				exit;
			}

			// SNS カウントキャッシュ一括取得
			if( $_POST['option_page'] === 'sns_get' ) {
				if( isset( $_POST['sns_get'] ) ) {
					add_action( 'shutdown', function() {
						echo '<script>jQuery("#sns_get_stop").css( "display", "inline-block" );</script>';
					}, 90 );
					require( INC . 'sns-cache-all-get.php' );
					$all_get = new sns_cache_all_get();
					$all_get->sns_cache_list();
				}
			}
		}
	}
}, 11 );

/*---------------------------------------------------------------------------
 * テーマ無効化時に AMP のリライトルール削除 & manifest 削除
 *---------------------------------------------------------------------------*/
add_action( 'switch_theme', function() {
	global $wp_rewrite, $wp_filesystem;

	foreach( $wp_rewrite->endpoints as $key => $val ) {
		if ( $val === 'amp' ) {
			unset( $wp_rewrite->endpoints[$key] );
		}
	}
	$wp_rewrite->flush_rules();

	if( file_exists( ABSPATH . 'luxe-manifest.json' ) === true ) {
		require_once( INC . 'optimize.php' );
		$filesystem = new thk_filesystem();
		if( $filesystem->init_filesystem( site_url() ) === false ) return false;
		$wp_filesystem->delete( ABSPATH . 'luxe-manifest.json' );
	}
});

/*---------------------------------------------------------------------------
 * カスタマイズ内容の変更を DB に書き込む (サニタイズ込み)
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_customize_result_set' ) === false ):
function thk_customize_result_set( $key, $type, $target = null ) {
	global $luxe_defaults;

	$set_theme_mod = 'set_theme_mod';
	$remove_theme_mod = 'remove_theme_mod';

	if( $target === 'admin' ) {
		$set_theme_mod = 'set_theme_admin_mod';
		$remove_theme_mod = 'remove_theme_admin_mod';
	}
	elseif( $target === 'phrase' ) {
		$set_theme_mod = 'set_theme_phrase_mod';
		$remove_theme_mod = 'remove_theme_phrase_mod';
	}

	if( $type === 'checkbox' ) {
		if( isset( $_POST[$key] ) && $luxe_defaults[$key] != true ) {
			$set_theme_mod( $key, true );
		}
		elseif( !isset( $_POST[$key] ) && $luxe_defaults[$key] != false ) {
			$set_theme_mod( $key, false );
		}
		else {
			$remove_theme_mod( $key );
		}
	}
	elseif( $type === 'text' || $type === 'number' || $type === 'range' || $type === 'textarea' || $type === 'radio' || $type === 'select' ) {
		$post_key = isset( $_POST[$key] ) ? $_POST[$key] : '';

		if( $type === 'range' || $type === 'number' ) {
			if( is_numeric( $post_key ) === true ) {
				$post_key = round( $post_key );
			}
			else {
				$post_key = '';
			}
		}

		if( $post_key != $luxe_defaults[$key] ) {
			$post_key = stripslashes( $post_key );

			if( $type === 'textarea' ) {
				$set_theme_mod( $key, str_replace( "\n", '<br />', esc_attr( $post_key ) ) );
			}
			else {
				$set_theme_mod( $key, esc_attr( $post_key ) );
			}
		}
		else {
			$remove_theme_mod( $key );
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * value の値 (もしくは checked や selected) をチェックして HTML に挿入
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_value_check' ) === false ):
function thk_value_check( $key, $type, $default = null, $echo = true ) {
	global $luxe;
	$ret = '';

	if( isset( $_POST['init_process'] ) ) unset( $_POST );

	if( $type === 'checkbox' ) {
		if( isset( $_POST[$key] ) ) {
			$ret = ' checked="checked"';
		}
		elseif( !isset( $_POST[$key] ) && isset( $_POST['action'] ) ) {
			$ret = '';
		}
		elseif( isset( $luxe[$key] ) ) {
			$ret = ' checked="checked"';
		}
		elseif( isset( $_REQUEST['active'] ) && $_REQUEST['active'] === 'widget' ) {
			if( get_theme_mod( $key, null ) ) {
				$ret = ' checked="checked"';
			}
		}
	}
	elseif( $type === 'radio' || $type === 'select' ) {
		if( isset( $_POST['action'] ) ) {
			if( isset( $_POST[$key] ) && $_POST[$key] == $default ) {
				$ret = $type === 'radio' ? ' checked="checked"' : ' selected="selected"';
			}
		}
		else {
			if( isset( $luxe[$key] ) && $luxe[$key] == $default ) {
				$ret = $type === 'radio' ? ' checked="checked"' : ' selected="selected"';
			}
		}
	}
	elseif( $type === 'text' || $type === 'number' || $type === 'range' || $type === 'hidden' ) {
		if( isset( $_POST[$key] ) ) {
			$ret = $type === 'text' ? stripslashes( $_POST[$key] ) : $_POST[$key];
		}
		else {
			$ret = isset( $luxe[$key] ) ? $luxe[$key] : '';
		}
		$ret = esc_attr( $ret );
	}
	elseif( $type === 'textarea' ) {
		if( isset( $_POST[$key] ) ) {
			$ret = stripslashes( $_POST[$key] );
		}
		else {
			$ret = isset( $luxe[$key] ) ? str_replace( '<br />', "\n", $luxe[$key] ) : '';
		}
		$ret = esc_attr( $ret );
	}

	if( $echo === false ) return $ret;
	echo $ret;
}
endif;

/*---------------------------------------------------------------------------
 * ZIP ファイルのダウンロード
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_zip_file_download' ) === false ):
function thk_zip_file_download( $path, $fname, $path_del = false ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	$zip_file = '';
	//$temp = tempnam( sys_get_temp_dir(), 'luxe' );
	//$temp = tempnam( get_temp_dir(), 'luxe' );
	$temp = wp_tempnam( 'luxe' );

	if( file_exists( $temp ) === false ) {
		echo	'<div class="error"><p>',
			__( 'Failed to create temporary file with PHP. Check the setting of &quot;upload_tmp_dir&quot; in PHP.', 'luxeritas' ) . '<br />' . $temp,
			'</p></div>';
	}
	else {
		require_once( INC . 'optimize.php' );
		require( INC . 'thk-zip.php' );

		global $wp_filesystem;

		$filesystem = new thk_filesystem();
		if( $filesystem->init_filesystem( site_url() ) === false ) return false;

		$zip = new thk_zip_compress();
		$success = $zip->all_zip( $path, $temp );

		if( $success === true ) {
			$zip_file = $wp_filesystem->get_contents( $temp );
			$wp_filesystem->delete( $temp );

			// ファイル名に使えない文字があったら置換
			$fname = preg_replace( '/\\s/u', '_', $fname );
			$fname = str_replace( array( '\\','/',':','*','?','"','<','>','|' ), '_', $fname );

			mb_http_output("pass");
			@ob_start();
			@header( 'Content-Description: File Transfer' );
			//@header( 'Content-Type: application/zip;' . get_option( 'blog_charset' ) );
			@header( 'Content-Type: application/zip' );
			@header( "Content-Disposition: attachment; filename*=UTF-8''" . rawurlencode( $fname ) );
			echo $zip_file;
			@ob_end_flush();

			if( $path_del === true ) {
				$wp_filesystem->delete( $path, true );
			}
			exit;
		}
		else {
			if( $path_del === true ) {
				$wp_filesystem->delete( $path, true );
			}
			echo '<div class="error"><p>', $success, '</p></div>';
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * 管理画面で Widget などに変更が加わった時の処理
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_options_modify' ) === false ):
function thk_options_modify() {
	global $luxe;

	require( INC . 'custom-css.php' );
	require( INC . 'compress.php' );

	add_filter( 'updated_option', 'thk_compress', 75 );
	add_filter( 'updated_option', 'thk_parent_css_bind', 80 );
	add_filter( 'updated_option', 'thk_child_js_comp', 80 );
	add_filter( 'updated_option', 'thk_create_inline_style', 85 );
}
endif;

/*---------------------------------------------------------------------------
 * admin_enqueue_scripts
 *---------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', function() {
	if( isset( $_GET['page'] ) && ( $_GET['page'] === 'luxe_man' ) ) {
		// エディタ設定画面で必要な CSS 等
		if( !isset( $_GET['active'] ) || ( isset( $_GET['active'] ) && $_GET['active'] === 'editor' ) ) {
			wp_enqueue_script( 'thk-sortable', TURI . '/js/sortable.min.js' );
			wp_enqueue_style( 'editor', site_url('/') . WPINC . '/css/editor.min.css' );
			wp_enqueue_style( 'tinymce', site_url('/') . WPINC . '/js/tinymce/skins/lightgray/skin.min.css' );
		}
	}
});

/*---------------------------------------------------------------------------
 * admin_head
 *---------------------------------------------------------------------------*/
add_action( 'admin_head', function() {
	global $luxe;

	// TinyMCE settings
	if( stripos( $_SERVER['REQUEST_URI'], 'wp-admin/post' ) !== false ) {
		if( get_user_option( 'rich_editing' ) === 'true' ) {
			require( INC . 'tinymce-settings.php' );
		}
	}

	// Web フォント CSS の存在チェック
	if( isset( $_GET['page'] ) && ( $_GET['page'] === 'luxe' || substr( $_GET['page'], 0, 5 ) === 'luxe_' ) ) {
		if( !isset( $luxe['all_clear'] ) ) {
			require_once( INC . 'web-font.php' );
			$web_font_dir = TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP;

			if( isset( Web_Font::$webfont[$luxe['font_alphabet']] ) ) {
				if( file_exists( $web_font_dir . $luxe['font_alphabet'] ) === false ) {
					if( function_exists( 'add_settings_error' ) === true ) {
						add_settings_error(
							'luxe-custom', '',
							sprintf(
								__( 'Web font CSS Not Found.<br />%s It seems that CSS download of the font failed. Please reset web font.', 'luxeritas' ),
								$luxe['font_alphabet']
							)
						);
					}
				}
			}
			if( isset( Web_Font::$webfont[$luxe['font_japanese']] ) ) {
				if( file_exists( $web_font_dir . $luxe['font_japanese'] ) === false ) {
					if( function_exists( 'add_settings_error' ) === true ) {
						add_settings_error(
							'luxe-custom', '',
							sprintf(
								__( 'Web font CSS Not Found.<br />%s It seems that CSS download of the font failed. Please reset web font.', 'luxeritas' ),
								$luxe['font_japanese']
							)
						);
					}
				}
			}
		}
	}

	$admin_inline_styles = '';

	/* メニューのアイコンを青くするスタイル */
	$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/admin-menu.css' );

	/* luxeritas のカスタマイズ画面を開いた時だけ読み込み */
	if( isset( $_GET['page'] ) && ( strpos( $_GET['page'], 'luxe' ) !== false || strpos( $_GET['page'], 'luxe_edit' ) !== false ) ) {
		$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/admin-customize.css' );
	}

	/* デザインファイルのページを開いたときだけ読み込み */
	if( isset( $_GET['page'] ) && $_GET['page'] === 'luxe_design' ) {
		$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/design.css' );
	}

	/* SNS カウンターのページを開いたときだけ読み込み */
	if( isset( $_GET['page'] ) && $_GET['page'] === 'luxe_sns' ) {
		$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/admin-sns-view.css' );
	}

	/* Code Mirror */
	if(
		isset( $_GET['page'] ) &&
		(
			$_GET['page'] === 'luxe_edit' ||
			(
				$_GET['page'] === 'luxe_design' && isset( $_GET['active'] ) &&
				( $_GET['active'] === 'design_style' || $_GET['active'] === 'design_amp' )
			)
		)
	) {
		$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/thk-codemirror.css' );

		if( version_compare( $GLOBALS['wp_version'], '4.9', '>=' ) === true ) {
			wp_enqueue_editor();
			wp_enqueue_script( 'wp-theme-plugin-editor' );

			$codemirror = array(
				'tabSize'		=> 8,
				'indentUnit'		=> 8,
				'indentWithTabs'	=> true,
				'inputStyle'		=> 'contenteditable',
				'lineNumbers'		=> true,
				'lineWrapping'		=> false,
				'styleActiveLine'	=> true,
				'continueComments'	=> true,
				'extraKeys' => array(
					'Ctrl-Space'	=> 'autocomplete',
					'Ctrl-Alt-/'	=> 'toggleComment',
					'Ctrl-Alt-F'	=> 'findPersistent',
					'Ctrl-Alt-D'	=> 'replace',
					'Ctrl-Z'	=> 'undo',
					'Ctrl-Y'	=> 'redo',
				),
				'direction'	=> 'ltr',
				//'gutters'	=> array(),
			);

			if( !isset( $luxe['cm_line_numbers'] ) )	$codemirror['lineNumbers']	= false;
			if( !isset( $luxe['cm_lint'] ) )		$codemirror['lint']		= false;
			if( !isset( $luxe['cm_indent_with_tabs'] ) )	$codemirror['indentWithTabs']	= false;
			if( !isset( $luxe['cm_auto_indent'] ) )		$codemirror['smartIndent']	= false;
			if( !isset( $luxe['cm_close_brackets'] ) )	$codemirror['autoCloseBrackets']= false;
			if( !isset( $luxe['cm_active_line'] ) )		$codemirror['styleActiveLine']	= false;
			if( isset( $luxe['cm_line_wrapping'] ) )	$codemirror['lineWrapping']	= true;
			if( isset( $luxe['cm_indent_with_tabs'] ) && $luxe['cm_indent_with_tabs'] !== 'tabs' ) {
				$codemirror['indentWithTabs']	= false;
			}
			if( isset( $luxe['cm_tab_size'] ) && $luxe['cm_tab_size'] !== 8 ) {
				$codemirror['tabSize']		= $luxe['cm_tab_size'];
				$codemirror['indentUnit']	= $luxe['cm_tab_size'];
			}
			if( !isset( $luxe['cm_autocomplete'] ) ) {
				echo '<style>ul.CodeMirror-hints{display:none!important;}</style>', "\n";
			}

			$args = array(
				'type' => 'text/css',
				'codemirror' => $codemirror,
			);

			if( isset( $_GET['active'] ) ) {
				switch( $_GET['active'] ) {
					case 'edit_header':
					case 'edit_footer':
					case 'edit_analytics':
					case 'edit_analytics_head':
					case 'edit_amp_body':
					case 'edit_functions':
						$args['type'] = 'application/x-httpd-php';
						break;
					case 'edit_script':
						$args['type'] = 'application/javascript';
						break;
					default:
						break;
				}
			}

			$settings = wp_enqueue_code_editor( $args );

			wp_add_inline_script(
				'wp-theme-plugin-editor',
				sprintf( 'jQuery( function( $ ) { wp.themePluginEditor.init( $( "#template" ), %s ); } );', wp_json_encode( $settings ) )
			);
			wp_add_inline_script( 'wp-theme-plugin-editor', 'wp.themePluginEditor.themeOrPlugin = "theme";' );
		}
	}

	echo '<style>', thk_simple_css_minify( $admin_inline_styles ), '</style>';

	// Site Icon
	if( has_site_icon() === false ) {
		// favicon.ico
		if( file_exists( SPATH . DSEP . 'images' . DSEP . 'favicon.ico' ) ) {
?>
<link rel="icon" href="<?php echo SURI; ?>/images/favicon.ico" />
<?php
		}
		else {
?>
<link rel="icon" href="<?php echo TURI; ?>/images/favicon.ico" />
<?php
		}
	}
}, 99 );

/*---------------------------------------------------------------------------
 * カテゴリの「説明」で HTML タグを使えるようにする
 *---------------------------------------------------------------------------*/
/* Disables Kses only for textarea saves */
foreach( array( 'pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description' ) as $filter ) {
	remove_filter( $filter, 'wp_filter_kses' );
}

/* Disables Kses only for textarea admin displays */
foreach( array( 'term_description', 'link_description', 'link_notes', 'user_description') as $filter ) {
	remove_filter( $filter, 'wp_kses_data' );
}

/*---------------------------------------------------------------------------
 * AMP 用 MU プラグインをコピー
 *---------------------------------------------------------------------------*/
if ( function_exists( 'thk_amp_mu_plugin_copy' ) === false ):
function thk_amp_mu_plugin_copy() {
	if ( function_exists( 'get_plugin_data' ) === false ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
	}

	$src = INC . 'luxe-amp-mu.php';
	$dst = WPMU_PLUGIN_DIR . '/luxe-amp-mu.php';
	$sv = 0;
	$dv = 0;

	if( file_exists( $dst ) === true ) {
		$s = get_plugin_data( $src );
		$d = get_plugin_data( $dst );

		$sv = isset( $s['Version'] ) ? $s['Version'] : 0;
		$dv = isset( $d['Version'] ) ? $d['Version'] : 0;
	}

	if( file_exists( $dst ) === false || $sv !== $dv ) {
		if( file_exists( WPMU_PLUGIN_DIR ) === false ) {
			if( wp_mkdir_p( WPMU_PLUGIN_DIR ) === false ) {
				global $wp_filesystem;

				require_once( INC . 'optimize.php' );
				$_filesystem = new thk_filesystem();
				if( $_filesystem->init_filesystem() === false ) return false;

				if( $wp_filesystem->is_dir( WPMU_PLUGIN_DIR ) === false ) {
					$wp_filesystem->mkdir( WPMU_PLUGIN_DIR, FS_CHMOD_DIR );
				}
			}
		}
		if( @copy( $src, $dst ) === false ) {
			return false;
		}
	}
}
endif;

/*---------------------------------------------------------------------------
 * Mime type 追加
 *---------------------------------------------------------------------------*/
add_filter( 'upload_mimes', function( $mimes ) {
	$mimes['json'] = 'application/json';
	//$mimes['webp'] = 'image/webp';
	return $mimes;
});

/*---------------------------------------------------------------------------
 * ファイル/ディレクトリに書き込み権限がない場合のエラーメッセージ
 *---------------------------------------------------------------------------*/
if( function_exists( '_is_writable_error_msg' ) === false ):
function _is_writable_error_msg( $file_name, $echo = true ) {
	$msg =
		__( 'You do not have permission to create and save files.', 'luxeritas' ) . '<br />' .
		__( 'Please check the owner and permissions of the following file or directory.', 'luxeritas' ) . '<br />' . $file_name
	;
	if( $echo === true ) {
		printf( '<div class="error"><p>%s</p></div>', $msg );
	}
	else {
		return $msg;
	}
}
endif;

/*---------------------------------------------------------------------------
 * JSON のエラーメッセージ ( json_last_error_msg だと日本語返してくれんから )
 *---------------------------------------------------------------------------*/
if( function_exists( 'json_error_code_to_msg' ) === false ):
function json_error_code_to_msg( $code ) {
	switch( $code ) {
		case JSON_ERROR_DEPTH:
			return ' : ' . __( 'Maximum stack depth exceeded.', 'luxeritas' );
			break;
		case JSON_ERROR_STATE_MISMATCH:
			return ' : ' . __( 'Underflow or the modes mismatch.', 'luxeritas' );
			break;
		case JSON_ERROR_CTRL_CHAR:
			return ' : ' . __( 'Unexpected control character found.', 'luxeritas' );
			break;
		case JSON_ERROR_SYNTAX:
			return ' : ' . __( 'Syntax error, malformed JSON.', 'luxeritas' );
			break;
		case JSON_ERROR_UTF8:
			return ' : ' . __( 'Malformed UTF-8 characters, possibly incorrectly encoded.', 'luxeritas' );
			break;
	}
	if( version_compare( PHP_VERSION, '5.5.0', '>=' ) === true ) {
		switch( $code ) {
			case JSON_ERROR_RECURSION:
				return ' : ' . __( 'One or more recursive references in the value to be encoded.', 'luxeritas' );
				break;
			case JSON_ERROR_INF_OR_NAN:
				return ' : ' . __( 'One or more NAN or INF values in the value to be encoded.', 'luxeritas' );
				break;
			case JSON_ERROR_UNSUPPORTED_TYPE:
				return ' : ' . __( 'A value of a type that cannot be encoded was given.', 'luxeritas' );
				break;
		}
	}
	return JSON_ERROR_NONE;
}
endif;

/*---------------------------------------------------------------------------
 * add menu page -> luxe menu page
 *---------------------------------------------------------------------------*/
if( function_exists( 'luxe_menu_page' ) === false ):
function luxe_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null ) {
	$func = 'add_' . 'menu_' . 'page';
	$hookname = $func( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	return $hookname;
}
endif;

/*---------------------------------------------------------------------------
 * add submenu page -> luxe submenu page
 *---------------------------------------------------------------------------*/
if( function_exists( 'luxe_submenu_page' ) === false ):
function luxe_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' ) {
	$func = 'add_' . 'submenu_' . 'page';
	$hookname = $func( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	return $hookname;
}
endif;

/*---------------------------------------------------------------------------
 * dummy function
 *---------------------------------------------------------------------------*/
require_once( INC . 'code-change.php' );
if( function_exists('d_init') === false ):
function d_init() {
	//add_theme_support( 'post-formats' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	get_post_format();
}
endif;

if( function_exists( 'd_pagination' ) === false ):
function d_pagination() {
	posts_nav_link();
	next_comments_link();
	previous_comments_link();
	paginate_comments_links();
}
endif;
